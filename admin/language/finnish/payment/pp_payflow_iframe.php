<?php
//Headings
$_['heading_title'] = 'PayPal Payflow Pro iFrame';
$_['heading_refund'] = 'Palautus';

//Table columns
$_['column_transaction_id'] = 'Maksutapahtumatunnus';
$_['column_transaction_type'] = 'Transaction Type';
$_['column_amount'] = 'M&auml;&auml;r&auml;';
$_['column_time'] = 'Aika';
$_['column_actions'] = 'Actions';

//Text
$_['text_payment'] = 'Maksu';
$_['text_success'] = 'Suorite: Asetukset on tallennettu onnistuneesti!';
$_['text_pp_payflow_iframe'] = '<a onclick="window.open(\'\');"><img src="view/image/payment/paypal.png" alt="PayPal Payflow Pro" title="PayPal Payflow Pro iFrame" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization'] = 'Authorization';
$_['text_sale'] = 'Sale';
$_['text_authorise'] = 'Authorise';
$_['text_capture'] = 'Delayed Capture';
$_['text_void'] = 'Mit&auml;t&ouml;id&auml;';
$_['text_payment_info'] = 'Maksutiedot';
$_['text_complete'] = 'Suoritettu';
$_['text_incomplete'] = 'Incomplete';
$_['text_transaction'] = 'Transaction';
$_['text_confirm_void'] = 'If you void you cannot capture any further funds';
$_['text_refund'] = 'Palautus';
$_['text_refund_issued'] = 'Refund was issued successfully';
$_['text_redirect'] = 'Redirect';
$_['text_iframe'] = 'Iframe';
$_['help_vendor'] = 'Your merchant login ID that you created when you registered for the Website Payments Pro account.';
$_['help_user'] = 'If you set up one or more additional users on the account, this value is the ID of the user authorised to process transactions. If, however, you have not set up additional users on the account, USER has the same value as VENDOR.';
$_['help_password'] = 'The 6 to 32 character password that you defined while registering for the account.';
$_['help_partner'] = 'The ID provided to you by the authorised PayPal Reseller who registered you for the Payflow SDK. If you purchased your account directly from PayPal, use PayPal';
$_['help_checkout_method'] = "Please use Redirect method if do not have SSL installed or if you do not have Pay with PayPal option disabled on your hosted payment page.";
$_['help_debug'] = "Logs additional information.";

//Buttons
$_['button_refund'] = 'Palautus';
$_['button_void'] = 'Mit&auml;t&ouml;id&auml;';
$_['button_capture'] = 'Tallentaa';

//Tabs
$_['tab_settings'] = 'Asetukset';
$_['tab_order_status'] = 'Order Status';
$_['tab_checkout_customisation'] = 'Checkout Customisation';

//Form entry
$_['entry_vendor'] = 'Vendor:';
$_['entry_user'] = 'User:';
$_['entry_password'] = 'Salasana:';
$_['entry_partner'] = 'Partner:';
$_['entry_test'] = 'Test Mode:<br /><span class="help">Use the live or testing (sandbox) gateway server to process transactions? Test may fail in Internet Explorer</span>';
$_['entry_total'] = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';
$_['entry_order_status'] = 'Order Tila:';
$_['entry_geo_zone'] = 'Maanosa:';
$_['entry_status'] = 'Tila:';
$_['entry_sort_order'] = 'J&auml;rjestys:';
$_['entry_transaction_method'] = 'Transaction method:';
$_['entry_transaction_id'] = 'Maksutapahtumatunnus';
$_['entry_full_refund'] = 'Full refund';
$_['entry_amount'] = 'M&auml;&auml;r&auml;';
$_['entry_message'] = 'Message';
$_['entry_ipn_url'] = 'IPN URL:';
$_['entry_checkout_method'] = 'Checkout Method:';
$_['entry_debug'] = 'Debug mode:';
$_['entry_transaction_reference'] = 'Transaction Reference';
$_['entry_transaction_amount'] = 'Transaction Amount';
$_['entry_refund_amount'] = 'Refund Amount';
$_['entry_capture_status'] = 'Capture Status';
$_['entry_void'] = 'Mit&auml;t&ouml;id&auml;';
$_['entry_capture'] = 'Tallentaa';
$_['entry_transactions'] = 'Maksutapahtuma';
$_['entry_complete_capture'] = 'Complete Capture';
$_['entry_canceled_reversal_status'] = 'Canceled Reversal Tila:';
$_['entry_completed_status'] = 'Suoritettu:';
$_['entry_denied_status'] = 'Kielletty:';
$_['entry_expired_status'] = 'Vanhentunut:';
$_['entry_failed_status'] = 'Keskeytetty:';
$_['entry_pending_status'] = 'Odotustila:';
$_['entry_processed_status'] = 'K&auml;sittelyss&auml;:';
$_['entry_refunded_status'] = 'Hyvitys:';
$_['entry_reversed_status'] = 'K&auml;&auml;nteinen:';
$_['entry_voided_status'] = 'Mit&auml;t&ouml;id&auml;:';
$_['entry_cancel_url'] = 'Keskeyt&auml; URL:';
$_['entry_error_url'] = 'Virheellinen URL:';
$_['entry_return_url'] = 'Paluu URL:';
$_['entry_post_url'] = 'Silent POST URL:';

//Errors
$_['error_permission'] = 'Varoitus: Sinulla ei ole vaadittavia oikeuksia suorittaa toimintoa!';
$_['error_vendor'] = 'Vendor Required!';
$_['error_user'] = 'User Required!';
$_['error_password'] = 'Password Required!';
$_['error_partner'] = 'Partner Required!';
$_['error_missing_data'] = 'Missing data';
$_['error_missing_order'] = 'Could not find the order';
$_['error_general'] = 'There was an error';
$_['error_capture_amt'] = 'Enter an amount to capture';
?>