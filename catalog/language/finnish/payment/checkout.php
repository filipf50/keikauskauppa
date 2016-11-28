<?php
/****************************************************************
*	CHECKOUT FINLAND PAYMENT METHOD								*
*	Version:	1.5.4											*
*	Date:		01-05-2013										*
*	File:		catalog/language/finnish/payment/checkout.php	*
*	Author:		HydeNet											*
*	Web:		www.hydenet.fi									*
*	Email:		info@hydenet.fi									*
****************************************************************/

// Text
$_['text_title']			= 'VERKKOMAKSU PANKKINAPIT / VISA/MASTER (Checkout)';
$_['text_xml_title']		= 'Valitse haluamasi maksutapa';
$_['text_xml_info']			= 'Valittuasi maksutavan alla olevista vaihtoehdoista, maksutapahtuma siirtyy maksutavan järjestelmään. Maksu suoritetaan Checkout Finland Oy:n hallinnoimalle tilille, josta se siirretään kauppiaalle.<br />Muista maksun jälkeen palata takaisin valitsemalla maksupalvelussa sitä verten oleva linkki tai painike.';
$_['text_testmode']			= 'Maksutapa on testitilassa ja maksua ei oikeasti käsitellä!';
$_['text_status_1']			= 'Maksutapahtuma kesken';
$_['text_status_2']			= 'Hyväksytty maksu';
$_['text_status_3']			= 'Viivästetty maksu';
$_['text_status_4']			= '???';
$_['text_status_5']			= '???';
$_['text_status_6']			= 'Maksu jäädytetty';
$_['text_status_7']			= 'Kolmas osapuoli on hyväksynyt maksun ja se vaatii hyväksyntää/aktivointia';
$_['text_status_8']			= 'Kolmas osapuoli on hyväksynyt maksun / maksu on aktivoitu';
$_['text_status_9']			= '???';
$_['text_status_10']		= 'Maksu tilitetty';
$_['text_status_-1']		= 'Maksu käyttäjän peruma';
$_['text_status_-2']		= 'Maksu järjestelmän peruuttama';
$_['text_status_-3']		= 'Maksutapahtuma aikakatkaistu';
$_['text_status_-4']		= 'Maksutapahtumaa ei löydy';
$_['text_status_-10']		= 'Maksu hyvitetty maksajalle';
$_['text_checkout_status']	= 'Maksun tila: %s (Tilakoodi: %s)';
$_['text_order_number']		= 'Tilausnumero: ';
$_['text_success']			= 'Onnistunut maksu.';
$_['text_reference']		= 'Maksutapahtuman viitenumero on %s.';

// Error page
$_['heading_title']		= 'Virhe maksussa';
$_['text_error']		= 'Virhe maksussa.';
$_['return_error']		= 'Maksun paluuviestissä havaittiin virhe!';
$_['error_description']	= 'Maksun tarkistus tiedoissa havaittiin virhe.<br />Tämä johtuu todennäköisesti tietoliikenteessä tapahtuneessa häiriössä.<br /><br />Ota yhteyttä asiakaspalveluumme painamalla "%s"-painiketta.';

// Cancelled page
$_['heading_title_canceled']		= 'Maksutapahtuma peruuntui';
$_['text_error_canceled']		= 'Maksutapahtuma peruuntui.';
$_['return_error_canceled']		= 'Maksutapahtuma peruutettu!';
$_['error_description_canceled']	= 'Maksutapahtuma peruutettu asiakkaan toimesta.<br /><br />Siirry takaisin kassalle painamalla "%s"-painiketta.';

// reject page
$_['heading_title_reject']		= 'Maksutapahtuma hylätty';
$_['text_error_reject']		= 'Maksutapahtuma hylätty.';
$_['return_error_reject']		= 'Maksutapahtuma hylätty!';
$_['error_description_reject']	= 'Järjestelmä hylkäsi maksun.<br /><br />Siirry takaisin kassalle painamalla "%s"-painiketta.';

?>