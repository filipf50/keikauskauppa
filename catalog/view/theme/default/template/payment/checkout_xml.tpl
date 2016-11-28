<?php
/********************************************************************************
*	CHECKOUT FINLAND PAYMENT METHOD												*
*	Version:	1.5.4															*
*	Date:		01-05-2013														*
*	File:		catalog/view/theme/default/template/payment/checkout_xml.tpl	*
*	Author:		HydeNet															*
*	Web:		www.hydenet.fi													*
*	Email:		info@hydenet.fi													*
********************************************************************************/
?>
<?php if ($testmode) { ?>
<div class="warning"><?php echo $text_testmode; ?></div>
<?php } ?>

<h2><?php echo $text_xml_title; ?></h2>
<p><?php echo $text_xml_info;?></p>

<?php $xml=simplexml_load_string($methods); ?>
<?php foreach($xml->payments->payment->banks as $bankX):?>
 <?php foreach($bankX as $bank):?>
  <div class='C1'>
   <form action='<?php echo $bank['url']; ?>' method='post'>
    <?php foreach($bank as $key => $value):?>
     <input type='hidden' name='<?php echo $key; ?>' value='<?php echo $value; ?>' />
    <?php endforeach;?>
    <span><input type='image' src='<?php echo $bank['icon']; ?>' /></span>
    <div><?php echo $bank['name']; ?></div>
   </form>
  </div>
 <?php endforeach;?>
<?php endforeach;?>
