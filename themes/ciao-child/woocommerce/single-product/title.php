<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $product;
$brand = get_the_terms( $product->get_id(), 'yith_product_brand' );
if(!empty($brand[0]->name)){ ?>
<div class="brand-name"><a href='<?php echo get_term_link( $brand[0]->term_id );?>'>
<?php echo $brand[0]->name; ?>
</a>
</div>
<?php } ?>
<?php the_title( '<h1 class="product_title entry-title heading-title">', '</h1>' ); ?>
