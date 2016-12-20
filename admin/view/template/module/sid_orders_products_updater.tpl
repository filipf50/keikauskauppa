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
						<td class="left"><?php echo $entry_status; ?></td>
						<td class="left"><select name="sid_orders_products_updater[status]">
                                                    <?php if (count($settings)>0 && $settings['status']=='1') { ?>
                                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                                    <option value="0"><?php echo $text_disabled; ?></option>
                                                    <?php } else { ?>
                                                    <option value="1"><?php echo $text_enabled; ?></option>
                                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                                    <?php } ?>
                                                  </select>
                                                </td>
					</tr>
                    <tr>
                        <td class="left"><?php echo $entry_canceled_order_status; ?><br/>
                        <span class="help"><?php echo $entry_help_canceled_order_status; ?></span>
                        </td>
                        <td class="left">
                            <select name="sid_orders_products_updater[canceled_order_status]">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $settings['canceled_order_status']) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                              </select>
                        </td>
                    </tr>
			</table>
			</form>
		</div>
	</div>
</div>
<?php echo $footer; ?>