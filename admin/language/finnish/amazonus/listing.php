<?php
$_['lang_title'] = 'New Amazon US listaus';
$_['lang_openbay'] = 'OpenBay Pro';
$_['lang_amazonus'] = 'Amazon US';

$_['button_search'] = 'Search';
$_['button_new'] = 'Create new product';
$_['button_return'] = 'Back to products';
$_['button_amazonus_price'] = "Get Amazon's price";
$_['button_list'] = "List on Amazon";

$_['text_view_on_amazonus'] = 'View on Amazon US';
$_['text_list'] = 'List';
$_['text_new'] = 'New';
$_['text_used_like_new'] = 'Used - Like New';
$_['text_used_very_good'] = 'Used - Very Good';
$_['text_used_good'] = 'Used - Good';
$_['text_used_acceptable'] = 'Used - Acceptable';
$_['text_collectible_like_new'] = 'Collectible - Like New';
$_['text_collectible_very_good'] = 'Collectible - Very Good';
$_['text_collectible_good'] = 'Collectible - Good';
$_['text_collectible_acceptable'] = 'Collectible - Acceptable';
$_['text_refurbished'] = 'Refurbished';
$_['text_germany'] = 'Saksa';
$_['text_france'] = 'France';
$_['text_italy'] = 'Italy';
$_['text_spain'] = 'Spain';
$_['text_united_kingdom'] = 'Englanti';

$_['text_product_sent'] = 'Product was successfully sent to Amazon US.';
$_['text_product_not_sent'] = 'Product was not sent to Amazon US. Reason: %s';

$_['lang_no_results'] = 'Ei tuloksia!';

$_['column_image'] = 'Kuva';
$_['column_asin'] = 'ASIN';
$_['column_name'] = 'Nimi';
$_['column_price'] = 'Hinta';
$_['column_action'] = 'Toimenpide';

$_['entry_sku'] = 'SKU:';
$_['entry_condition'] = 'Laatu / kunto:';
$_['entry_condition_note'] = 'Condition Note:';
$_['entry_price'] = 'Hinta:';
$_['entry_sale_price'] = 'Alennushinta:';
$_['entry_quantity'] = 'M&auml;&auml;r&auml;:';
$_['entry_start_selling'] = 'Saatavilla (pvm):';
$_['entry_restock_date'] = 'Tulossa (pvm):';
$_['entry_country_of_origin'] = 'Alkuper&auml;maa:';
$_['entry_release_date'] = 'Julkaisu (pvm):';
$_['entry_from'] = 'Alkaen (pvm)';
$_['entry_to'] = 'Asti (pvm)';

$_['help_sku'] = "Unique product's ID assigned by the merchant";
$_['help_restock_date'] = "This is the date you will be able to ship any back-ordered items to a customer. This date should not be greater than 30 days from the date listed or orders received may automatically be canceled.";
$_['help_sale_price'] = "Sale Price must have a start and end date";

$_['lang_not_in_catalog'] = 'Or, if its not in the catalog&nbsp;&nbsp;&nbsp;';

$_['error_text_missing'] = 'Annettava joitakin haku yksityiskohtia';
$_['error_data_missing'] = 'Tarvittavat tiedot puuttuvat';
$_['error_missing_asin'] = 'ASIN -sy&ouml;te puutuu';
$_['error_marketplace_missing'] = 'Markkinapaikka -sy&ouml;te on pakollinen!';
$_['error_condition_missing'] = 'Laatu / kunto -sy&ouml;te on pakollinen!';
$_['error_fetch'] = 'Tietoa ei ole saatavilla';
$_['error_amazonus_price'] = 'Hintatietoa ei ole saatavilla Amazon US:sta';
$_['error_stock'] = 'Tuoteitteita ei voi listata, koska varastossa on alle 1 tuote.';
$_['error_sku'] = 'SKU -sy&ouml;te on pakollinen!';
$_['error_price'] = 'Hinta -sy&ouml;te on pakollinen!';

$_['tab_required_info'] = 'Tarvittavat tiedot';
$_['tab_additional_info'] = 'Muita vaihtoehtoja';

$_['lang_placeholder_search'] = 'Enter product name, UPC, EAN, ISBN or ASIN';
$_['lang_placeholder_condition'] = 'Use this box to describe the condition of your products.';

/* Headers, tab names */
$_['item_links_header_text'] = 'Item links';
$_['quick_listing_header_text'] = 'Quick listing';
$_['advanced_listing_header_text'] = 'Advanced listing';
$_['saved_heder_text'] = 'Saved listings';
$_['lang_tab_main'] = 'Main';

$_['item_links_tab_text'] = 'Item links';
$_['quick_listing_tab_text'] = 'Quick listing';
$_['advanced_listing_tab_text'] = 'Advanced listing';
$_['saved_tab_text'] = 'Saved listings';

$_['text_error_connecting'] = 'Warning: There was problem connecting to Welford Media API servers. Please check your OpenBay Pro Amazon US extension settings. If the problem persists, please contact Welford support.';

/* Quick/advanced listing tabs */
$_['quick_listing_description'] = 'Use this method when matching product already exist in Amazon US catalogue. Matching is found by Amazon US using Standard product id (ASIN, ISBN, UPS, EAN)';
$_['advanced_listing_description'] = 'Use this method to create new listings on Amazon US.';
$_['listing_row_text'] = 'Listing for product:';
$_['already_saved_text'] = 'This product is already in saved listings. Click edit if you want to revise.';
$_['save_button_text'] = 'Tallenna';
$_['save_upload_button_text'] = 'Save and upload';
$_['saved_listings_button_text'] = 'View saved listings';
$_['cancel_button_text'] = 'Keskeyt&auml;';
$_['field_required_text'] = 'This field is required!';
$_['not_saved_text'] = 'Listing was not saved. Check your input.';
$_['chars_over_limit_text'] = 'characters over limit.';
$_['minimum_length_text'] = 'Minimum length is';
$_['characters_text'] = 'characters';
$_['delete_confirm_text'] = 'Are you sure?';

$_['clear_image_text'] = 'Clear';
$_['browse_image_text'] = 'Browse';

$_['category_selector_field_text'] = 'Amazon category:';

/* Item links tab */
$_['item_links_description'] = 'Here you can add and edit product links to already existing Amazon items without listing them from OpenCart. This will allow stock control between enabled marketplaces. If you have openStock installed - this will also allow you to link item options to individual Amazon SKUs. (Uploading products from OpenCart to Amazon will automaticaly add links)';
$_['new_link_table_name'] = 'New link';
$_['new_link_product_column'] = 'Product';
$_['new_link_sku_column'] = 'SKU';
$_['new_link_amazonus_sku_column'] = 'Amazon item SKU';
$_['new_link_action_column'] = 'Toimenpide';

$_['item_links_table_name'] = 'Item links';


/* Marketplaces */
$_['marketplaces_field_text'] = 'Markkinapaikka';
$_['marketplaces_help'] = 'You can choose default marketplace in Amazon US extension settings.';


/* Saved listings tab */
$_['saved_listings_description'] = 'This is the list of product listings which are saved locally and ready to be uploaded to Amazon. Click upload to post.';
$_['actions_edit_text'] = 'Muokkaa';
$_['actions_remove_text'] = 'Poista';
$_['upload_button_text'] = 'Upload';

$_['name_column_text'] = 'Nimi';
$_['model_column_text'] = 'Malli';
$_['sku_column_text'] = 'SKU';
$_['amazonus_sku_column_text'] = 'Amazon item SKU';
$_['actions_column_text'] = 'Toimenpide';
$_['saved_localy_text'] = 'Listing saved localy.';
$_['uploaded_alert_text'] = 'Saved listing(s) uploaded!';
$_['upload_failed'] = 'Failed uploading product with SKU: "%s". Reason: "%s" Uploading process canceled.';


/* ITEM LINKS */
$_['links_header_text'] = 'Link items';
$_['links_desc1_text'] = 'Linking your items will allow for stock control on your Amazon US listings.<br /> For each item that is updated the local stock (the stock available in your OpenCart store) will update your Amazonus listing';
$_['links_desc2_text'] = 'You can link items manualy by entering Amazon US SKU and product name or load all unlinked products and then enter amazon SKUs. (Uploading products from OpenCart to Amazon will automaticaly add links)';
$_['links_load_btn_text'] = 'Load';
$_['links_new_link_text'] = 'New link';
$_['links_autocomplete_product_text'] = 'Product<span class="help">(Autocomplete from name)</span>';
$_['links_amazonus_sku_text'] = 'Amazon item SKU';
$_['links_action_text'] = 'Toimenpide';
$_['links_add_text'] = 'Lis&auml;&auml;';
$_['links_add_sku_tooltip'] = 'Add another sku';
$_['links_remove_text'] = 'Poista';
$_['links_linked_items_text'] = 'Linked items';
$_['links_unlinked_items_text'] = 'Unlinked items';
$_['links_name_text'] = 'Nimi';
$_['links_model_text'] = 'Malli';
$_['links_sku_text'] = 'SKU';
$_['links_amazonus_sku_text'] = 'Amazon item SKU';
$_['links_sku_empty_warning'] = 'Amazon SKU can not be empty!';
$_['links_name_empty_warning'] = 'Tuotteen nimi t&auml;ytyy kirjata!';
$_['links_product_warning'] = 'Product does not exist. Please use autocomplete values.';

$_['option_default'] = '-- Select option --';
$_['lang_error_load_nodes'] = 'Unable to load browse nodes';

/* Listin edit page */
$_['text_edit_heading'] = 'Listing overview';

$_['text_has_saved_listings'] = 'This product has one or more localy saved listings.';

$_['text_product_links'] = 'Product links';
$_['button_create_new_listing'] = "Create new listing";
$_['button_remove_links'] = "Remove links";
$_['button_saved_listings'] = "View saved listings";

$_['column_name'] = 'Product Name';
$_['column_model'] = 'Malli';
$_['column_combination'] = 'Laatu/kunto';
$_['column_sku'] = 'SKU';
$_['column_amazonus_sku'] = 'Amazon item SKU';
