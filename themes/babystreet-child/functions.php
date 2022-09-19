<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_styles() {

	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

	wp_enqueue_style( 'child-style',

		get_stylesheet_directory_uri() . '/style.css',

		array( 'parent-style' )

	);

    wp_enqueue_style( '-animation-style',get_stylesheet_directory_uri() . '/css/animation.min.css');


wp_enqueue_script( 'wow-js-script',get_stylesheet_directory_uri() . '/js/wow.min.js');



	if ( is_rtl() ) {

		wp_enqueue_style( 'parent-rtl', get_template_directory_uri() . '/rtl.css' );

		wp_enqueue_style( 'child-rtl',

			get_stylesheet_directory_uri() . '/rtl.css',

			array( 'parent-rtl' )

		);

	}



	wp_enqueue_script( 'child-babystreet-front',

		get_stylesheet_directory_uri() . '/js/babystreet-front.js',

		array( 'babystreet-front' ),

		false,

		true

	);

}

if (!function_exists('babystreet_language_selector_names')) {



	function babystreet_language_selector_names() {

		$languages = icl_get_languages('skip_missing=0&orderby=code');

		// echo "<pre>";
		// print_r($languages);


		if (!empty($languages)) {

			foreach ($languages as $l) {

				if (!$l['active']) {
					$current_lan =  '';
				}else{
					$current_lan =  'active';
				}
					echo '<a  class="'.$current_lan.'" title="' . esc_attr($l['native_name']) . '" href="' . esc_url($l['url']) . '">';


				//echo '<img src="' . esc_url($l['country_flag_url']) . '" height="12" alt="' . esc_attr($l['language_code']) . '" width="18" />';
				//echo $l['native_name'].' ('.$l['translated_name'].')';
				echo $l['native_name'];

					echo '</a>';

			}

		}

	}

}

add_shortcode( 'product_paycut_filter', 'wpdocs_bartag_func' );
function wpdocs_bartag_func( $atts ) {
 $filter_html = '';
$pa_brands = get_terms( array(
    'taxonomy' => 'pa_brand',
    'hide_empty' => false,
) );
$product_categories = get_terms( array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false,	

) );
$filter_html .='<form action="'.site_url().'/wp-admin/admin-ajax.php" id="filter_paycut" method="post" >';
$filter_html .='<div class="payment-main-wrapper">';
$filter_html .='<div class="payment-header">';
$filter_html .='<div class="brand-filed">';
$filter_html .='<label>Brand</label>';
$filter_html .='<select name = "brand" id="brand">';
$filter_html .='<option disabled selected>Search for a brand</option>';
				foreach ($pa_brands as $pa_brand) {
					$filter_html .='<option value="'.$pa_brand->term_id.'">'.$pa_brand->name.'</option>';
				}
$filter_html .='</select>';
$filter_html .='</div>';
$filter_html .='<div class="category-filed">';
$filter_html .='<label>Category</label>';
$filter_html .='<select name = "p_cat" id="p_cat" disabled>';
$filter_html .='<option value="" disabled selected>Search for a category</option>';
				foreach ($product_categories as $product_cat) {
					$filter_html .='<option value="'.$product_cat->term_id.'">'.$product_cat->name.'</option>';
				}
$filter_html .='</select>';
$filter_html .='</div>';
$filter_html .='<div class="btn-filed">';
$filter_html .='<button type="submit" class="calculate-btn" id="submit" disabled>Calculate</button>';
$filter_html .='</div>';
$filter_html .='</div>';
$filter_html .='<input type="hidden" name="action" value="myfilter">';
$filter_html .= '<div id="response"></div>';
$filter_html .= '</div>';
$filter_html .= '</form>';
return $filter_html;   
}


add_action('wp_ajax_myfilter', 'misha_filter_function'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_myfilter', 'misha_filter_function');

function misha_filter_function()
{
	
 $category = get_term( $_POST['p_cat'], 'product_cat' );
 $brands = get_term( $_POST['brand'], 'pa_brand' );
// echo "<pre>";
// 	print_r($category);
	$args = array(
		'orderby' => 'date', // we will sort posts by date
		'order'	=> 'ASC', // ASC or DESC
		'post_status'    => 'publish',
		'post_type' => 'product',
		'tax_query'        => array (
        'relation' => 'OR',
        array(
            'taxonomy'        => 'pa_brand',
        	'field'           => 'term_id',
        	'terms'           =>  $_POST['brand'],
        ),
        array(
            'taxonomy'        => 'product_cat',
        	'field'           => 'term_id',
        	'terms'           =>  $_POST['p_cat'],
        ),
    ),
	);

 $products = new WP_Query( $args );
//  echo "<pre>";
//         print_r($products);
//         die();
echo '<div class="payment-body">';
echo '<h3 class="payment-body-title"><p>'.$brands->name .' '. $category->name.'</p></h3>';
echo '<h4 class="payment-body-subtitle">90-day listing window</h4>';
echo '<div class="payment-item-listing">';
if ( $products->have_posts() ): while ( $products->have_posts() ):
 			$products->the_post();
		
		echo '<div class="payment-item">';
		echo '<a href="'.esc_url($featured_img_url).'">';
						the_post_thumbnail('thumbnail');
		echo '</a>';
		echo '<h5>' . $products->post->post_title . '</h5>';
		$_product = wc_get_product( get_the_ID() );
        $commission_id = get_post_meta(get_the_ID(), 'wcv_commission_percent', true);
        $commission_rate = $_product->get_price() * $commission_id / 100 ;
        // echo "<pre>";
        // print_r($commission_rate);
        // die();
		echo '<p>  Est. Listing Price: '.wc_price($_product->get_price()).'</p>';
        echo '<p>  Est. Payout ('.$commission_id.'%): '.wc_price($commission_rate).' </p>';
		
		echo '</div>';
endwhile;
	wp_reset_postdata();
else :
	echo 'No posts found';
endif;	
echo '</div>';	
echo '</div>';
	die();
}
// Our custom post type function
function create_advertisements_posttype() {
 
    register_post_type( 'advertisements',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Advertisements' ),
                'singular_name' => __( 'Advertisement' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'advertisements'),
            'show_in_rest' => true,
 
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_advertisements_posttype' );

function custom_advertisements_post_type() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Advertisements', 'Post Type General Name', 'babystreet-child' ),
        'singular_name'       => _x( 'Advertisement', 'Post Type Singular Name', 'babystreet-child' ),
        'menu_name'           => __( 'Advertisements', 'babystreet-child' ),
        'parent_item_colon'   => __( 'Parent Advertisement', 'babystreet-child' ),
        'all_items'           => __( 'All Advertisements', 'babystreet-child' ),
        'view_item'           => __( 'View Advertisement', 'babystreet-child' ),
        'add_new_item'        => __( 'Add New Advertisement', 'babystreet-child' ),
        'add_new'             => __( 'Add New', 'babystreet-child' ),
        'edit_item'           => __( 'Edit Advertisement', 'babystreet-child' ),
        'update_item'         => __( 'Update Advertisement', 'babystreet-child' ),
        'search_items'        => __( 'Search Advertisement', 'babystreet-child' ),
        'not_found'           => __( 'Not Found', 'babystreet-child' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'babystreet-child' ),
    );

	// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'advertisements', 'babystreet-child' ),
        'description'         => __( 'Movie news and reviews', 'babystreet-child' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title','thumbnail'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'category' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
 
    );
     
    // Registering your Custom Post Type
    register_post_type( 'advertisements', $args );
 
}
 
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'custom_advertisements_post_type', 0 );

function wpbsearchform( $form ) {

    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <div><label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </div>
    </form>';

    return $form;
}

add_shortcode('wpbsearch', 'wpbsearchform');
?>