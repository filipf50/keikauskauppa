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
	<?php echo $text_layaway_received; ?></strong>
</p>

<p class="standard" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:0px; margin-bottom:8px;">
	<?php echo $text_layaway_total; ?></strong>
</p>

<?php if ($customer_id && isset($link)) { ?>
<p class="link" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:13px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:5px; margin-bottom:15px;">
	<b><?php echo $text_link; ?></b><br />
	<span style="line-height:100%; font-size:120%;">&raquo;</span>
	<a href="<?php echo $link.(strpos($link,'?')===false ? '?' : '&amp;').$tracking.'&amp;utm_content=order_account'; ?>" style="color:<?php echo $body_link_color; ?>; text-decoration:none;" target="_blank">
		<b><?php echo $link; ?></b>
	</a>
</p>
<?php } ?>