<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
			<tr>
			  <td><?php echo $entry_allow_layaway_deposit; ?></td>
			  <td>
				<?php if ($layaway_status) { ?>
				  <input type="radio" name="layaway_status" value="1" checked="checked" />
				  <?php echo $text_yes; ?>
				  <input type="radio" name="layaway_status" value="0" />
				  <?php echo $text_no; ?>
				<?php } else { ?>
				  <input type="radio" name="layaway_status" value="1" />
				  <?php echo $text_yes; ?>
				  <input type="radio" name="layaway_status" value="0" checked="checked" />
				  <?php echo $text_no; ?>
				<?php } ?>
			  </td>
			</tr>
			<tr>
			  <td><?php echo $entry_send_emails; ?></td>
			  <td>
				<?php if ($layaway_send_emails) { ?>
				  <input type="radio" name="layaway_send_emails" value="1" checked="checked" />
				  <?php echo $text_yes; ?>
				  <input type="radio" name="layaway_send_emails" value="0" />
				  <?php echo $text_no; ?>
				<?php } else { ?>
				  <input type="radio" name="layaway_send_emails" value="1" />
				  <?php echo $text_yes; ?>
				  <input type="radio" name="layaway_send_emails" value="0" checked="checked" />
				  <?php echo $text_no; ?>
				<?php } ?>
			  </td>
			</tr>
			<tr>
				<td><?php echo $entry_email_reminder; ?></td>
				<td><input type="text" name="layaway_email_reminder" value="<?php echo $layaway_email_reminder; ?>" size="3" /></td>
			</tr>
			<tr>
			  <td><?php echo $entry_allow_layaway_admin; ?></td>
			  <td>
				<?php if ($layaway_allow_admin) { ?>
				  <input type="radio" name="layaway_allow_admin" value="1" checked="checked" />
				  <?php echo $text_yes; ?>
				  <input type="radio" name="layaway_allow_admin" value="0" />
				  <?php echo $text_no; ?>
				<?php } else { ?>
				  <input type="radio" name="layaway_allow_admin" value="1" />
				  <?php echo $text_yes; ?>
				  <input type="radio" name="layaway_allow_admin" value="0" checked="checked" />
				  <?php echo $text_no; ?>
				<?php } ?>
				<span style="padding-left: 25px;"><?php echo $text_allow_layaway_admin; ?></span>
			  </td>
			</tr>
			<tr>
			  <td><?php echo $entry_button_name; ?></td>
			  <td><input type="text" name="layaway_button_name" value="<?php echo $layaway_button_name; ?>" size="20" /></td>
			</tr>
			<tr>
			  <td><?php echo $entry_min_layaway_deposit; ?></td>
			  <td>
				<input type="text" name="layaway_min_deposit" value="<?php echo $layaway_min_deposit; ?>" size="4" />
				<select style="margin-right: 10px;" name="layaway_deposit_type">
					<?php if ($layaway_deposit_type == "percent") { ?>
						<option value="percent" selected="selected">%</option>
						<option value="amount">+</option> 
					<?php } else { ?>
						<option value="percent">%</option>
						<option value="amount" selected="selected">+</option> 
					<?php } ?>
				</select>
				<?php if ($layaway_per_product) { ?>
					<input type="checkbox" name="layaway_per_product" value="1" checked="checked" />
				<?php } else { ?>
					<input type="checkbox" name="layaway_per_product" value="1" />
				<?php } ?><?php echo $entry_per_product; ?>
			  </td>
			</tr>
			<tr>
			  <td><?php echo $entry_layaway_timeframe; ?></td>
			  <td><input type="text" name="layaway_timeframe" value="<?php echo $layaway_timeframe; ?>" size="3" /> days</td>
			</tr>
			<tr>
			  <td><?php echo $entry_min_layaway_amount; ?></td>
			  <td><input type="text" name="layaway_min_amount" value="<?php echo $layaway_min_amount; ?>" size="4" /></td>
			</tr>
			<tr>
			  <td><?php echo $entry_layaway_payment_fee; ?></td>
			  <td><input type="text" name="layaway_payment_fee" value="<?php echo $layaway_payment_fee; ?>" size="5" /></td>
			</tr>
			<?php if (!empty($stores)) { ?>
			  <tr>
				<td><?php echo $entry_active_stores; ?></td>
				<td>
				  <?php foreach ($stores as $store) { ?>
					<?php if (isset($layaway_active_stores) && $layaway_active_stores != "") { ?>
					  <?php $active_store = 0; ?>
					  <?php if (in_array($store['store_id'], $layaway_active_stores)) { ?>
						<input style="margin-right: 6px; vertical-align: middle;" type="checkbox" name="layaway_active_stores[]" value="<?php echo $store['store_id']; ?>" checked="checked" /><?php echo $store['name']; ?>
					  <?php } else { ?>
						<input style="margin-right: 6px; vertical-align: middle;" type="checkbox" name="layaway_active_stores[]" value="<?php echo $store['store_id']; ?>" /><?php echo $store['name']; ?>
					  <?php } ?>
					<?php } else { ?>
					  <input style="margin-right: 6px; vertical-align: middle;" type="checkbox" name="layaway_active_stores[]" value="<?php echo $store['store_id']; ?>" /><?php echo $store['name']; ?>
					<?php } ?>
				  <?php } ?>
				</td>
			  </tr>
			<?php } ?>
			<?php if (!empty($customer_groups)) { ?>
			  <tr>
				<td><?php echo $entry_allow_customer_group; ?></td>
				<td>
				  <?php foreach ($customer_groups as $customer_group) { ?>
					<?php if (isset($layaway_customer_groups) && $layaway_customer_groups != "") { ?>
					  <?php if (in_array($customer_group['customer_group_id'], $layaway_customer_groups)) { ?>
						<input style="margin-right: 6px; vertical-align: middle;" type="checkbox" name="layaway_customer_groups[]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" /><?php echo $customer_group['name']; ?>
					  <?php } else { ?>
						<input style="margin-right: 6px; vertical-align: middle;" type="checkbox" name="layaway_customer_groups[]" value="<?php echo $customer_group['customer_group_id']; ?>" /><?php echo $customer_group['name']; ?>
					  <?php } ?>
					<?php } else { ?>
					  <input style="margin-right: 6px; vertical-align: middle;" type="checkbox" name="layaway_customer_groups[]" value="<?php echo $customer_group['customer_group_id']; ?>" /><?php echo $customer_group['name']; ?>
					<?php } ?>
				  <?php } ?>
				</td>
			  </tr>
			<?php } ?>
			<tr>
			  <td><?php echo $entry_hide_buttons; ?></td>
			  <td>
				<?php if (isset($layaway_hide_buttons) && $layaway_hide_buttons != "") { ?>
				  <?php foreach ($stores as $store) { ?>
					<?php if (in_array($store['store_id'], $layaway_hide_buttons)) { ?>
					  <input style="margin-right: 6px; vertical-align: middle;" type="checkbox" name="layaway_hide_buttons[]" value="<?php echo $store['store_id']; ?>" checked="checked" /><?php echo $store['name']; ?>
					<?php } else { ?>
					  <input style="margin-right: 6px; vertical-align: middle;" type="checkbox" name="layaway_hide_buttons[]" value="<?php echo $store['store_id']; ?>" /><?php echo $store['name']; ?>
					<?php } ?>
				  <?php } ?>
				<?php } else { ?>
				  <?php foreach ($stores as $store) { ?>
					<input style="margin-right: 6px; vertical-align: middle;" type="checkbox" name="layaway_hide_buttons[]" value="<?php echo $store['store_id']; ?>" /><?php echo $store['name']; ?>
				  <?php } ?>
				<?php } ?>
			  </td>
			</tr>
          <tr>
            <td><?php echo $entry_order_status; ?></td>
            <td><select name="layaway_order_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $layaway_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="layaway_geo_zone_id">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $layaway_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="layaway_sort_order" value="<?php echo $layaway_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 