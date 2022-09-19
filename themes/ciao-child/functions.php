<?php
/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

 add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
  function theme_enqueue_styles() {
  		wp_enqueue_script( 'ciao-front-child',site_url() . '/wp-content/themes/ciao-child/js/ciao-front.js',	array(),false,true);
		wp_enqueue_script( 'ciao-custom',site_url() . '/wp-content/themes/ciao-child/js/custom.js',	array(),false,true);
 }
 
// To Move price underneath title use code 
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );  
// remove action which show Price on their default location
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 6); 
// add action with Priority just more than the woocommerce_template_single_title


remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 8);

add_action( 'woocommerce_shop_loop_item_title', 'add_brands_in_loop', 5, 0 ); 


function add_brands_in_loop(){
			global $product;

			$current_product_id = yit_get_product_id( $product );

			// retrieve data to use in template
			$brands_taxonomy    = 'yith_product_brand';
			$before_term_list   = apply_filters( 'yith_wcbr_single_product_before_term_list', '' );
			$after_term_list    = apply_filters( 'yith_wcbr_single_product_after_term_list', '' );
			$term_list_sep      = apply_filters( 'yith_wcbr_single_product_term_list_sep', ', ' );
			$brands_label       = get_option( 'yith_wcbr_brands_label' );
			$product_brands     = get_the_terms( $current_product_id, 'yith_product_brand' );
			$product_has_brands = ! is_wp_error( $product_brands ) && $product_brands;
			$content_to_show    = get_option( 'yith_wcbr_loop_product_brands_content' );

			$args = array(
				'product'            => $product,
				'product_id'         => $current_product_id,
				'brands_taxonomy'    => $brands_taxonomy,
				'before_term_list'   => $before_term_list,
				'after_term_list'    => $after_term_list,
				'term_list_sep'      => $term_list_sep,
				'brands_label'       => $brands_label,
				'product_brands'     => $product_brands,
				'product_has_brands' => $product_has_brands,
				'content_to_show'    => $content_to_show
			);

			// include payment form template
			$template_name = 'loop-brands.php';

			yith_wcbr_get_template( $template_name, $args );

}

add_shortcode( 'product_paycut_calculation_filter', 'product_paycut_filter' );

function product_paycut_filter( $atts ) {
	$filter_html = '';
	$pa_brands = get_terms( array(
		'taxonomy' => 'pa_brand',
		'hide_empty' => false,
	) );
	
	$product_categories = get_terms( array(
		'taxonomy' => 'product_cat',
		'hide_empty' => false,			
	) );
	$product_conditions = get_terms( array(
		'taxonomy' => 'pa_conditions',
		'hide_empty' => false,	
	) );
	$filter_html .='<form action="'.site_url().'/wp-admin/admin-ajax.php" id="filter_paycut" method="post" >';
	$filter_html .='<div class="payment-main-wrapper">';
	$filter_html .='<div class="payment-header">';
	$filter_html .='<div class="brand-filed">';
	$filter_html .='<label>Brand</label>';
	$filter_html .='<select name ="paycut_brand" id="paycut_brand">';
	$filter_html .='<option disabled selected>Search for a brand</option>';
	foreach ($pa_brands as $pa_brand) {
		$filter_html .='<option value="'.$pa_brand->term_id.'">'.$pa_brand->name.'</option>';
	}
	$filter_html .='</select>';
	$filter_html .='</div>';
	$filter_html .='<div class="category-filed">';
	$filter_html .='<label>Category</label>';
	$filter_html .='<select name = "paycut_cat" id="paycut_cat" disabled>';
	$filter_html .='<option value="" disabled selected>Search for a category</option>';
	foreach ($product_categories as $product_cat) {
		$filter_html .='<option value="'.$product_cat->term_id.'">'.$product_cat->name.'</option>';
	}
	$filter_html .='</select>';
	$filter_html .='</div>';
	$filter_html .='<div class="condition-filed">';
	$filter_html .='<label>Condition</label>';
	$filter_html .='<select name ="condition" id="condition">';
	$filter_html .='<option disabled selected>Search for a condition</option>';
	foreach ($product_conditions as $product_condition) {
		$filter_html .='<option value="'.$product_condition->term_id.'">'.$product_condition->name.'</option>';
	}
	$filter_html .='</select>';
	$filter_html .='</div>';
	$filter_html .='<div class="btn-filed">';
	$filter_html .='<button type="submit" class="calculate-btn" id="paycut_submit" disabled>Calculate</button>';
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
 $category = get_term( $_POST['paycut_cat'], 'product_cat' );
 $brands = get_term( $_POST['paycut_brand'], 'yith_product_brand' );
 $condition = get_term($_POST['condition'],'pa_conditions');
	$args = array(
		'orderby' => 'date', // we will sort posts by date
		'order'	=> 'ASC', // ASC or DESC
		'post_status'    => 'publish',
		'post_type' => 'product',
		'tax_query'        => array (
        'relation' => 'OR',
        array(
            'taxonomy'        => 'yith_product_brand',
        	'field'           => 'term_id',
        	'terms'           =>  $_POST['paycut_brand'],
        ),
        array(
            'taxonomy'        => 'product_cat',
        	'field'           => 'term_id',
        	'terms'           =>  $_POST['paycut_cat'],
        ),
		array(
            'taxonomy'        => 'pa_conditions',
        	'field'           => 'term_id',
        	'terms'           =>  $_POST['condition'],
        ),
    ),
	);

 $products = new WP_Query( $args );

echo '<div class="payment-body">';
echo '<h3 class="payment-body-title"><p>'.$brands->name .' '. $category->name.'</p></h3>';
echo '<h4 class="payment-body-subtitle">120-day listing window</h4>';
echo '<div class="payment-item-listing">';
if ( $products->have_posts() ): while ( $products->have_posts() ):
 		$products->the_post();
		echo '<div class="payment-item">';
		echo '<a href="'.esc_url($featured_img_url).'">';
		the_post_thumbnail('thumbnail');
		echo '</a>';
		echo '<h5>' . $products->post->post_title . '</h5>';
		$_product = wc_get_product( get_the_ID() );

        $table = TablePress::$model_table->load( 1 );
     
        echo '<p>  Est. Price: '.wc_price($_product->get_price()).'</p>';
        if ( $_product->get_price() < 100 ) {
        	echo '<p>  Est. Payout In Cash : '.wc_price($_product->get_price() * $table['data'][1][1]/100) .' </p>';
			echo '<p>  Est. Payout In Credit : '.wc_price($_product->get_price() * $table['data'][1][2]/100) .' </p>';
        } else if ( $_product->get_price() >= 100 && $_product->get_price() <= 300 ) {
        	echo '<p>  Est. Payout In Cash : '.wc_price($_product->get_price() * $table['data'][2][1]/100) .' </p>';
			echo '<p>  Est. Payout In Credit : '.wc_price($_product->get_price() * $table['data'][2][2]/100) .' </p>';
        } else if( $_product->get_price() >= 301 && $_product->get_price() <= 350 ) {
        	echo '<p>  Est. Payout In Cash : '.wc_price($_product->get_price() * $table['data'][3][1]/100) .' </p>';
			echo '<p>  Est. Payout In Credit : '.wc_price($_product->get_price() * $table['data'][3][2]/100) .' </p>';
        } else if ( $_product->get_price() >= 351 ) {
        	echo '<p>  Est. Payout In Cash : '.wc_price($_product->get_price() * $table['data'][4][1]/100) .' </p>';
			echo '<p>  Est. Payout In Credit : '.wc_price($_product->get_price() * $table['data'][4][2]/100) .' </p>';
        }
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


//for change commision due label change
add_filter( 'gettext', 'theme_change_comment_field_names', 20, 3 );
function theme_change_comment_field_names( $translated_text, $text, $domain ) {
    if ( is_singular() ) {
        switch ( $translated_text ) {
            case 'Commission Due' :
                $translated_text = __( 'Payout in Cash', 'ciao' );
                break;
 
            case 'Commission Paid' :
                $translated_text = __( 'Payout in Credit', 'ciao' );
                break;

			case 'Mark received' :
                $translated_text = 'Delivered';
                break;

            case 'Points' :
                $translated_text = 'Credits';
                break;

            case 'Apply Points' :
                $translated_text = 'Apply Credits';
                break;

             case 'Here is the Discount Rule for Applying your Points to Cart Total' :
                $translated_text = 'Here is the Discount Rule for Applying your Credits to Cart Total';
                break;
			case 'Sign in' :
                $translated_text = 'Sign Up';
                break;

        }
    }
    return $translated_text;
}



//for set dashboard label
function wpb_woo_my_account_order($wp) {
	// echo "<pre>";
	// print_r($wp);
	// die;

	$current_user = wp_get_current_user();
	$myorder = array(
		// 'orders'    => __( 'Orders', 'woocommerce' ),
// 		'downloads'          => __( 'Downloads', 'woocommerce' ),
		
		'customer-logout'    => __( 'Logout', 'woocommerce' ),
	);
	if ( in_array( 'vendor', (array) $current_user->roles ) ) {
            // exit;
        
		$change_text = 'Seller Dashboard';
		$sellerArr = array(
			'seller_dashboard' => __( $change_text, 'woocommerce' ),
			'orders'    => __( 'Buyer Dashboard', 'woocommerce' ),
			//'store-credit' => __('Refund Credit', 'woocommerce'),
			'edit-address'       => __( 'Addresses', 'woocommerce' ),
			'edit-account'       => __( 'Account details', 'woocommerce' ),
			//'store-credit' => __('Refund Credit', 'woocommerce'),
			// 'vendor_dashboard'   => __( 'Vendor Dashboard', 'woocommerce' )
		);
		$myorder = array_merge($sellerArr,$myorder);
				
		// array_splice($myorder,0,0,$sellerArr);
	}else if ( in_array( 'customer', (array) $current_user->roles ) ) {
		$change_text = 'Buyer Dashboard';
		$buyertArr = array(
			''          		 => __( $change_text, 'woocommerce' ),
			'orders'     		 => __( 'Orders', 'woocommerce' ),
			'points' 		 => __('Total Credit ', 'woocommerce'),
			'edit-address'       => __( 'Addresses', 'woocommerce' ),
			'edit-account'       => __( 'Account details', 'woocommerce' ),
		);
		//array_splice($myorder,0,0,$buyertArr);
		$myorder = array_merge($buyertArr,$myorder);
	}else if ( in_array( 'administrator', (array) $current_user->roles ) ){
		$change_text = 'Dashboard';
		$adminArr = array(
			''          => __( $change_text, 'woocommerce' ),
			'orders'    => __( 'Orders', 'woocommerce' ),
			'edit-address'       => __( 'Addresses', 'woocommerce' ),
			'edit-account'       => __( 'Account details', 'woocommerce' ),
		);
		//array_splice($myorder,0,0,$adminArr);
		$myorder = array_merge($adminArr,$myorder);
	}
	return $myorder;
}
add_filter ( 'woocommerce_account_menu_items', 'wpb_woo_my_account_order' );

// For Add condition in listing product
add_action( 'woocommerce_before_shop_loop_item_title', function(){
	global $product;

	if($product->stock_status == 'outofstock'){
		echo '<span class="out-stock-label zoo-stock-label sold-part">Sold</span>';
	}
	if ( ! $product->is_type( 'grouped' ) ) {
		$attribute_condition = $product->get_attribute('conditions');
		if($attribute_condition != ''){
		
			$multiple_tags = explode(",",$attribute_condition);
			
			foreach ( $multiple_tags as $key => $value ) {
				if(($value == 'New with Tags')||($value == 'Preloved with Tags')){
					$condition_tag .= $value.'</br>';
					echo '<span class="onsale numeric conditions-custom">'.$condition_tag.'</span>';
				}
			}
		}
	}
}, 10 );

//redirect to orders page.
add_filter( 'woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2 );

function wc_custom_user_redirect($redirect, $user){

	if ( wc_user_has_role( $user, 'vendor' ) ) {
        $redirect = get_home_url(). '/my-account/orders'; // homepage
    }
  
    return $redirect;	
}

// /* WC Vendors Pro - Add some new page links to the Pro Dashboard */
// // function new_dashboard_pages( $pages ){ 
// // 	$pages[] = array( 'label' => 'Product', 'slug' => admin_url(). 'edit.php?post_type=product' );  // Add stuff here
// // 	return $pages;
// // }
// // add_filter( 'wcv_pro_dashboard_urls', 'new_dashboard_pages' ); 

// /*
// * Unpublish products after purchase
// */
function lbb_unpublish_prod_to_draft() {
	$args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => '_stock_status',
				'value' => 'outofstock',
			)
		)		
	);
	$product_list = get_posts( $args );
	foreach ($product_list as $key => $product) {

		$post_modified = $product->post_modified;
		$product_object = wc_get_product($product->ID);
		$key = '_change_out_stock';
		$custom_field = get_post_meta( $product->ID, $key, true);
		$current_string_time = strtotime(date("Y-m-d h:i:s"));
		$expire_string_time = strtotime($custom_field);
		if($custom_field){
			if($current_string_time > $expire_string_time){
				wp_update_post(array(
		                'ID' => $product->ID,
		                'post_status' => 'draft'
		                ));
			}
		}
		
	}
}
lbb_unpublish_prod_to_draft();

function lbb_unpublish_prod($order_id) {

    $order = new WC_Order( $order_id );

    $all_products = $order->get_items();
    foreach ($all_products as $product){
        $product_object = wc_get_product($product['product_id']);
            // This will only work if stock management has been enabled
        if( ! $product_object->get_stock_quantity() ) {
        	$curr_date =  date('Y-m-d h:i:s');
        	$new_date = date('Y-m-d h:i:s',strtotime('+30 days',strtotime($curr_date)));
			
        	$meta = get_post_meta( $product['product_id'], '_change_out_stock', true);
        

        	if(empty($meta)){
        		update_post_meta( $product['product_id'], '_change_out_stock', $new_date);
        	}
        }
    }
}
add_action( 'woocommerce_thankyou', 'lbb_unpublish_prod', 10, 1 );

// Display the product thumbnail in order received page
add_filter( 'woocommerce_order_item_name', 'order_received_item_thumbnail_image', 10, 3 );
function order_received_item_thumbnail_image( $item_name, $item, $is_visible ) {
    // Targeting order received page only
    if( ! is_wc_endpoint_url('order-received') ) return $item_name;

    // Get the WC_Product object (from order item)
    $product = $item->get_product();

    if( $product->get_image_id() > 0 ){
        $product_image = '<span style="float:left;display:block;width:56px;">' . $product->get_image(array(48, 48)) . '</span>';
        $item_name = $product_image . $item_name;
    }
    return $item_name;
}
add_filter( 'woocommerce_order_item_name', 'display_product_image_in_order_item', 20, 3 );
function display_product_image_in_order_item( $item_name, $item, $is_visible ) {
    // Targeting view order pages only
    if( is_wc_endpoint_url( 'view-order' ) ) {
        $product   = $item->get_product(); // Get the WC_Product object (from order item)
		if ($product) {
        $thumbnail = $product->get_image(array( 36, 36)); // Get the product thumbnail (from product object)
        if( $product->get_image_id() > 0 )
            $item_name = '<div class="item-thumbnail">' . $thumbnail . '</div>' . $item_name;
		}
	
    }
    return $item_name;
}

add_filter( 'woocommerce_account_menu_items', 'custom_remove_downloads_my_account', 999 );
 
function custom_remove_downloads_my_account( $items ) {
unset($items['downloads']);
return $items;
}

// ===========================================

/**
 * Display custom item data in the cart
 */


function plugin_republic_get_item_data( $item_data, $cart_item_data ) {
 $product_brands     = get_the_terms( $cart_item_data['product_id'], 'yith_product_brand' );
 $item_data[] = array(
 'key' => __( '<br>Brand ', 'ciao-child' ),
 'value' => $product_brands[0]->name
 );

 return $item_data;
}
add_filter( 'woocommerce_get_item_data', 'plugin_republic_get_item_data', 10, 2 );
function plugin_republic_checkout_create_order_line_item( $item, $cart_item_key, $values, $order ) {
$product_brands     = get_the_terms( $item['product_id'], 'yith_product_brand' );
 $item->add_meta_data(
__( 'Brand ', 'ciao-child' ),
 $product_brands[0]->name,
 true
 );

}
add_action( 'woocommerce_checkout_create_order_line_item', 'plugin_republic_checkout_create_order_line_item', 10, 4 );

//===============================================================================

add_filter( 'woocommerce_endpoint_orders_title', 'change_my_account_orders_title', 10, 2 );
function change_my_account_orders_title( $title, $endpoint ) {
    $title = __( "Buyer Dashboard", "woocommerce" );

    return $title;
}


remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_action( 'woocommerce_cart_is_empty', 'custom_empty_cart_message', 10 );

function custom_empty_cart_message() {
	//wc_print_notices();
    $html  = '<div class="col-12 offset-md-1 col-md-10"><p class="cart-empty">';
    $html .= wp_kses_post( apply_filters( 'wc_empty_cart_message', __( 'Your cart is currently empty.', 'woocommerce' ) ) );
    echo $html . '</p></div>';
}

//Change “Out of stock” to “Sold”
add_filter( 'woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);
function wcs_custom_get_availability( $availability, $_product ) {

    // Change Out of Stock Text
    if ( ! $_product->is_in_stock() ) {
        $availability['availability'] = __('Sold', 'woocommerce');
    }
    return $availability;
}

//Change the page title name for store credit in my account	
add_filter( 'woocommerce_endpoint_store-credit_title', 'change_my_account_store_credit_title', 10, 2 );
function change_my_account_store_credit_title( $title, $endpoint) {
	$current_user = wp_get_current_user();
	if ( in_array( 'customer', (array) $current_user->roles ) ){
	    $title = __( "Shop credit", "woocommerce" );

	    return $title;
	}else if( in_array( 'vendor', (array) $current_user->roles ) ){
	    $title = __( "Store credit", "woocommerce" );

	    return $title;
	}
}


//MR23042021
function allproductshow_function()
{
$user_id = get_current_user_id();
$args = array(
'author'        =>  $user_id,
'post_type' => 'product',
'post_status' => 'publish'
);

$get_products_user_id = new WP_Query($args);

?>
<table class="table">
	<thead>
		<tr>
			<th><?php echo __( "Date", "ciao-child" );?></th>
			<th><?php echo __( "Product Name", "ciao-child" );?></th>
			<th><?php echo __( "Quantity", "ciao-child" );?></th>
			<th><?php echo __( "Price", "ciao-child" );?></th>
			<th><?php echo __( "Sold / Stock", "ciao-child" );?></th>
		</tr>
		<?php
            
            foreach ($get_products_user_id->posts as $value) {
                    $_product = wc_get_product($value->ID);
            ?>
	<tbody>
		<tr>
			<td><?php echo get_the_date('Y/m/d', $value->ID) ?></td>
			<td><?php echo $value->post_title; ?></td>

			<td><?php echo $_product->get_stock_quantity();?></td>
			<td><?php echo wc_price($_product->get_price()); ?>
			</td><br>
			<?php if ($_product->is_in_stock()) { ?>
			<td><?php echo __( "Stock", "ciao-child" ); ?></td>
			<?php } elseif (!$_product->is_in_stock()) { ?>
			<td><?php echo __( "Sold", "ciao-child" ); ?></td>
		<?php } ?>
		</tr>
	</tbody>
	</thead>
</table>

<?php  }
        }
        add_shortcode('allproductshow', 'allproductshow_function');

// add_filter( 'woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);
// function wcs_custom_get_availability( $availability, $_product ) {
  
//     // Change Out of Stock Text
//     if ( ! $_product->is_in_stock() ) {
//         $availability['availability'] = __('Sold Out', 'woocommerce');
//     }
//     return $availability;
// }


add_action('woocommerce_order_status_changed', 'woo_order_status_change_custom', 10, 3);

function woo_order_status_change_custom($order_id,$old_status,$new_status) {
	if($new_status == 'refunded'){
		$order = wc_get_order($order_id);
		$user_id = $order->get_user_id();
		$old_points = (int) get_user_meta( $user_id, 'mwb_wpr_points', true );
		$order_points = unserialize(get_user_meta( $user_id, 'mwb_wpr_points_buyer', true ));

		if(empty($order_points)){
		$order_points = array();
		}
		
		$old_points += (int) $order->get_total();
		$order_point = array(
			'order_id' => $order_id,
			'order_point' => (int) $order->get_total(),
				);
		array_push($order_points, $order_point);
		update_user_meta( $user_id, 'mwb_wpr_points_buyer', serialize($order_points));	
		update_user_meta( $user_id, 'mwb_wpr_points', $old_points );	
	}
}



function get_products_payout_in_cash($date_range){
	$orders_cash = array();
	$order_cash = 0;
	$orders = WCVendors_Pro_Vendor_Controller::get_orders2( get_current_user_id(), $date_range, true );
	foreach ($orders as  $value) {
		$order = wc_get_order($value->order_id);
		// if($order->payment_method == 'cod'){
			$items = $order->get_items();

// // Wilson: Fix incorrect items shown on seller dashboard
//               foreach ($items as $item) {
				foreach ($value->order_items as $item) {
// End: Fix
				
				$product_name = $item->get_name();
				$product_id = $item->get_product_id();
				$product_image = wp_get_attachment_image_src( get_post_thumbnail_id($product_id), 'thumbnail' );
				$_product = new WC_Product($product_id);
				$table = TablePress::$model_table->load( 1 );
				if ( $_product->get_price() < 100 ) {
					$product_cash = wc_price($_product->get_price() * $table['data'][1][1]/100);
					$payout_cash = $table['data'][1][1].'%';
					$order_cash += $_product->get_price() * $table['data'][1][1]/100;
				} else if ( $_product->get_price() >= 100 && $_product->get_price() <= 300 ) {
					$product_cash = wc_price($_product->get_price() * $table['data'][2][1]/100);
					$payout_cash = $table['data'][2][1].'%';
					$order_cash += $_product->get_price() * $table['data'][2][1]/100;
				} else if( $_product->get_price() >= 301 && $_product->get_price() <= 350 ) {
					$product_cash = wc_price($_product->get_price() * $table['data'][3][1]/100);
					$payout_cash = $table['data'][3][1].'%';
					$order_cash += $_product->get_price() * $table['data'][3][1]/100;
				} else if ( $_product->get_price() >= 351 ) {
					$product_cash = wc_price($_product->get_price() * $table['data'][4][1]/100);
					$payout_cash = $table['data'][4][1].'%';
					$order_cash += $_product->get_price() * $table['data'][4][1]/100;
				}
				$orders_cash[] = array(
						'order_id' => $value->order_id,
						'product_id' => $product_id,
						'product_name' => $product_name,
						'product_image' => $product_image,
						'product_selling' => wc_price($_product->get_price()),
						'payout_cash' => $payout_cash,
						'product_cash' => $product_cash,
				);
			}
		// }
		
	}
	$orders_products_cash = array(
		'payout_cash_total' => wc_price($order_cash),
		'orders_cash' => $orders_cash,
	);


	return $orders_products_cash;
}


function get_products_payout_in_credit($date_range){
	$orders_credit = array();
	$order_credit = 0;
	$orders = WCVendors_Pro_Vendor_Controller::get_orders2( get_current_user_id(), $date_range, true );
	foreach ($orders as  $value) {
		$order = wc_get_order($value->order_id);
		// echo "<pre>";
		// print_r($value);die;
		// if($order->payment_method != 'cod'){
			$items = $order->get_items();

// // Wilson: Fix incorrect items shown on seller dashboard
                              //foreach ($items as $item) {
foreach ($value->order_items as $item) {
// End: Fix
				
				$product_name = $item->get_name();
				$product_id = $item->get_product_id();
				$product_image = wp_get_attachment_image_src( get_post_thumbnail_id($product_id), 'thumbnail' );
				$_product = new WC_Product($product_id);
				$table = TablePress::$model_table->load( 1 );
				if ( $_product->get_price() < 100 ) {
					$product_credit = wc_price($_product->get_price() * $table['data'][1][2]/100);
					$payout_credit = $table['data'][1][2].'%';
					$order_credit += $_product->get_price() * $table['data'][1][2]/100;
				} else if ( $_product->get_price() >= 100 && $_product->get_price() <= 300 ) {
					$product_credit = wc_price($_product->get_price() * $table['data'][2][2]/100);
					$payout_credit = $table['data'][2][2].'%';
					$order_credit += $_product->get_price() * $table['data'][2][2]/100;
				} else if( $_product->get_price() >= 301 && $_product->get_price() <= 800 ) {
					$product_credit = wc_price($_product->get_price() * $table['data'][3][2]/100);
					$payout_credit = $table['data'][3][2].'%';
					$order_credit += $_product->get_price() * $table['data'][3][2]/100;
				} else if ( $_product->get_price() >= 801 ) {
					$product_credit = wc_price($_product->get_price() * $table['data'][4][2]/100);
					$payout_credit = $table['data'][4][2].'%';
					$order_credit += $_product->get_price() * $table['data'][4][2]/100;
				}
				$orders_credit[] = array(
						'order_id' => $value->order_id,
						'product_id' => $product_id,
						'product_name' => $product_name,
						'product_image' => $product_image,
						'product_selling' => wc_price($_product->get_price()),
						'payout_credit' => $payout_credit,
						'product_credit' => $product_credit,
				);
			}
		// }
	}
	$orders_products_credit = array(
		'payout_credit_total' => wc_price($order_credit),
		'orders_credit' => $orders_credit,
	);
	return $orders_products_credit;
}


add_action( 'woocommerce_order_status_processing', 'wc_send_order_to_mypage' );
function wc_send_order_to_mypage( $order_id ) {
		$order = wc_get_order($order_id);
		$items = $order->get_items();
		foreach ($items as $item) {
		    $product_id = $item->get_product_id();
		    $_product = new WC_Product($product_id);
		    $vendor_id = get_post_field( 'post_author', $product_id );
		    $old_points = (int) get_user_meta( $vendor_id, 'mwb_wpr_points', true );
		    $table = TablePress::$model_table->load( 1 );
		    if ( $_product->get_price() < 100 ) {
		    	$old_points += $_product->get_price() * $table['data'][1][2]/100;
		    } else if ( $_product->get_price() >= 100 && $_product->get_price() <= 300 ) {
		    	$old_points += $_product->get_price() * $table['data'][2][2]/100;
		    } else if( $_product->get_price() >= 301 && $_product->get_price() <= 800 ) {
		    	$old_points += $_product->get_price() * $table['data'][3][2]/100;
		    } else if ( $_product->get_price() >= 801 ) {
		    	$old_points += $_product->get_price() * $table['data'][4][2]/100;
		    }
		    update_user_meta( $vendor_id, 'mwb_wpr_points', $old_points );
		}
}


function display_order_number_with_price(){
$user_id = get_current_user_id();
$order_points =  unserialize(get_user_meta( $user_id, 'mwb_wpr_points_buyer', true ));
return $order_points;
}

add_filter( 'woocommerce_order_item_get_formatted_meta_data', 'unset_specific_order_item_meta_data', 10, 2);
function unset_specific_order_item_meta_data($formatted_meta, $item){
    // Only on emails notifications
    // if( is_admin() || is_wc_endpoint_url() )
    //     return $formatted_meta;

    foreach( $formatted_meta as $key => $meta ){
        if( in_array( $meta->key, array('Sold By') ) )
            unset($formatted_meta[$key]);
    }
    return $formatted_meta;
}

/* Remove sold by in product loops */
remove_action( 'woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9, 2);


// Add the custom field "favorite_color"
add_action( 'woocommerce_edit_account_form', 'add_favorite_color_to_edit_account_form' );
function add_favorite_color_to_edit_account_form() {
    $user = wp_get_current_user();
    if ( in_array( 'vendor', (array) $user->roles ) ) {
    ?>

<?php /* Add payout method */ ?>
    <h1>Payout Method</h1>
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
	<input style="margin-right: 10px;margin-top: 5px" type="radio" id="wcv_payout_cash" name="wcv_payout_method" value="cash" <?php if ($user->wcv_payout_method == "cash") echo "checked" ?> >
	<label style="margin-right: 20px;" for="wcv_payout_cash">Cash</label><br>
	<input style="margin-right: 10px;margin-top: 5px" type="radio" id="wcv_payout_credit" name="wcv_payout_method" value="credit" <?php if ($user->wcv_payout_method == "credit") echo "checked" ?> >
	<label style="margin-right: 20px;"  for="wcv_payout_credit">Credit</label><br>
    <input style="margin-right: 10px;margin-top: 5px" type="radio" id="wcv_payout_cash" name="wcv_payout_method" value="donate" <?php if ($user->wcv_payout_method == "donate") echo "checked" ?> >
	<label style="margin-right: 20px;" for="wcv_payout_cash">Donate</label>
	</p>

    <h2>Bank Details</h2>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="wcv_bank_account_name"><?php _e( 'Bank Account Name', 'woocommerce' ); ?></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="wcv_bank_account_name" id="wcv_bank_account_name" value="<?php echo esc_attr( $user->wcv_bank_account_name ); ?>" />
    </p>
     <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="wcv_bank_account_number"><?php _e( 'Bank Account Number', 'woocommerce' ); ?></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="wcv_bank_account_number" id="wcv_bank_account_number" value="<?php echo esc_attr( $user->wcv_bank_account_number ); ?>" />
    </p>
     <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="wcv_bank_name"><?php _e( 'Bank Name', 'woocommerce' ); ?></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="wcv_bank_name" id="wcv_bank_name" value="<?php echo esc_attr( $user->wcv_bank_name ); ?>" />
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="wcv_bank_routing_number"><?php _e( 'Routing Number', 'woocommerce' ); ?></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="wcv_bank_routing_number" id="wcv_bank_routing_number" value="<?php echo esc_attr( $user->wcv_bank_routing_number ); ?>" />
    </p>
     <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="wcv_bank_iban"><?php _e( 'IBAN', 'woocommerce' ); ?></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="wcv_bank_iban" id="wcv_bank_iban" value="<?php echo esc_attr( $user->wcv_bank_iban ); ?>" />
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="wcv_bank_bic_swift"><?php _e( 'BIC/SWIFT', 'woocommerce' ); ?></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="wcv_bank_bic_swift" id="wcv_bank_bic_swift" value="<?php echo esc_attr( $user->wcv_bank_bic_swift ); ?>" />
    </p>
    <?php
}
}


add_action( 'woocommerce_save_account_details', 'save_favorite_color_account_details', 12, 1 );
function save_favorite_color_account_details( $user_id ) {
    if( isset( $_POST['wcv_bank_account_name'] ) )
        update_user_meta( $user_id, 'wcv_bank_account_name', sanitize_text_field( $_POST['wcv_bank_account_name'] ) );

    if( isset( $_POST['wcv_bank_account_number'] ) )
        update_user_meta( $user_id, 'wcv_bank_account_number', sanitize_text_field( $_POST['wcv_bank_account_number'] ) );

    if( isset( $_POST['wcv_bank_name'] ) )
        update_user_meta( $user_id, 'wcv_bank_name', sanitize_text_field( $_POST['wcv_bank_name'] ) );

    if( isset( $_POST['wcv_bank_routing_number'] ) )
        update_user_meta( $user_id, 'wcv_bank_routing_number', sanitize_text_field( $_POST['wcv_bank_routing_number'] ) );

    if( isset( $_POST['wcv_bank_iban'] ) )
        update_user_meta( $user_id, 'wcv_bank_iban', sanitize_text_field( $_POST['wcv_bank_iban'] ) );

    if( isset( $_POST['wcv_bank_bic_swift'] ) )
        update_user_meta( $user_id, 'wcv_bank_bic_swift', sanitize_text_field( $_POST['wcv_bank_bic_swift'] ) );

/* Save payout method */
   if( isset( $_POST['wcv_payout_method'] ) )
        update_user_meta( $user_id, 'wcv_payout_method', sanitize_text_field( $_POST['wcv_payout_method'] ) );

}
// change clever-portfolio to Our Lookbook on dashbord 
function wp1482371_custom_post_type_args( $args, $post_type ) {
    if ( $post_type == "portfolio" ) {
        $args['labels'] = array(
            'name'               => __( 'Our Lookbook', 'clever-portfolio' ),

            'singular_name'      => __( 'Clever Portfolio', 'clever-portfolio' ),

            'add_new'            => __( 'Add New', 'clever-portfolio' ),

            'add_new_item'       => __( 'Add New Portfolio Item', 'clever-portfolio' ),

            'edit_item'          => __( 'Edit Portfolio Item', 'clever-portfolio' ),

            'new_item'           => __( 'New Portfolio Item', 'clever-portfolio' ),

            'view_item'          => __( 'View Portfolio Item', 'clever-portfolio' ),

            'search_items'       => __( 'Search Portfolio', 'clever-portfolio' ),

            'not_found'          => __( 'No portfolio items have been added yet', 'clever-portfolio' ),

            'not_found_in_trash' => __( 'Nothing found in Trash', 'clever-portfolio' )
        );
    }

    return $args;
}
add_filter( 'register_post_type_args', 'wp1482371_custom_post_type_args', 20, 2 );

//frontend ajax hook
// remove_action('wp_ajax_zoo_ln_get_product_list', 'Zoo\Frontend\Ajax\zoo_ln_get_product_list');
// remove_action('wp_ajax_nopriv_zoo_ln_get_product_list', 'Zoo\Frontend\Ajax\zoo_ln_get_product_list');

remove_all_actions('wp_ajax_zoo_ln_get_product_list');
remove_all_actions('wp_ajax_nopriv_zoo_ln_get_product_list');

add_action('wp_ajax_zoo_ln_get_product_list', 'custom_zoo_ln_get_product_list');
add_action('wp_ajax_nopriv_zoo_ln_get_product_list', 'custom_zoo_ln_get_product_list');

function custom_zoo_ln_get_product_list()
{
    global $wpdb, $wp_query;

    $args = [];

    $GLOBALS['zoo_ln_data']['is_ajax'] = 1;
    $GLOBALS['zoo_ln_data']['need_reset_paging'] = 0;

    if (!isset($_POST['zoo_ln_form_data'])) {
        wp_send_json_error(__('Invalid request data!', 'clever-layered-navigation'));
    } else {
        parse_str($_POST['zoo_ln_form_data'], $post_args);
    }

    // Avoid loop hell.
    remove_action('pre_get_posts', 'Zoo\Frontend\Hook\process_filter', 11);

    $q = \Zoo\Frontend\Hook\process_filter(new \WP_Query(), $post_args);

    $args['post_type'] = 'product';

    if (!empty($post_args['vendor_store_author_id'])) {
        $args['author'] = intval($post_args['vendor_store_author_id']);
    }

    $args['paged']          = !empty($post_args['paged']) ? intval($post_args['paged']) : 1;
    $args['posts_per_page'] = !empty($post_args['posts_per_page']) ? intval($post_args['posts_per_page']) : get_option('posts_per_page');
    $args['meta_query']     = $q->get('meta_query');
    $args['tax_query']      = $q->get('tax_query');
    $args['wc_query']       = 'product_query';
    $args['post__in']       = $q->get('post__in');

    if (!empty($post_args['order_type'])) {
        $args['order'] = sanitize_key($post_args['order_type']);
    } else {
        $args['order'] = 'DESC';
    }

    switch ($post_args['order_by']) {
        case 'title':
            $args['orderby'] = 'title';
        break;
        case 'relevance':
            $args['orderby'] = 'relevance';
        break;
        case 'menu_order':
            $args['orderby'] = 'title';
        break;
        case 'price':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_price';
        break;
        case 'price-desc':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_price';
        break;
        case 'popularity':
            $args['meta_key'] = 'total_sales';
            add_filter('posts_clauses', function($filtering_args) {
                global $wpdb;
        		$filtering_args['orderby'] = "$wpdb->postmeta.meta_value+0 DESC, $wpdb->posts.post_date DESC";
        		return $filtering_args;
            });
        break;
        case 'rating':
            $args['meta_key'] = '_wc_average_rating';
            $args['orderby'] = [
                'meta_value_num' => 'DESC',
                'ID' => 'ASC'
            ];
        break;
        default:
             $args['orderby'] = 'date';
        break;
    }

    $wp_query = new \WP_Query($args);
    ob_start();
    require ZOO_LN_TEMPLATES_PATH . 'product-list.php';
    $html_ul_products_content = ob_get_clean();

    ob_start();
    woocommerce_result_count();
    $html_result_count_content = ob_get_clean();

    ob_start();
    wc_get_template('loop/pagination.php');
    $html_pagination_content = ob_get_clean();

    $item_id = intval($post_args['filter_list_id']);
    $selected_filter_option = \Zoo\Frontend\Hook\get_activated_filter($post_args);

    ob_start();
    require ZOO_LN_TEMPLATES_PATH . 'view.php';
    $filter_panel = ob_get_clean();

    $return['html_ul_products_content'] = $html_ul_products_content;
    $return['html_result_count_content'] = $html_result_count_content;
    $return['html_pagination_content'] = preg_replace('/<\/*nav[^>]*>/', '', $html_pagination_content);
    $return['html_filter_panel'] = $filter_panel;

    wp_send_json($return);
}
add_filter( 'wpseo_primary_term_taxonomies', '__return_empty_array' );
//============== 04-06-2021

function my_admin_footer_function() {
    ?>
	<style type="text/css">
		
		.dash-table-part {
			width: 100%;
    		overflow-y: hidden;
		}
		
		.post-type-product #wpwrap {
			overflow: hidden;
		}
		
		.dash-table-part table.fixed {
			table-layout: inherit;
			overflow-x: scroll !important;
			width:100% !important;
		}

   </style>
	<script type="text/javascript">
	
		jQuery(document ).ready(function() {
			setTimeout(function(){ 

				jQuery(".post-type-product table.wp-list-table").wrap("<div class='dash-table-part'></div>" );


			}, 3000);
		});

	</script>
	<?php
}
add_action('admin_footer', 'my_admin_footer_function');

/*15/7 - hide other shipping method*/
/**
 * Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
function my_hide_shipping_when_free_is_available( $rates ) {
	$free = array();

	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}

	return ! empty( $free ) ? $free : $rates;
}

add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );


/* Change order email */

if ( ! function_exists( 'wc_display_item_meta' ) ) {
        /**
         * Display item meta data.
         *
         * @since  3.0.0
         * @param  WC_Order_Item $item Order Item.
         * @param  array         $args Arguments.
         * @return string|void
         */
        function wc_display_item_meta( $item, $args = array() ) {
                $strings = array();
                $html    = '';
                $args    = wp_parse_args(
                        $args,
                        array(
                                'before'       => '<ul class="wc-item-meta"><li>',
                                'after'        => '</li></ul>',
                                'separator'    => '</li><li>',
                                'echo'         => true,
                                'autop'        => false,
                                'label_before' => '<strong class="wc-item-meta-label">',
                                'label_after'  => ':</strong>',
                        )
                );

                foreach ( $item->get_formatted_meta_data() as $meta_id => $meta ) {
                        $value     = $args['autop'] ? wp_kses_post( $meta->display_value ) : wp_kses_post( make_clickable( trim( $meta->display_value ) ) );
                        $strings[] = $args['label_before'] . wp_kses_post( $meta->display_key ) . $args['label_after'] . $value;
                }

// Wilson:  Add Size if it's simple product

if (!$item->get_variation_id()){
	$product = $item->get_product();
	if ($product) {
		$product_size = $product->get_attribute('pa_size');
		if (!empty($product_size)) {
			$strings[] = $args['label_before'] . "Size" . $args['label_after'] . $product_size;
		}
	}
}

// Wilson: End


                if ( $strings ) {
                        $html = $args['before'] . implode( $args['separator'], $strings ) . $args['after'];
                }

                $html = apply_filters( 'woocommerce_display_item_meta', $html, $item, $args );

                if ( $args['echo'] ) {
                        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        echo $html;
                } else {
                        return $html;
                }
        }
}


// Wilson: Disable feature image on all page 
add_action( 'wp_head', function () { 
	if (is_page()) {
?>
<style>
	#site-main-content .container .post-media.single-image {
		display:none !important;
	}
</style>
<?php 
	}
});

//2/9/2021 add cc to email templates
/**
 * @snippet       Add Cc: or Bcc: Recipient @ WooCommerce Completed Order Email
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 5
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_filter( 'woocommerce_email_headers', 'bbloomer_order_completed_email_add_cc_bcc', 9999, 3 );
 
function bbloomer_order_completed_email_add_cc_bcc( $headers, $email_id, $order ) {
        $headers .= "bcc: BabyverseHK <orders@babyverse.com.hk>\r\n"; 
    return $headers;
}

//2/9/2021 show out of stock products at the end of the page
/**
 * Order product collections by stock status, instock products first.
 */
class iWC_Orderby_Stock_Status
{

    public function __construct()
    {
        // Check if WooCommerce is active
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            add_filter('posts_clauses', array($this, 'order_by_stock_status'), 2000);
        }
    }

    public function order_by_stock_status($posts_clauses)
    {
        global $wpdb;
		//is_shop() || is_product_category() || is_product_tag()
        // only change query on WooCommerce loops
        if (is_woocommerce() && (true)) {
            $posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
            $posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
            $posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
        }
        return $posts_clauses;
    }
}

new iWC_Orderby_Stock_Status;

// 3-9-2021 send cancelled email to customers
function wc_cancelled_order_add_customer_email( $recipient, $order ){
     return $recipient . ',' . $order->billing_email;
 }
 add_filter( 'woocommerce_email_recipient_cancelled_order', 'wc_cancelled_order_add_customer_email', 10, 2 );



// Wilson: Add Payout Method in user profile
// Hooks near the bottom of profile page (if current user) 
add_action('show_user_profile', 'custom_user_profile_fields');

// Hooks near the bottom of the profile page (if not current user) 
add_action('edit_user_profile', 'custom_user_profile_fields');

// @param WP_User $user
function custom_user_profile_fields( $user ) {
?>
    <table class="form-table">
        <tr>
            <th>
                <label for="wcv_payout_method"><?php _e( 'Payout Method' ); ?></label>
            </th>
            <td>
                <?php echo esc_attr( get_the_author_meta( 'wcv_payout_method', $user->ID ) ); ?>
            </td>
        </tr>
    </table>
<?php
}

