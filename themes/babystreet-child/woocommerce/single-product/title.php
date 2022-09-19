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

 * @package    WooCommerce/Templates

 * @version    1.6.4

 */



if (!defined('ABSPATH')) {

	exit; // Exit if accessed directly.

}


global $product;
$brand = $product->get_attribute( 'pa_brand' );
$terms = get_terms($taxonomy);
echo $terms;
?>
<div class="brand-name">
<a href=<?php echo get_term_link( $brand ); ?>>
<?php echo $brand; ?>
</a>
</div>
<?php the_title( '<h1 class="product_title entry-title heading-title">', '</h1>' ); ?>



<? if (!empty($size)) { ?>
<div class="size">
<span class="brand-title">Size:</span>	
<?php  echo $size; ?>
</div>
<? } ?>

<? if (!empty($care_instruction)) { ?>
<div class="care-instruction">
<span class="care-instruction-title">Care Instruction:</span>	
<?php  echo $care_instruction; ?>
</div>
<? } ?>

<? if (!empty($conditions)) { ?>
<div class="conditions">
<span class="conditions-title">Condition:</span>	
<?php echo $conditions; ?>
</div>
<? } ?>

<? if (!empty($color)) { ?>
<div class="care-instruction">
<span class="care-instruction-title">Color:</span>	
<?php echo $color; ?>
</div>
<? } ?>