<?php

$_['heading_title'] = 'Kaikki paikat täynnä!';

#text---------------------------------------------------------------------------

$_['text_description']  = 'Anna sähköpostiosoite johon ilmoitamme kun paikka vapautuu:';

$_['text_description_2']  = 'Täytä lomake, niin ilmoitamme sinulle kun paikka vapautuu:';

$_['text_success'] =  'Sähköposti rekisteröity!<br/>Ilmoitamme sinulle sähköpostilla kun paikka vapautuu!';

$_['mail_admin_subject'] =  'Paikan vapautuminen pyyntö - {product_name}';

$_['mail_admin_body'] =  '
<b>Tiedot</b>
<br/><br/>
Asiakkaan nimi: {customer_name}
<br/><br/>
Asiakkaan sähköposti: {customer_email}
<br/><br/>
Asiakkaan puhelin: {customer_phone}
<br/><br/>
Asiakas {custom_field}: {customer_custom}
<br/><br/>
Tuote: {product_name}
';

$_['text_error_mail']  = 'Tämä sähköposti ei ole oikea!';
$_['text_error_name']  = 'Tämä nimi ei ole kelvollinen!';
$_['text_error_phone']  = 'Tämä puhelinnumero ei ole kelvollinen!';
$_['text_error_custom']  = '{custom_name} virheellinen tieto!';
$_['text_error_captcha']  = 'Captcha koodissa oli virhe, yritä uudelleen!';

$_['text_error_data'] = 'Virheellinen tieto.';
#entry
$_['nwa_entry_name'] = 'Nimi';
$_['nwa_entry_phone'] = 'Puhelin';
$_['nwa_entry_mail'] = 'Sähköposti';
$_['nwa_entry_captcha'] = 'Kirjoita alla oleva teksti:';
#buttons---------------------------------------------------------------------------

$_['button_register']  = 'Lähetä';
$_['button_category'] = 'Ilmoita vapautumisesta!';
$_['button_close'] = 'Sulje';

?>