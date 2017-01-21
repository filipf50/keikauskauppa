<?php
// Heading
$_['heading_title']     = 'Order´s product updater';
$_['heading_orders_title']     = 'Affected order´s report';

// Text
$_['text_defautl']   = 'Default';
$_['text_removeMsg'] = 'Selected products will be changed in orders. This action will not be roll-back. Would you like to continue?';
$_['text_success']   = 'Success: Changes has been made to selected orders.';
$_['text_canceled_order_comment'] = 'Hyvä asiakas,</br> tilauksesi on poistettu koska kurssit ovat täynnä. </br> Ystävällisesti.';
$_['text_removed_products_comment'] ='Ryhmä josta siirryitte pois:';
$_['text_added_products_comment'] ='Uusi ryhmä johon siirrytte:';
$_['text_pending_added_payment_comment'] = 'Tilaukseesi on tehty ryhmän vaihto ja tämän seurauksena sinulle tuli lisää maksettavaa {difference}€. Kirjaudu kaupassa omalle tilille käyttämällä linkkiä tästä sähköpostista ja käy maksamassa erotus.';
$_['text_pending_discounted_payment_comment'] = 'Tilaukseesi on tehty ryhmän vaihto ja tämän seurauksena sinulle maksetaan takaisin {difference}€. Erotus vähennetään automaattisesti lukukausimaksun loppuosasta. Muistathan käydä maksamassa loppuosan kaupan oma tili -> tilaushistoria tai painamalla yläpuolella olevaa linkkiä tässä sähköpostissa. ';
$_['text_pending_refound_comment'] = 'Tilaukseesi on tehty ryhmän vaihto ja tämän seurauksena sinulle palautetaan {difference}€. Vastaa tähän sähköpostiin tilitietojesi kera maksun palauttamista varten. ';

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
$_['entry_order_start']  = 'Order ID Start:';
$_['entry_order_end']    = 'Order ID End:';
$_['entry_status']      = 'Order Status:';
$_['entry_stores']      = 'Order Store:';
$_['entry_product']     = 'Product to remove: <br /><span class="help">Select product you want to be removed from orders</span>';
$_['entry_product_dest']= 'Product to add: <br /><span class="help">Select product you want to be added to orders</span>';
$_['entry_option']     = 'Choose Option(s):';

//Errors
$_['error_required']    = 'All required fields have to be filled.';
$_['error_removing']    = 'An error has ocurred while trying to remove products from orders. Please, try again.';
$_['error_noorders']    = 'There are no orders with this filter. Please, review your filter and try again';
?>