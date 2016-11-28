<?php echo $header; ?>

<div id="content">
	<div class="breadcrumb">
		<?php foreach( $breadcrumbs as $breadcrumb ) { ?>
			<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	
	<?php if( $error_warning ) { ?>
		<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	
	<?php if( $success ) { ?>
		<div class="success"><?php echo $success; ?></div>
	<?php } ?>
	
	<div class="box">
		<div class="heading">
			<h1><img src="view/image/module.png" alt="<?php echo $heading_title; ?>" /><?php echo $heading_title; ?></h1>
			<div class="buttons">
				<a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
				<a onclick="location = '<?php echo $back; ?>';" class="button"><span><?php echo $button_back; ?></span></a>
			</div>
		</div>
		
		<div class="content">
			<div class="htabs">
				<a style="display: block" class="selected" href="<?php echo $tab_action_settings; ?>"><?php echo $tab_settings; ?></a>
				<a style="display: block" href="<?php echo $tab_action_about; ?>"><?php echo $tab_about; ?></a>
			</div>			
			
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<table class="form">
					<tr>
						<td>
							<?php echo $entry_mode_product; ?>
						</td>
						<td>
							<select name="<?php echo $_name; ?>[mode_product]">
								<option <?php echo empty( $settings['mode_product'] ) || $settings['mode_product'] == 'available' ? 'selected="selected"' : ''; ?> value="available"><?php echo $text_mode_available; ?></option>
								<option <?php echo isset( $settings['mode_product'] ) && $settings['mode_product'] == 'unavailable' ? 'selected="selected"' : ''; ?> value="unavailable"><?php echo $text_mode_unavailable; ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<?php echo $entry_mode_category; ?>
						</td>
						<td>
							<select name="<?php echo $_name; ?>[mode_category]">
								<option <?php echo empty( $settings['mode_category'] ) || $settings['mode_category'] == 'available' ? 'selected="selected"' : ''; ?> value="available"><?php echo $text_mode_available; ?></option>
								<option <?php echo isset( $settings['mode_category'] ) && $settings['mode_category'] == 'unavailable' ? 'selected="selected"' : ''; ?> value="unavailable"><?php echo $text_mode_unavailable; ?></option>
							</select>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
<?php echo $footer; ?>