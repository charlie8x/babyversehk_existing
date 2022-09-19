<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>

<p><?php esc_html_e( 'Dear Valued Customer,', 'woocommerce' ); ?></p>
<p><?php esc_html_e( 'We have finished processing your order.', 'woocommerce' ); ?></p>
<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
?><p style="color: #00B7BA;text-align: center;font-weight: bold">Thank you for supporting BabyverseHK!</p>
<p style="text-align:center;font-size: 8px">*If you are not fully happy with the order received, you could process a return with Babyverse HK within 7 days from the date you receive your order, providing that the returning item is in its original selling condition as you receive it (‘New with tags’ items have to be returned with the original tags attached).</p>
<hr />
<p style="text-align: center;font-weight: bold">Interested in Selling with Us?</p>
<p style="text-align: center"><a href="https://babyverse.com.hk/sell-with-us/#Schedule-a-collection">Book a free pick-up now!</a></p> 
<hr />
<p style="text-align: center;font-weight: bold">NEED HELP?</p>
<p style="text-align: center">If you have any questions, please feel free to contact us!</p>
<?php
/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
