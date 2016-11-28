<p class="standard" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:0px; margin-bottom:8px;">
	<?php echo $text_greeting; ?>,<br style="line-height:18px;" />
	<span style="color:#000000"><?php echo $text_from; ?></span>
</p>

<?php if ($message) { ?>
	<p class="standard" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:0px; margin-bottom:8px;">
		<?php echo $text_message; ?>,<br style="line-height:18px;" />
		<span style="color:#000000"><?php echo $message; ?></span>
	</p>
<?php } ?>


<p class="link" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:13px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:5px; margin-bottom:15px;">
	<b><?php echo $text_redeem; ?></b><br />
	<span style="line-height:100%; font-size:120%;">&raquo;</span>
	<a href="<?php echo $store_url . (strpos($store_url,'?')===false ? '?' : '&amp;').$tracking.'&amp;utm_content=redeem_url'; ?>" style="color:<?php echo $body_link_color; ?>; text-decoration:none;" target="_blank">
		<b><?php echo $store_url; ?></b>
	</a>
</p>

<p class="standard" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:0px; margin-bottom:0px;">
	<?php echo $text_footer; ?>
</p>