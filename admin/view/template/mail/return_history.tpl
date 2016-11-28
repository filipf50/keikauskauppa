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
	<strong><?php echo $text_return_id; ?></strong> <?php echo $return_id; ?><br />
	<strong><?php echo $text_date_added; ?></strong> <?php echo $date_added; ?>
</p>

<p class="standard" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:0px; margin-bottom:8px;">
	<?php echo $text_return_status; ?> <strong><?php echo $status; ?></strong>
</p>

<?php if($comment){ ?>
	<p class="standard" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:0px; margin-bottom:8px;">
		<strong><?php echo $text_comment; ?></strong><br /><?php echo $comment; ?>
	</p>
<?php } ?>

<?php if($show_summary){ ?>
	<table cellpadding="0" cellspacing="0" width="100%" style="width:100%; margin:0; color:#666; table-layout:auto; border-collapse:separate; -moz-border-radius:3px; -moz-box-shadow:0 1px 2px #d1d1d1; -webkit-border-radius:3px; -webkit-box-shadow:0 1px 2px #d1d1d1; background:#eaebec; border:1px solid #e0e0e0; border-radius:3px; box-shadow:0 1px 2px #d1d1d1; text-shadow:1px 1px 0px #fff;">
	<thead>
		<tr>
	        <th style="text-align:center; font-size:14px; padding:6px 5px 4px; background:#ededed; font-weight:bold;">
	        	<?php echo $text_product; ?>
	        </th>
	        <th style="text-align:center; font-size:14px; padding:6px 5px 4px; background:#ededed; font-weight:bold;">
	        	<?php echo $text_return; ?>
	        </th>
	        <th style="text-align:center; font-size:14px; padding:6px 5px 4px; background:#ededed; font-weight:bold;">
	        	<?php echo $text_opened; ?>
	        </th>
		</tr>
	</thead>
	<tbody>
	<?php $row_style_background = "background:#fafafa; "; ?>
	    <tr>
			<td style="word-wrap:break-word; padding:4px 5px; font-size:12px; border-bottom:1px solid #e0e0e0; <?php echo $row_style_background; ?>">
				<?php echo $name; ?>
				<ul style="margin:5px 0 0; padding:0 0 0 15px; font-size:<?php echo $body_product_option_size; ?>px; line-height:1;">
					<?php if($model){ ?><li><strong><?php echo $text_model; ?>:</strong>&nbsp;<?php echo $model; ?></li><?php } ?>
					<?php if($quantity){ ?><li><strong><?php echo $text_quantity; ?>:</strong>&nbsp;<?php echo $quantity; ?></li><?php } ?>
				</ul>
			</td>
			<td style="padding:4px 5px; font-size:12px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0; <?php echo $row_style_background; ?>">
				<?php echo $reason; ?>
			</td>
			<td style="text-align:center; padding:4px 5px; font-size:12px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0; <?php echo $row_style_background; ?>">
				<?php echo $opened; ?>
			</td>
		</tr>
	</tbody>
	</table>
	
	<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%" style="width:100%; table-layout:fixed; border-collapse:separate;">
	<tr><td style="line-height: 0; font-size: 0;" height="15">&nbsp;</td></tr>
	</table>
<?php } ?>

<p class="standard" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?php echo $body_font_color; ?>; margin-top:0px; margin-bottom:0px;">
	<?php echo $text_footer; ?>
</p>