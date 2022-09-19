<?php
/**
 * The template for displaying the vendor store information including total sales, orders, products and commission
 *
 * Override this template by copying it to yourtheme/wc-vendors/dashboard/report
 *
 * @package    WCVendors_Pro
 * @version    1.4.4
 */
$give_tax = 'yes' == get_option( 'wcvendors_vendor_give_taxes' ) ? true : false;
$current_user = wp_get_current_user();
// if($current_user->ID == '34'){
// 	$commission_due_total = 105.00;
// 	$store_report->commission_due = 42.00;
// 	$commission_paid_total = 105.00;
// 	$store_report->commission_paid = 47.25;
// }else{

// $commission_due_total  = ( $give_tax ) ? $store_report->commission_due + $store_report->commission_shipping_due + $store_report->commission_tax_due : $store_report->commission_due + $store_report->commission_shipping_due;
// $commission_paid_total = ( $give_tax ) ? $store_report->commission_paid + $store_report->commission_shipping_paid + $store_report->commission_tax_paid : $store_report->commission_paid + $store_report->commission_shipping_paid;
$date_range = array(
		'before' => date( 'Y-m-d'),
		'after'  => date( 'Y-m-d', strtotime(' -15 day')),
	);

$orders_cash = get_products_payout_in_cash($date_range);
$orders_credit = get_products_payout_in_credit($date_range);
// }

?>


<div class="wcv_dashboard_datepicker wcv-cols-group">
	<h3>As of <?php echo date( 'Y-m-d'); ?></h3>
</div>

<?php // Wilson: payout method 
//    $user = wp_get_current_user();
	if ($current_user->wcv_payout_method == "cash") {
?>

<div class="wcv_dashboard_overview wcv-cols-group wcv-horizontal-gutters">

	<div class="xlarge-100 large-100 medium-100 small-100 tiny-100">
		<h3><?php _e( 'Commission Due', 'wcvendors-pro' ); ?></h3><h4><?php _e( 'Total:', 'wcvendors-pro' ); ?> <?php echo $orders_cash['payout_cash_total'];?></h4>
		<table role="grid" class="wcvendors-table wcvendors-table-recent_order wcv-table">
		<?php //if($current_user->ID == '34'){ ?>
			<!-- <thead>
			<tr>
			<th><strong><?php //_e( 'Order total', 'wcvendors-pro' ); ?></strong></th>
			<th><?php //_e( 'Amount', 'wcvendors-pro' ); ?></th>			
			</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php //echo wc_price( $commission_due_total ); ?></td>
					<td><?php //echo wc_price( $store_report->commission_due ); ?></td>				
				</tr>
			</tbody> -->
		<?php //}else{ ?>
			<thead>
			<tr>
			<th><?php _e( 'Order ID', 'wcvendors-pro' ); ?></th>
			<th><?php _e( 'Product Image', 'wcvendors-pro' ); ?></th>			
			<th><?php _e( 'Product Name', 'wcvendors-pro' ); ?></th>			
			<th><?php _e( 'Product Price', 'wcvendors-pro' ); ?></th>			
			<th><?php _e( 'Payout %', 'wcvendors-pro' ); ?></th>			
			<th><?php _e( 'Payout Cash', 'wcvendors-pro' ); ?></th>			
			</tr>
			</thead>
			<tbody>
				  <?php if(!empty($orders_cash['orders_cash'])){
					foreach ($orders_cash['orders_cash'] as $key => $product_value_cash) {
						echo "<tr>";
						echo "<td>".$product_value_cash['order_id']."</td>";
						echo "<td><img src='".$product_value_cash['product_image'][0]."' height='".$product_value_cash['product_image'][1]."' width='".$product_value_cash['product_image'][2]."'></td>";
// Wilson: Add Brand and size
//						echo "<td>".$product_value_cash['product_name']."</td>";
                                                echo "<td>".$product_value_cash['product_name'];
$product_brand = get_the_terms( $product_value_cash['product_id'], 'yith_product_brand' );
if(!empty($product_brand[0]->name)){
        echo '<br><span class="brand-name">Brand: ' . $product_brand[0]->name . '</span>';
}

$term_name = get_the_terms($product_value_cash['product_id'],'pa_size');
if (!empty($term_name[0]->name)) {
        echo '<br><span class="product-size">Size: ' . $term_name[0]->name . '</span>';
}
                        echo "</td>";
// Wilson: End
						echo "<td>".$product_value_cash['product_selling']."</td>";
						echo "<td>".$product_value_cash['payout_cash']."</td>";
						echo "<td>".$product_value_cash['product_cash']."</td>";
						echo "</tr>";
					}
				}
				?>
			</tbody>
		<?php //} ?>
		</table>
	</div>

<?php } else {
?>
	<div class="xlarge-100 large-100 medium-100 small-100 tiny-100">
		<h3><?php _e( 'Commission Paid', 'wcvendors-pro' ); ?></h3><h4><?php _e( 'Total:', 'wcvendors-pro' ); ?> <?php echo $orders_credit['payout_credit_total'];?></h4>
		<table role="grid" class="wcvendors-table wcvendors-table-recent_order wcv-table">
			<?php //if($current_user->ID == '34'){ ?>
			<!-- <thead>
			<tr>
			<th><strong><?php //_e( 'Order total', 'wcvendors-pro' ); ?></strong></th>
			<th><?php //_e( 'Amount', 'wcvendors-pro' ); ?></th>			
			</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php //echo wc_price(  $commission_paid_total ); ?></td>
					<td><?php //echo wc_price( $store_report->commission_paid ); ?></td>				
				</tr>
			</tbody> -->
			<?php //}else{ ?>
			<thead>
			<tr>
			<th><?php _e( 'Order ID', 'wcvendors-pro' ); ?></th>
			<th><?php _e( 'Product Image', 'wcvendors-pro' ); ?></th>			
			<th><?php _e( 'Product Name', 'wcvendors-pro' ); ?></th>			
			<th><?php _e( 'Product Price', 'wcvendors-pro' ); ?></th>			
			<th><?php _e( 'Payout %', 'wcvendors-pro' ); ?></th>			
			<th><?php _e( 'Payout Credit', 'wcvendors-pro' ); ?></th>			
			</tr>
			</thead>
			<tbody>
				<?php if(!empty($orders_credit['orders_credit'])){
					foreach ($orders_credit['orders_credit'] as $key => $product_value_credit) {
						echo "<tr>";
						echo "<td>".$product_value_credit['order_id']."</td>";
						echo "<td><img src='".$product_value_credit['product_image'][0]."' height='".$product_value_credit['product_image'][1]."' width='".$product_value_credit['product_image'][2]."'></td>";
// Wilson: Add Brand and size
//						echo "<td>".$product_value_credit['product_name']."</td>";
                                                echo "<td>".$product_value_cash['product_name'];
$product_brand = get_the_terms( $product_value_credit['product_id'], 'yith_product_brand' );
if(!empty($product_brand[0]->name)){
        echo '<br><span class="brand-name">Brand: ' . $product_brand[0]->name . '</span>';
}

$term_name = get_the_terms($product_value_credit['product_id'],'pa_size');
if (!empty($term_name[0]->name)) {
        echo '<br><span class="product-size">Size: ' . $term_name[0]->name . '</span>';
}
                        echo "</td>";
// Wilson: End

						echo "<td>".$product_value_credit['product_selling']."</td>";
						echo "<td>".$product_value_credit['payout_credit']."</td>";
						echo "<td>".$product_value_credit['product_credit']."</td>";
						echo "</tr>";
					}
				}
				?>
			</tbody>
			<?php //} ?>
		</table>
	</div>
<?php } ?>
</div>