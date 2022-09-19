<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_user = wp_get_current_user();
do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="woocommerce-MyAccount-navigation">
	<ul>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?>
					<?php if($endpoint == 'orders' && in_array( 'vendor', (array) $current_user->roles )){ ?>
						<span class="quadmenu-caret"></span>
					<?php } ?>
				</a>
				<?php 
					if($endpoint == 'orders' && in_array( 'vendor', (array) $current_user->roles )){
						echo '<div class="wrap-dashboard-submenu dropdown-content"><nav class="woocommerce-MyAccount-navigation"><ul>';
						echo '<li class="'.wc_get_account_menu_item_classes('points').'">';
						echo '<a href="'.esc_url( wc_get_account_endpoint_url( 'points' ) ).'">'.esc_html("Shop Credit").'</a>';
						echo '</li></ul></nav></div>';
					}
				?>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
