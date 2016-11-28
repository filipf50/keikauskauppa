<?php
/************************************************************
*	CHECKOUT FINLAND PAYMENT METHOD							*
*	Version:	1.5.4										*
*	Date:		01-05-2013									*
*	File:		admin/language/finnish/payment/checkout.php	*
*	Author:		HydeNet										*
*	Web:		www.hydenet.fi								*
*	Email:		info@hydenet.fi								*
************************************************************/

// Heading
$_['heading_title']					= 'Checkout';

// Text
$_['text_payment']					= 'Maksutavat';
$_['text_success']					= 'Maksutavan "Checkout" muokkaus onnistui!';
$_['text_checkout']					= '<a onclick="window.open(\'http://checkout.fi/\');"><img src="view/image/payment/logo_checkout.png" alt="Checkout" title="Checkout" /></a>';
$_['text_normal']					= 'Normaali';
$_['text_adult']					= 'Aikuisvihde';
$_['text_device_html']				= 'Erillinen maksutavan valinta';
$_['text_device_xml']				= 'Upotettu maksutavan valinta';
$_['text_no_file']					= 'Tiedostoa ei löydy';
$_['text_status_1']					= 'Maksutapahtuma kesken';
$_['text_status_2']					= 'Hyväksytty maksu';
$_['text_status_3']					= 'Viivästetty maksu';
$_['text_status_4']					= '???';
$_['text_status_5']					= '???';
$_['text_status_6']					= 'Maksu jäädytetty';
$_['text_status_7']					= 'Kolmas osapuoli on hyväksynyt maksun ja se vaatii hyväksyntää/aktivointia';
$_['text_status_8']					= 'Kolmas osapuoli on hyväksynyt maksun / maksu on aktivoitu';
$_['text_status_9']					= '???';
$_['text_status_10']				= 'Maksu tilitetty';
$_['text_status_-1']				= 'Maksu käyttäjän peruma';
$_['text_status_-2']				= 'Maksu järjestelmän peruuttama';
$_['text_status_-3']				= 'Maksutapahtuma aikakatkaistu';
$_['text_status_-4']				= 'Maksutapahtumaa ei löydy';
$_['text_status_-10']				= 'Maksu hyvitetty maksajalle';
$_['text_checkout_status']			= '<strong>Maksun tila: %s</strong> (Tilakoodi: %s)';

// Entry
$_['entry_merchant']				= 'Myyjän tunniste:';
$_['entry_safety_key']				= 'Myyjän turva-avain:';
$_['entry_message']					= 'Viesti asiakkaalle:<br/><span class="help">Tämä näkyy erillisellä maksutavan valintasivulla ja maksuntiedoissa.</span>';
$_['entry_message_fi']				= 'Suomeksi';
$_['entry_message_se']				= 'Ruotsiksi';
$_['entry_message_en']				= 'Englanniksi';
$_['entry_test']					= 'Testitila:<br/><span class="help">Valitse "Ei" tuotantokäyttöä varten.</span>';
$_['entry_content']					= 'Maksun tyyppi:';
$_['entry_device']					= 'Maksutavan valinta:';
$_['entry_debug']					= 'Debug Mode:<br/><span class="help">Tallentaa maksutapahtuman tiedot tiedostoon (checkout.txt) Käytä vain jos epäilet ongelmia maksutavan toiminnassa tai haluat testata.</span>';
$_['entry_debug_contents']			= 'Debug tiedoston sisältö:<br/><span class="help"></span>';
$_['entry_log']						= 'Loki:<br/><span class="help">Tallentaa maksutapahtumat lokitiedostoon (checkout.log).</span>';
$_['entry_log_contents']			= 'Loki tiedoston sisältö:<br/><span class="help"></span>';
$_['entry_total']					= 'Summa:<br /><span class="help">Tilauksen lopusumman oltava vähintään ennen kuin maksutapa aktivoituu.</span>';
$_['entry_geo_zone']				= 'Maantieteellinen alue:';
$_['entry_ok_status']				= 'Hyväksytyn maksun tila:';
$_['entry_delayed_status']			= 'Viivästetyn maksun tila:';
$_['entry_unknown_status']			= 'Epäselvän maksun tila:';
$_['entry_status']					= 'Tila:';
$_['entry_sort_order']				= 'Järjestysnumero:';

// Tab
$_['tab_general']					= 'Yleiset';
$_['tab_log']						= 'Loki';

// Button
$_['button_clear_log']				= 'Tyhjennä loki tiedosto';
$_['button_clear_debug']			= 'Tyhjennä debug tiedosto';

// Error
$_['error_permission']				= 'Käyttöoikeutesi eivät riitä maksutavan muokkaukseen!';
$_['error_merchant']				= 'Myyjän tunniste vaaditaan!';
$_['error_safety_key']				= 'Myyjän turva-avain vaaditaan!';
$_['error_action']					= 'Maksun tietoja ei löydy!';
?>