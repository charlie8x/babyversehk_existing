<?php
/**
 * Vendor new order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/vendor-notify-order.php.
 *
 * @author  Jamie Madden, WC Vendors
 * @package WCVendors/Templates/Emails
 * @version 2.0.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/*
 * @hooked WC_Emails::email_header() Output the email header
 */
?><div style="max-width: 570px; margin: auto; border: 3px solid #3aa193; padding: 20px 48px; background-color: white;">
    <div>
	<img src="https://ci5.googleusercontent.com/proxy/yjdnLXmGUpwIjbONoa-dMbo_CC-GQ3auPGvQy9wHfzQG8iQVh_WmCdj2DclC-aHwgHXoZSIiRwwvUq3pigsec7EFYPtdXSbKF3hzoU2DgconzVwx67Ao2dxmuak2aFTpZzEFtcJbzje4rCANblsga4EOack2RmWqjxZUV7MeU4o4Bi09LqPiZwN1tuQ=s0-d-e1-ft#https://babyverse.com.hk/wp-content/uploads/2021/01/cropped-Babyverse-logo-512_%E5%B7%A5%E4%BD%9C%E5%8D%80%E5%9F%9F-1.png" alt="BabyverseHK" width="300" style="border:none;display:inline;font-weight:bold;height:auto;outline:none;text-decoration:none;text-transform:capitalize;font-size:14px;line-height:24px;width:100%;max-width:300px;margin-left: 135px;" class="CToWUd">        
		<h1 style="font-size: 26px; font-weight: bold; text-align: center;">
            CONGRATS! YOUR ITEM HAS BEEN SOLD!
        </h1>

<?php /* translators: %s: Customer first name */ ?>

<p style="color: #500050;"><?php printf( esc_html__( 'Dear Valued Seller', 'woocommerce' )); ?></p>
<p style="color: #500050;"><?php esc_html_e( 'A customer has purchased from your Little Shop. Please find the order details below:', 'woocommerce' ); ?></p>

<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
//do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );
$text_align = is_rtl() ? 'right' : 'left';

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

<h2>
	<?php
	if ( $sent_to_admin ) {
		$before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
		$after  = '</a>';
	} else {
		$before = '';
		$after  = '';
	}
	/* translators: %s: Order ID. */
	echo wp_kses_post( $before . sprintf( __( '[Order #%s]', 'woocommerce' ) . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) );
	?>
</h2>

<div style="margin-bottom: 40px;">
	<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
		<thead>
			<tr>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$args = array(
					'show_sku'      => $sent_to_admin,
					'show_image'    => false,
					'image_size'    => array( 32, 32 ),
					'plain_text'    => $plain_text,
					'sent_to_admin' => $sent_to_admin,
				);
			
			$recipient_email = $email->get_recipient(); //recipient email
		//echo $recipient_email;
		$recipient = get_user_by( 'email', $recipient_email ); //recipient 
		$recipient_name = $recipient->user_login; //recipient name
		//echo $recipient_name;
		$authors = WCV_Vendors::get_vendors_from_order( $order );
		$authors = $authors ? array_keys( $authors ) : array();
		$array_element = 0;
		
		foreach ( $authors as $author ) {
			if($recipient_name == WCV_Vendors::get_vendor_shop_name( $author ))
			{
				break;
			}
			$array_element++;
		}
		// echo WCV_Vendors::get_vendor_shop_name($authors[$array_element]); //vendor name //can delete
		
		$order_items = $order->get_items(); // all products in the order
		
		/*foreach($order_items as $item) // can delete
		{
			echo $item;
		}*/
		
		$vendor_items_element_no = array(); //store the vendor products element number
		
		foreach ($order_items as $temp => $item)
		{
			$product_id = $item['product_id']; //get the product ID
			// echo $product_id;
			$vendor = WCV_Vendors::get_vendor_from_product($product_id); //get the product vendor
			if($recipient_name == WCV_Vendors::get_vendor_shop_name( $vendor ))
			{
				array_push($vendor_items_element_no, $temp);	
			}
			else
			{
				unset($order_items[$temp]);
			}
		}		
		/*foreach($order_items as $item) // can delete
		{
			echo $item;
		}*/
		
		ob_start();

		$template = $args['plain_text'] ? 'emails/plain/email-order-items.php' : 'emails/email-order-items.php';

		wc_get_template(
			$template,
			apply_filters(
				'woocommerce_email_order_items_args',
				array(
					'order'               => $order,
					'items'               => $order_items,
					'show_download_links' => $order->is_download_permitted() && ! $args['sent_to_admin'],
					'show_sku'            => $args['show_sku'],
					'show_purchase_note'  => $order->is_paid() && ! $args['sent_to_admin'],
					'show_image'          => $args['show_image'],
					'image_size'          => $args['image_size'],
					'plain_text'          => $args['plain_text'],
					'sent_to_admin'       => $args['sent_to_admin'],
				)
			)
		);

		echo apply_filters( 'woocommerce_email_order_items_table', ob_get_clean(), $order );
			/*echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$order,
				$args
			);*/			
			?>
		</tbody>
	</table>
</div>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); 

		
/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
//do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

//do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
?>
		<p style="margin:0 0 16px;text-align:center; color: #500050;">Your Babyverse Credit/Cash payout will be credited to your account on 10th each month after the item(s) is sold.<br>
<a href="https://babyverse.hk/my-account/" style="font-weight:normal;text-decoration:underline;color:#00b7ba">Login</a>  to your account for more details. </p>
		<p style="margin:0 0 16px;color:#00b7ba;text-align:center;font-weight:bold">
			Thank you for supporting BabyverseHK!
		</p>
        <p style="margin:0 0 16px;text-align:center;font-size:8px; color: #500050;">
			*If your item is returned within the 7-day return window, it will be put back for sale and no cash/credit will be credited to your account. The listing window of the item would be reset for another 120-day period.
		</p>
<?php /*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );?>        
    </div>
</div>
