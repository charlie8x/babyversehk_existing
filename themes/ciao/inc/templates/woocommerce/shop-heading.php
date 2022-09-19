<?php
/**
 * Template display cover image of Archive WooCommerce Page template.
 * @since: zoo-theme 3.0.0
 * @Ver: 3.0.0
 */
if ( ! check_vendor() ) {
	$enable_shop_heading = get_theme_mod( 'zoo_enable_shop_heading', 1 );
	if ( is_shop() ) {
		$shop_page   = get_post( wc_get_page_id( 'shop' ) );
		$description = '';
		if ( isset( $shop_page->post_content ) ) {
			$description = wc_format_content( $shop_page->post_content );
		}

		if ( $description ) {
			woocommerce_product_archive_description();
		}
        if ( $enable_shop_heading && get_post_meta(get_the_id(), 'zoo_disable_title', true) != 1) {
            ?>
            <h2 class="shop-title"><?php echo woocommerce_page_title(); ?> <span class="total-product">(<?php echo wc_get_loop_prop( 'total' );?>)</span></h2>
            <?php
        }
	} else {
		if ( $enable_shop_heading ) {
			$thumb_img=get_theme_mod('zoo_shop_banner','');
			if(isset($thumb_img['url'])){
				$thumb_img=$thumb_img['url'];
            }
			if ( is_product_category() ) {
				global $wp_query;
				$cat          = $wp_query->get_queried_object();
				$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
				$thumb        = wp_get_attachment_url( $thumbnail_id );
				$thumb_img       = $thumb ? $thumb : $thumb_img;
			}
			if ( $thumb_img != '' ) {
				?>
                <img src="<?php echo esc_url($thumb_img)?>" alt="<?php echo woocommerce_page_title(); ?>" class="shop-heading-image"/>
                <?php
			}
			?>
                <h2 class="shop-title"><?php echo woocommerce_page_title(); ?> <span class="total-product">(<?php echo wc_get_loop_prop( 'total' );?>)</span></h2>
                <?php
                woocommerce_taxonomy_archive_description();
		}
	}
}