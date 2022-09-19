<?php

/**

 * Customer new account email

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see https://docs.woocommerce.com/document/template-structure/

 * @package WooCommerce\Templates\Emails

 * @version 3.7.0

 */



defined( 'ABSPATH' ) || exit;

// $user_pass = wp_generate_password();

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer username */ ?>
<p><?php /*printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $user_login ) );*/ ?></p>
<?php 

$the_user = get_user_by('login', $user_login);
$first_name = get_user_meta($the_user->ID, 'billing_first_name', true);

?>
<p><?php printf( __( 'Dear Valued Customer,', 'woocommerce' ) ); ?></p>

<?php /* translators: %1$s: Site title, %2$s: Username, %3$s: My account link */ ?>
<p><?php /*printf( esc_html__( 'Thank you for registering with BabyverseHK. Your account has been created. You may now login to view orders and more at: %3$s', 'woocommerce' ), esc_html( $blogname ), '<strong>' . esc_html( $user_login ) . '</strong>', make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped*/ ?></p>

<p><?php printf( esc_html__( 'Thank you for registering with BabyverseHK. Your account has been created. You may now login to view orders and more at: %3$s', 'woocommerce' ), esc_html( $blogname ), '<strong>' . esc_html( $user_login ) . '</strong>', make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

<p><?php printf( esc_html__( 'Username: %s', 'woocommerce' ), '<strong>' . esc_html( $user_login ) . '</strong>' ); ?></p>
<?php if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated ) : ?>
	<?php /* translators: %s: Auto generated password */ ?>
	<p style="color: #500050;"><?php printf( esc_html__( 'Password: %s', 'woocommerce' ), '<strong>' . esc_html( $user_pass ) . '</strong>' ); ?></p>
<?php endif; ?>
<p style="font-size: 60%;font-style: italic;"><?php printf( esc_html__( '*The password has been automatically generated. You are encouraged to change the password after first login.', 'woocommerce' )); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
<p style="color: #500050;"><?php print( esc_html__( 'We would like to offer you a 10% off welcome coupon: WELCOME10. Kindly apply the coupon at your next checkout.', 'woocommerce')); ?></p>
<p style="color: #500050;"><?php printf( esc_html__( 'We hope you enjoy shopping with us!', 'woocommerce')); ?></p>


<?php

/**

 * Show user-defined additional content - this is set in each email's settings.

 */

if ( $additional_content ) {

	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );

}



do_action( 'woocommerce_email_footer', $email );

