<table style="border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="2"></td>
		<td class="heading2" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:16px; line-height:20px; color:<?php echo $body_heading_color; ?>; margin:0; padding: 0; font-weight:bold;"><strong>
			<?php echo $title; ?>
		</strong></td>
	</tr>
	<tr style="font-size:1px; line-height:0;"><td width="2" height="3">&nbsp;</td><td height="3">&nbsp;</td></tr>
	<tr style="font-size:1px; line-height:0;"><td width="2" height="1" bgcolor="#cccccc">&nbsp;</td><td height="1" bgcolor="#cccccc">&nbsp;</td></tr>
	<tr style="font-size:1px; line-height:0;"><td width="2" height="10">&nbsp;</td><td height="10">&nbsp;</td></tr>
</table>

<p class="standard" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:0px; margin-bottom:8px;">
	<?php echo $text_greeting; ?>
</p>

<?php if ($customer_id) { ?>
<p class="link" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:13px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:5px; margin-bottom:15px;">
	<b><?php echo $text_link; ?></b><br />
	<span style="line-height:100%; font-size:120%;">&raquo;</span>
	<a href="<?php echo $link.(strpos($link,'?')===false ? '?' : '&amp;').$tracking.'&amp;utm_content=order_account'; ?>" style="color:<?php echo $body_link_color; ?>; text-decoration:none;" target="_blank">
		<b><?php echo $link; ?></b>
	</a>
</p>
<?php } ?>

<?php if ($download) { ?>
<p class="link" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:13px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:5px; margin-bottom:15px;">
	<b><?php echo $text_download; ?></b><br />
	<span style="line-height:100%; font-size:120%;">&raquo;</span>
	<a href="<?php echo $download.(strpos($download,'?')===false ? '?' : '&amp;').$tracking.'&amp;utm_content=order_download'; ?>" style="color:<?php echo $body_link_color; ?>; text-decoration:none;" target="_blank">
		<b><?php echo $download; ?></b>
	</a>
</p>
<?php } ?>

<?php if($instruction){ ?>
<p class="standard" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:0px; margin-bottom:8px;">
	<b><?php echo $text_new_instruction; ?></b><br />
	<?php echo $instruction; ?>
</p>
<?php } ?>

<table cellpadding="5" cellspacing="0" width="100%" style="table-layout:fixed; margin:0; color:#666; border-collapse:separate; -moz-border-radius:3px; -moz-box-shadow:0 1px 2px #d1d1d1; -webkit-border-radius:3px; -webkit-box-shadow:0 1px 2px #d1d1d1; border:1px solid #e0e0e0; border-radius:3px; box-shadow:0 1px 2px #d1d1d1; text-shadow:1px 1px 0px #fff;">
<thead>
	<tr>
    	<th bgcolor="#ededed" colspan="2" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:14px; font-weight:bold;"><?php echo $text_order_detail; ?></th>
   	</tr>
</thead>
<tbody>
	<tr>
    	<td bgcolor="#fafafa" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; border-bottom:1px solid #e0e0e0; word-wrap:break-word;">
          	<?php if(isset($order_id)){ ?><b><?php echo $text_order_id; ?></b> <?php echo $order_id; ?><br /><?php } ?>
    		<?php if(isset($invoice_no)){?><b><?php echo $text_invoice_no; ?></b> <?php echo $invoice_no; ?><br /><?php } ?>
          	<b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?><br />
          	<b><?php echo $text_new_order_status; ?></b> <?php echo $new_order_status; ?><br />
			<b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
          	<?php if ($shipping_method) { ?><b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?><?php } ?>
        </td>
        <td bgcolor="#fafafa" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0; word-wrap:break-word;">
        	<b><?php echo $text_email; ?></b> <a href="mailto:<?php echo $email; ?>" style="color:<?php echo $body_link_color; ?>; text-decoration:none; word-wrap:break-word;"><?php echo $email; ?></a><br />
          	<b><?php echo $text_telephone; ?></b> <?php echo $telephone; ?>
        </td>
	</tr>
	<tr>
    	<td bgcolor="#f6f6f6" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; border-bottom:1px solid #e0e0e0; word-wrap:break-word;">
    		<strong><?php echo $text_payment_address; ?></strong><br />
    		<span style="line-height:14px"><?php echo $payment_address; ?></span>
    	</td>
        <td bgcolor="#f6f6f6" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0; word-wrap:break-word;">
        	<?php if ($shipping_address) { ?>
        	<strong><?php echo $text_shipping_address; ?></strong><br />
        	<span style="line-height:14px"><?php echo $shipping_address; ?></span>
        	<?php } else { echo "&nbsp;"; }?>
        </td>
	</tr>
</tbody>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%" style="width:100%; table-layout:fixed; border-collapse:separate;">
<tr><td style="line-height: 0; font-size: 0;" height="15">&nbsp;</td></tr>
</table>

<table cellpadding="5" cellspacing="0" width="100%" style="table-layout:fixed; margin:0; color:#666; border-collapse:separate; -moz-border-radius:3px; -moz-box-shadow:0 1px 2px #d1d1d1; -webkit-border-radius:3px; -webkit-box-shadow:0 1px 2px #d1d1d1; background:#eaebec; border:1px solid #e0e0e0; border-radius:3px; box-shadow:0 1px 2px #d1d1d1; text-shadow:1px 1px 0px #fff;">
<thead>
	<tr>
        <th width="50%" bgcolor="#ededed" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:14px; word-wrap:break-word;">
        	<b><?php echo $text_product; ?></b>
        </th>
        <th width="25%" bgcolor="#ededed" style="text-align:right; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:14px; word-wrap:break-word;">
        	<b><?php echo $text_price; ?></b>
        </th>
        <th width="25%" bgcolor="#ededed" style="text-align:right; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:14px; word-wrap:break-word;">
        	<b><?php echo $text_total; ?></b>
        </th>
	</tr>
</thead>
<tbody>
	<?php $i = 0;
	foreach ($products as $product) {
		if(($i++ % 2)){
			$row_style_background = "#f6f6f6";
		} else {
			$row_style_background = "#fafafa";
		}
	?>
    <tr>
		<td bgcolor="<?php echo $row_style_background; ?>" style="word-wrap:break-word; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; border-bottom:1px solid #e0e0e0;">
			<?php if($product['image']){ ?>
				<img src="<?php echo $product['image']; ?>" alt="" style="border:none; float: left; display: inline; margin-right: 5px;" />
			<?php } ?>

			<?php echo $product['name']; ?>

			<br /><b><?php echo $text_model; ?>:</b> <?php echo $product['model']; ?>:

			<?php if(!empty($product['option'])){ ?>
			<br style="clear:both" />
			<ul style="margin:5px 0 0 0; padding:0 0 0 15px; font-size:<?php echo $body_product_option_size; ?>px; line-height:1;">
			<?php foreach ($product['option'] as $option) { ?>
				<li style="margin: 0 0 4px 0; padding:0;"><strong><?php echo $option['name']; ?>:</strong>&nbsp;<?php echo $option['value']; ?></li>
			<?php } ?>
			</ul>
			<?php } ?>
		</td>
		<td bgcolor="<?php echo $row_style_background; ?>" style="text-align:right; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0;">
			<?php if($product['quantity'] > 1) { echo $product['quantity']; ?> <b>x</b> <?php } echo $product['price']; ?>
		</td>
		<td bgcolor="<?php echo $row_style_background; ?>" style="text-align:right; font-family:Helvetica, Arial, sans-serif; font-size:12px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0;"><?php echo $product['total']; ?></td>
	</tr>
	<?php } ?>
	<?php
	if(isset($vouchers)){
		foreach ($vouchers as $voucher) {
			if(($i++ % 2)){
				$row_style_background = "#f6f6f6";
			} else {
				$row_style_background = "#fafafa";
			}
	?>
	<tr>
        <td colspan="2" bgcolor="<?php echo $row_style_background; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; border-bottom:1px solid #e0e0e0; word-wrap:break-word;"><?php echo $voucher['description']; ?></td>
		<td bgcolor="<?php echo $row_style_background; ?>" style="text-align:right; font-size:12px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0;"><?php echo $voucher['amount']; ?></td>
	</tr>
	<?php }
	} ?>
</tbody>
<tfoot>
	<?php foreach ($totals as $total) {
		if(($i++ % 2)){
			$row_style_background = "#f6f6f6";
		} else {
			$row_style_background = "#fafafa";
		}
	?>
	<tr>
		<td bgcolor="<?php echo $row_style_background; ?>" colspan="2" style="text-align:right; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; word-wrap:break-word;"><b><?php echo $total['title']; ?></b></td>
		<td bgcolor="<?php echo $row_style_background; ?>" style="text-align:right; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; border-left:1px solid #e0e0e0;"><?php echo $total['text']; ?></td>
	</tr>
	<?php } ?>
</tfoot>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%" style="width:100%; table-layout:fixed; border-collapse:separate;">
<tr><td style="line-height: 0; font-size: 0;" height="15">&nbsp;</td></tr>
</table>

<?php if($comment){ ?>
<p class="standard" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:0px; margin-bottom:8px;">
	<b><?php echo $text_new_comment; ?></b><br />
	<?php echo $comment; ?>
</p>
<?php } ?>

<p class="standard" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:0px; margin-bottom:0px;">
	<?php echo $text_footer; ?>
</p>