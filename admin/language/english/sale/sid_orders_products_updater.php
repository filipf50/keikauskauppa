<?php
// Heading
$_['heading_title']     = 'Order´s product updater';
$_['heading_orders_title']     = 'Affected order´s report';

// Text
$_['text_defautl']   = 'Default';
$_['text_removeMsg'] = 'Selected products will be changed in orders. This action will not be roll-back. Would you like to continue?';
$_['text_success']   = 'Success: Changes has been made to selected orders.';
$_['text_canceled_order_comment'] = 'Dear Customer,</br> Your order has been deleted due to lack of stock. </br> Best regards.';
$_['text_removed_products_comment'] ='Next product has been removed:';
$_['text_added_products_comment'] ='Next product has been added:';
$_['text_pending_added_payment_comment'] = 'Some products in your order has been modified. An extra cost of {difference}€ has been added to your pending amount. You need to access to your account, following the above link, and pay pending amount. ';
$_['text_pending_discounted_payment_comment'] = 'Some products in your order has been modified. {difference}€ has been discounted from your pending amount. You can access to your account, following the above link, and pay pending amount. ';
$_['text_pending_refound_comment'] = 'Some products in your order has been modified. The extra {difference}€ ammount will be payed back to you. Please, reply this mail with your bank information. ';

//Button
$_['button_update'] = 'Update orders';

// Column
$_['column_order']              = 'Order';
$_['column_date']               = 'Date';
$_['column_customer']           = 'Customer';
$_['column_status']             = 'Status';
$_['column_order_products']     = 'Order Products';
$_['column_products_to_remove']  = 'Products to Remove';
$_['column_pending_products']   = 'Pending Products';

// Entry
$_['entry_date_start']  = 'Date Start:';
$_['entry_date_end']    = 'Date End:';
$_['entry_status']      = 'Order Status:';
$_['entry_stores']      = 'Order Store:';
$_['entry_product']     = 'Product to remove: <br /><span class="help">Select product you want to be removed from orders</span>';
$_['entry_product_dest']= 'Product to add: <br /><span class="help">Select product you want to be added to orders</span>';
$_['entry_option']     = 'Choose Option(s):';

//Errors
$_['error_required']    = 'All required fields have to be filled.';
$_['error_removing']    = 'An error has ocurred while trying to remove products from orders. Please, try again.';
?>