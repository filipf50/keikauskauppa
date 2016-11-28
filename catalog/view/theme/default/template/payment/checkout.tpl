<?php
/****************************************************************************
*	CHECKOUT FINLAND PAYMENT METHOD											*
*	Version:	1.5.4														*
*	Date:		01-05-2013													*
*	File:		catalog/view/theme/default/template/payment/checkout.tpl	*
*	Author:		HydeNet														*
*	Web:		www.hydenet.fi												*
*	Email:		info@hydenet.fi												*
****************************************************************************/
?>
<?php if ($testmode) { ?>
<div class="warning"><?php echo $text_testmode; ?></div>
<?php } ?>
<form action="<?php echo $action; ?>" method="post">
	<input type="hidden" name="VERSION" value="<?php echo $version; ?>" />
	<input type="hidden" name="STAMP" value="<?php echo $stamp; ?>" />
	<input type="hidden" name="AMOUNT" value="<?php echo $amount; ?>" />
	<input type="hidden" name="REFERENCE" value="<?php echo $reference; ?>" />
	<input type="hidden" name="MESSAGE" value="<?php echo $message; ?>" />
	<input type="hidden" name="LANGUAGE" value="<?php echo $language; ?>" />
	<input type="hidden" name="MERCHANT" value="<?php echo $merchant; ?>" />
	<input type="hidden" name="RETURN" value="<?php echo $return; ?>" />
	<input type="hidden" name="CANCEL" value="<?php echo $cancel; ?>" />
	<input type="hidden" name="REJECT" value="<?php echo $reject; ?>" />
	<input type="hidden" name="DELAYED" value="<?php echo $delayed; ?>" />
	<input type="hidden" name="COUNTRY" value="<?php echo $country; ?>" />
	<input type="hidden" name="CURRENCY" value="<?php echo $currency; ?>" />
	<input type="hidden" name="DEVICE" value="<?php echo $device; ?>" />
	<input type="hidden" name="CONTENT" value="<?php echo $content; ?>" />
	<input type="hidden" name="TYPE" value="<?php echo $type; ?>" />
	<input type="hidden" name="ALGORITHM" value="<?php echo $algorithm; ?>" />
	<input type="hidden" name="DELIVERY_DATE" value="<?php echo $delivery_date; ?>" />
	<input type="hidden" name="FIRSTNAME" value="<?php echo $firstname; ?>" />
	<input type="hidden" name="FAMILYNAME" value="<?php echo $familyname; ?>" />
	<input type="hidden" name="ADDRESS" value="<?php echo $address; ?>" />
	<input type="hidden" name="POSTCODE" value="<?php echo $postcode; ?>" />
	<input type="hidden" name="POSTOFFICE" value="<?php echo $postoffice; ?>" />
	<input type="hidden" name="MAC" value="<?php echo $mac; ?>" />
	<div class="buttons">
		<div class="right">
			<input type="submit" value="<?php echo $button_confirm; ?>" class="button" />
		</div>
	</div>
</form>
