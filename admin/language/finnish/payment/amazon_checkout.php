<?php
//Payment page links
$_['text_amazon_checkout'] = '<a onclick="window.open(\'http://go.amazonservices.com/UKCBASPOpenCart.html\');"><img src="view/image/payment/amazon.png" alt="Amazon Payments" title="Amazon Payments" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_amazon_join'] = '<a href="http://go.amazonservices.com/UKCBASPOpenCart.html" title="Click here to join Amazon Payments">Click here to create your Amazon Payments account</a>';

//Headings
$_['heading_title'] = 'Amazon Payments';
$_['text_home'] = 'Etusivu';
$_['text_payment'] = 'Maksu';

//Text
$_['text_cron_job_url'] = "Cron Job's URL:";
$_['help_cron_job_url'] = "Set a cron job to call this URL";
$_['text_cron_job_token'] = "Secret Token";
$_['help_cron_job_token'] = "Make this long and hard to guess";
$_['text_access_key'] = 'Access Key:';
$_['text_access_secret'] = 'Secret Key:';
$_['text_merchant_id'] = 'Merchant ID:';
$_['text_marketplace'] = 'Markkinapaikka:';
$_['text_germany'] = 'Saksa';
$_['text_uk'] = 'Englanti';
$_['text_checkout_mode'] = 'Checkout mode:';
$_['text_geo_zone'] = 'Maanosa:';
$_['text_status'] = 'Tila:';
$_['text_live'] = 'Live';
$_['text_sandbox'] = 'Sandbox';
$_['text_sort_order'] = 'J&auml;rjestys:';
$_['text_minimum_total'] = 'Minimum Order Total:';
$_['text_all_geo_zones'] = 'All Geo Zones';
$_['text_status_enabled'] = 'K&auml;yt&ouml;ss&auml;';
$_['text_status_disabled'] = 'Ei k&auml;yt&ouml;ss&auml;';
$_['text_default_order_status'] = 'Pending:';
$_['text_ready_order_status'] = 'Ready to be Shipped status:';
$_['text_canceled_order_status'] = 'Canceled order status:';
$_['text_shipped_order_status'] = 'Shipped order status:';
$_['text_last_cron_job_run'] = "Last cron job's run time:";
$_['text_allowed_ips'] = "IPs allowed";
$_['text_add'] = "Add";
$_['text_upload_success'] = 'File was uploaded successfully';
$_['help_adjustment'] = 'Bold fields and at least one "-adj" field are required';
$_['help_allowed_ips'] = "Leave empty if you want everyone to see the checkout button";

// Buttons
$_['button_cancel'] = 'Keskeyt&auml;';
$_['button_save'] = 'Tallenna';

// Errors
$_['error_permissions'] = 'You do not have permissions to modify this module';
$_['error_empty_access_secret'] = 'Secret Key is required';
$_['error_empty_access_key'] = 'Access Key is required';
$_['error_empty_merchant_id'] = 'Merchant ID is required';
$_['error_curreny'] = 'Your shop must have %s currency installed and enabled';
$_['error_upload'] = 'Lataus ep&auml;onnistui';

// Checkout button settings
$_['text_button_settings'] = 'Osta-napin asetukset';
$_['text_colour'] = 'V&auml;ri:';
$_['text_orange'] = 'Oranssi';
$_['text_tan'] = 'Tan';
$_['text_white'] = 'Valkoinen';
$_['text_light'] = 'Kirkas';
$_['text_dark'] = 'Tumma';
$_['text_size'] = 'Koko:';
$_['text_medium'] = 'M';
$_['text_large'] = 'L';
$_['text_x_large'] = 'XL';
$_['text_background'] = 'Tausta:';
$_['text_download'] = '<a href="%s">Download</a> template file';

// Messages
$_['text_success'] = 'Suorite: Asetukset on tallennettu onnistuneesti!';

// Order Info
$_['text_amazon_details'] = 'Amazon Details';
$_['text_amazon_order_id'] = 'Amazon Order ID:';
$_['text_upload'] = 'Upload';
$_['text_upload_template'] = 'Upload the filled in template by clicking on the button below. Make sure it is saved as a tab-delimited file.';
$_['tab_order_adjustment'] = 'Order Adjustment';

//Table columns
$_['column_submission_id'] = 'Submission ID';
$_['column_status'] = 'Tila';
$_['column_text'] = 'Response';
$_['column_amazon_order_item_code'] = 'Amazon Order Product Code';
?>