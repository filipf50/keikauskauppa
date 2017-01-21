<?php function getOptionsHTML($arrOptions,$arrValues, $fieldID){
    $html='';
    foreach ($arrOptions as $option){
        if ($option['type'] == 'select') {
                $html .= '<div id="' . $fieldID . '-' . $option['product_option_id'] . '~1">';

                if ($option['required']) {
                        $html .= '<span class="required">*</span> ';
                }

                $html .= $option['name'] . '<br />';
                $html .= '<select name="' . $fieldID . '[' . $option['product_option_id'] . '~1]">';
                $html .= '<option value="">--Select value--</option>';

                for ($j = 0; $j < count($option['option_value']); $j++) {
                        $option_value = $option['option_value'][$j];

                        $html .= '<option value="' . $option_value['product_option_value_id'] . '"';
                        if ($option_value['product_option_value_id'] == $arrValues[$option['product_option_id'] . '~1']){
                            $html .= ' selected="selected"' ;
                        }
                        $html .= '>' . $option_value['name'];

                        if ($option_value['price']) {
                                $html .= ' (' . $option_value['price_prefix'] . $option_value['price'] . ')';
                        }

                        $html .= '</option>';
                }

                $html .= '</select>';
                $html .= '</div>';
                $html .= '<br />';
        }

        if ($option['type'] == 'radio') {
                $html .= '<div id="' . $fieldID . '-' . $option['product_option_id'] . '">';

                if ($option['required']) {
                        $html .= '<span class="required">*</span> ';
                }

                $html .= $option['name'] . '<br />';
                $html .= '<select name="' . $fieldID . '[' . $option['product_option_id'] . ']">';
                $html .= '<option value="">$text_select</option>';

                for ($j = 0; $j<count($option['option_value']); $j++) {
                        $option_value = $option['option_value'][$j];

                        $html .= '<option value="' . $option_value['product_option_value_id'] . '">' . $option_value['name'];

                        if ($option_value['price']) {
                                $html .= ' (' . $option_value['price_prefix'] . $option_value['price'] . ')';
                        }

                        $html .= '</option>';
                }

                $html .= '</select>';
                $html .= '</div>';
                $html .= '<br />';
        }

        if ($option['type'] == 'checkbox') {
                $html .= '<div id="' . $fieldID . '-' . $option['product_option_id'] . '">';

                if ($option['required']) {
                        $html .= '<span class="required">*</span> ';
                }

                $html .= $option['name'] . '<br />';

                for ($j = 0; $j < count($option['option_value']); $j++) {
                        $option_value = $option['option_value'][$j];

                        $html .= '<input type="checkbox" name="' . $fieldID . '[' . $option['product_option_id'] . '][]" value="' . $option_value['product_option_value_id'] . '" id="' . $fieldID . '-value-' . $option_value['product_option_value_id'] . '" />';
                        $html .= '<label for="' . $fieldID . '-value-' . $option_value['product_option_value_id'] . '">' . $option_value['name'];

                        if ($option_value['price']) {
                                $html .= ' (' . $option_value['price_prefix'] . $option_value['price'] . ')';
                        }

                        $html .= '</label>';
                        $html .= '<br />';
                }

                $html .= '</div>';
                $html .= '<br />';
        }

        if ($option['type'] == 'image') {
                $html .= '<div id="' . $fieldID . '-' . $option['product_option_id'] . '">';

                if ($option['required']) {
                        $html .= '<span class="required">*</span> ';
                }

                $html .= $option['name'] . '<br />';
                $html .= '<select name="' . $fieldID . '[' . $option['product_option_id'] . ']">';
                $html .= '<option value="">' . $text_select . '</option>';

                for ($j = 0; $j < $option['option_value'].length(); $j++) {
                        $option_value = $option['option_value'][$j];

                        $html .= '<option value="' . $option_value['product_option_value_id'] . '">' . $option_value['name'];

                        if ($option_value['price']) {
                                $html .= ' (' . $option_value['price_prefix'] . $option_value['price'] . ')';
                        }

                        $html .= '</option>';
                }

                $html .= '</select>';
                $html .= '</div>';
                $html .= '<br />';
        }

        if ($option['type'] == 'text') {
                $html .= '<div id="' . $fieldID . '-' . $option['product_option_id'] . '~0">';

                if ($option['required']) {
                        $html .= '<span class="required">*</span> ';
                }

                $html .= $option['name'] . '<br />';
                $html .= '<input type="text" name="' . $fieldID . '[' . $option['product_option_id'] . '~0]" value="' . $arrValues[$option['product_option_id'] . '~0'] . '" />';
                $html .= '</div>';
                $html .= '<br />';
        }

        if ($option['type'] == 'textarea') {
                $html .= '<div id="' . $fieldID . '-' . $option['product_option_id'] . '">';

                if ($option['required']) {
                        $html .= '<span class="required">*</span> ';
                }

                $html .= $option['name'] . '<br />';
                $html .= '<textarea name="' . $fieldID . '[' . $option['product_option_id'] . ']" cols="40" rows="5">' . $option['option_value'] . '</textarea>';
                $html .= '</div>';
                $html .= '<br />';
        }

        if ($option['type'] == 'date') {
                $html .= '<div id="' . $fieldID . '-' . $option['product_option_id'] . '">';

                if ($option['required']) {
                        $html .= '<span class="required">*</span> ';
                }

                $html .= $option['name'] . '<br />';
                $html .= '<input type="text" name="' . $fieldID . '[' . $option['product_option_id'] . ']" value="' . $option['option_value'] . '" class="date" />';
                $html .= '</div>';
                $html .= '<br />';
        }

        if ($option['type'] == 'datetime') {
                $html .= '<div id="' . $fieldID . '-' . $option['product_option_id'] . '">';

                if ($option['required']) {
                        $html .= '<span class="required">*</span> ';
                }

                $html .= $option['name'] . '<br />';
                $html .= '<input type="text" name="' . $fieldID . '[' . $option['product_option_id'] . ']" value="' . $option['option_value'] . '" class="datetime" />';
                $html .= '</div>';
                $html .= '<br />';						
        }

        if ($option['type'] == 'time') {
                $html .= '<div id="' . $fieldID . '-' . $option['product_option_id'] . '">';

                if ($option['required']) {
                        $html .= '<span class="required">*</span> ';
                }

                $html .= $option['name'] . '<br />';
                $html .= '<input type="text" name="' . $fieldID . '[' . $option['product_option_id'] . ']" value="' . $option['option_value'] . '" class="time" />';
                $html .= '</div>';
                $html .= '<br />';						
        }
    }
    return $html;
}?>
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
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <table class="form">
            <tr>
              <td><span class="required">*</span><?php echo $entry_date_start; ?></td>
              <td>
                <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="filter_date-start" size="12" />
              </td>
              <td><span class="required">*</span><?php echo $entry_date_end; ?></td>
              <td>      
                <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="filter_date-end" size="12" />
              </td>
              <td style="text-align: right;"><a onclick="$('#form').submit();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <tr>
              <td><span class="required">*</span><?php echo $entry_order_start; ?></td>
              <td>
                <input type="text" name="filter_order_start" value="<?php echo $filter_order_start; ?>" id="filter_order-start" size="12" />
              </td>
              <td><span class="required">*</span><?php echo $entry_order_end; ?></td>
              <td>      
                <input type="text" name="filter_order_end" value="<?php echo $filter_order_end; ?>" id="filter_order-end" size="12" />
              </td>
            </tr>
            <tr>
                <td>
                    <?php echo $entry_status; ?>
                </td>
                <td><div class="scrollbox">
                      <?php $class = 'even'; ?>
                      <?php foreach ($order_statuses as $status) { ?>
                      <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                      <div class="<?php echo $class; ?>">
                        <?php if (in_array($status['order_status_id'], $filter_order_statuses_ids)) { ?>
                            <input type="checkbox" name="filter_order_statuses_ids[]" value="<?php echo $status['order_status_id']; ?>" checked="checked" />
                            <?php echo $status['name']; ?>
                        <?php } else { ?>
                            <input type="checkbox" name="filter_order_statuses_ids[]" value="<?php echo $status['order_status_id']; ?>" />
                            <?php echo $status['name']; ?>
                        <?php } ?>
                      </div>
                      <?php } ?>
                    </div>
                </td>
                <td><?php echo $entry_store; ?></td>
                  <td><div class="scrollbox">
                      <?php $class = 'even'; ?>
                      <div class="<?php echo $class; ?>">
                        <?php if (in_array(0, $filter_order_stores_ids)) { ?>
                            <input type="checkbox" name="filter_stores_ids[]" value="0" checked="checked" />
                            <?php echo $text_default; ?>
                        <?php } else { ?>
                            <input type="checkbox" name="filter_stores_ids[]" value="0" />
                            <?php echo $text_default; ?>
                        <?php } ?>
                      </div>
                      <?php foreach ($stores as $store) { ?>
                      <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                      <div class="<?php echo $class; ?>">
                        <?php if (in_array($store['store_id'], $filter_order_stores_ids)) { ?>
                        <input type="checkbox" name="filter_stores_ids[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="filter_stores_ids[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                        <?php } ?>
                      </div>
                      <?php } ?>
                    </div></td>
                    <td></td>
            </tr>
            <tr>
                <td><span class="required">*</span><?php echo $entry_product; ?></td>
                <td>
                    <input type="text" name="product_to_delete" id="product_to_delete" size="50" value="<?php echo $product_to_delete; ?>">
                    <input type="hidden" name="product_to_delete_id" id ="product_to_delete_id" value="<?php echo $product_to_delete_id; ?>">
                </td>
                <td><span class="required">*</span><?php echo $entry_product_dest; ?></td>
                <td>
                    <input type="text" name="product_to_add" id="product_to_add" size="50" value="<?php echo $product_to_add; ?>">
                    <input type="hidden" name="product_to_add_id" id ="product_to_add_id" value="<?php echo $product_to_add_id; ?>">
                </td>
              </tr>
            <!--<tr id="option"></tr>!-->
            <tr id="options">
                <?php if(count($product_to_delete_options)>0){ ?>
                    <td id="option_ori_lbl" class="left"><?php echo $entry_option; ?></td>
                <?php } else { ?>
                    <td id="option_ori_lbl" class="left"></td>
                <?php } ?>
                <?php if(count($product_to_delete_options)>0){ ?> 
                    <td id="option_ori_val" class="left">
                        <?php 
                            $html=getOptionsHTML($product_to_delete_options, $filter_options_to_delete, 'filter_options_to_delete');
                            echo $html;
                        ?>
                    </td>
                <?php } else { ?>
                    <td id="option_ori_val" class="left"></td>
                <?php } ?>
                <?php if(count($product_to_add_options)>0){ ?>
                    <td id="option_dest_lbl" class="left"><?php echo $entry_option; ?></td>
                <?php } else { ?>
                    <td id="option_dest_lbl" class="left"></td>
                <?php } ?>
                <?php if(count($product_to_add_options>0)){ ?> 
                    <td id="option_dest_val" class="left">
                        <?php 
                            $html=getOptionsHTML($product_to_add_options, $filter_options_to_add, 'filter_options_to_add');
                            echo $html;
                        ?>
                    </td>
                <?php } else { ?>
                    <td id="option_dest_val" class="left"></td>
                <?php } ?>
            </tr>
          </table>
      </div>
      <?php if ($orders){ ?>
      <div class="box">
          <div class="heading">
              <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_orders_title; ?></h1>
              <div class="buttons"><a onclick="removeProducts();" class="button"><?php echo $button_update; ?></a></div>  
          </div>
          <table class="list">
              <thead>
                <tr>
                  <td class="left"><?php echo $column_order; ?></td>
                  <td class="left"><?php echo $column_date; ?></td>
                  <td class="right"><?php echo $column_customer; ?></td>
                  <td class="right"><?php echo $column_status; ?></td>
                  <td class="right"><?php echo $column_order_products; ?></td>
                  <td class="right"><?php echo $column_products_to_remove; ?></td>
                  <td class="right"><?php echo $column_pending_products; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($orders) { ?>
                <?php foreach ($orders as $order) { ?>
                <tr>
                  <td class="left"><?php echo $order['order_id']; ?></td>
                  <td class="left"><?php echo $order['date_added']; ?></td>
                  <td class="right"><?php echo $order['customer']; ?></td>
                  <td class="right"><?php echo $order['status']; ?></td>
                  <td class="right"><?php echo $order['totalproducts']; ?></td>
                  <td class="right"><?php echo $order['productsToRemove']; ?></td>
                  <td class="right"><?php echo $order['pendingProducts']; ?></td>
                </tr>
                <?php }?>
                <?php } else { ?>
                <tr>
                  <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<!--<script type="text/javascript">
// Related
$('input[name=\'product\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('#products_to_delete' + ui.item.value).remove();
		
		$('#products_to_delete').append('<div id="products_to_delete' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="products_to_delete[][id]" value="' + ui.item.value + '" /><input type="hidden" name="products_to_delete[][name]" value="' + ui.item.label + '" /></div>');

		$('#products_to_delete div:odd').attr('class', 'odd');
		$('#products_to_delete div:even').attr('class', 'even');
                
                $('#product').val(ui.item.label);
				
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});

$(document).ready(function() {
	$('#filter_date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#filter_date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
-->
<script type="text/javascript"><!--
function getOptionsHtml(ui,fieldID){
    html='';
    for (i = 0; i < ui.item['option'].length; i++) {
        option = ui.item['option'][i];

        if (option['type'] == 'select') {
                html += '<div id="' + fieldID + '-' + option['product_option_id'] + '~1">';

                if (option['required']) {
                        html += '<span class="required">*</span> ';
                }

                html += option['name'] + '<br />';
                html += '<select name="' + fieldID + '[' + option['product_option_id'] + '~1]">';
                html += '<option value=""><?php echo $text_select; ?></option>';

                for (j = 0; j < option['option_value'].length; j++) {
                        option_value = option['option_value'][j];

                        html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];

                        if (option_value['price']) {
                                html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
                        }

                        html += '</option>';
                }

                html += '</select>';
                html += '</div>';
                html += '<br />';
        }

        if (option['type'] == 'radio') {
                html += '<div id="' + fieldID + '-' + option['product_option_id'] + '">';

                if (option['required']) {
                        html += '<span class="required">*</span> ';
                }

                html += option['name'] + '<br />';
                html += '<select name="' + fieldID + '[' + option['product_option_id'] + ']">';
                html += '<option value=""><?php echo $text_select; ?></option>';

                for (j = 0; j < option['option_value'].length; j++) {
                        option_value = option['option_value'][j];

                        html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];

                        if (option_value['price']) {
                                html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
                        }

                        html += '</option>';
                }

                html += '</select>';
                html += '</div>';
                html += '<br />';
        }

        if (option['type'] == 'checkbox') {
                html += '<div id="' + fieldID + '-' + option['product_option_id'] + '">';

                if (option['required']) {
                        html += '<span class="required">*</span> ';
                }

                html += option['name'] + '<br />';

                for (j = 0; j < option['option_value'].length; j++) {
                        option_value = option['option_value'][j];

                        html += '<input type="checkbox" name="' + fieldID + '[' + option['product_option_id'] + '][]" value="' + option_value['product_option_value_id'] + '" id="' + fieldID + '-value-' + option_value['product_option_value_id'] + '" />';
                        html += '<label for="' + fieldID + '-value-' + option_value['product_option_value_id'] + '">' + option_value['name'];

                        if (option_value['price']) {
                                html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
                        }

                        html += '</label>';
                        html += '<br />';
                }

                html += '</div>';
                html += '<br />';
        }

        if (option['type'] == 'image') {
                html += '<div id="' + fieldID + '-' + option['product_option_id'] + '">';

                if (option['required']) {
                        html += '<span class="required">*</span> ';
                }

                html += option['name'] + '<br />';
                html += '<select name="' + fieldID + '[' + option['product_option_id'] + ']">';
                html += '<option value=""><?php echo $text_select; ?></option>';

                for (j = 0; j < option['option_value'].length; j++) {
                        option_value = option['option_value'][j];

                        html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];

                        if (option_value['price']) {
                                html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
                        }

                        html += '</option>';
                }

                html += '</select>';
                html += '</div>';
                html += '<br />';
        }

        if (option['type'] == 'text') {
                html += '<div id="' + fieldID + '-' + option['product_option_id'] + '~0">';

                if (option['required']) {
                        html += '<span class="required">*</span> ';
                }

                html += option['name'] + '<br />';
                html += '<input type="text" name="' + fieldID + '[' + option['product_option_id'] + '~0]" value="' + option['option_value'] + '" />';
                html += '</div>';
                html += '<br />';
        }

        if (option['type'] == 'textarea') {
                html += '<div id="' + fieldID + '-' + option['product_option_id'] + '">';

                if (option['required']) {
                        html += '<span class="required">*</span> ';
                }

                html += option['name'] + '<br />';
                html += '<textarea name="' + fieldID + '[' + option['product_option_id'] + ']" cols="40" rows="5">' + option['option_value'] + '</textarea>';
                html += '</div>';
                html += '<br />';
        }

        if (option['type'] == 'date') {
                html += '<div id="' + fieldID + '-' + option['product_option_id'] + '">';

                if (option['required']) {
                        html += '<span class="required">*</span> ';
                }

                html += option['name'] + '<br />';
                html += '<input type="text" name="' + fieldID + '[' + option['product_option_id'] + ']" value="' + option['option_value'] + '" class="date" />';
                html += '</div>';
                html += '<br />';
        }

        if (option['type'] == 'datetime') {
                html += '<div id="' + fieldID + '-' + option['product_option_id'] + '">';

                if (option['required']) {
                        html += '<span class="required">*</span> ';
                }

                html += option['name'] + '<br />';
                html += '<input type="text" name="' + fieldID + '[' + option['product_option_id'] + ']" value="' + option['option_value'] + '" class="datetime" />';
                html += '</div>';
                html += '<br />';						
        }

        if (option['type'] == 'time') {
                html += '<div id="' + fieldID + '-' + option['product_option_id'] + '">';

                if (option['required']) {
                        html += '<span class="required">*</span> ';
                }

                html += option['name'] + '<br />';
                html += '<input type="text" name="' + fieldID + '[' + option['product_option_id'] + ']" value="' + option['option_value'] + '" class="time" />';
                html += '</div>';
                html += '<br />';						
        }
    }
    return html;
}

$('input[name=\'product_to_delete\']').autocomplete({
	delay: 250,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {	
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id,
						model: item.model,
						option: item.option,
						price: item.price
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'product_to_delete\']').attr('value', ui.item['label']);
		$('input[name=\'product_to_delete_id\']').attr('value', ui.item['value']);
		
		if (ui.item['option'] != '') {
			html = '';

			html=getOptionsHtml(ui,'filter_options_to_delete');
			                        
			//$('#option').html('<td class="left"><?php echo $entry_option; ?></td><td class="left">' + html + '</td>');
                        $('#options').show();
                        $('#option_ori_lbl').html('<?php echo $entry_option; ?>');
                        $('#option_ori_val').html(html);

						
			$('.date').datepicker({dateFormat: 'yy-mm-dd'});
			
		} else {
			//$('#option td').remove();
                        $('#option_ori_lbl').html('');
                        $('#option_ori_val').html('');
                        if ($('#option_dest_lbl').html()==''){
                            $('#options').hide();
                        }
		}
		
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('input[name=\'product_to_add\']').autocomplete({
	delay: 250,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {	
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id,
						model: item.model,
						option: item.option,
						price: item.price
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'product_to_add\']').attr('value', ui.item['label']);
		$('input[name=\'product_to_add_id\']').attr('value', ui.item['value']);
		
		if (ui.item['option'] != '') {
			html = '';

			html=getOptionsHtml(ui,'filter_options_to_add');
                        
			//$('#option').html('<td class="left"><?php echo $entry_option; ?></td><td class="left">' + html + '</td>');
                        $('#options').show();
                        $('#option_dest_lbl').html('<?php echo $entry_option; ?>');
                        $('#option_dest_val').html(html);

						
			$('.date').datepicker({dateFormat: 'yy-mm-dd'});
			
		} else {
			//$('#option td').remove();
                        $('#option_dest_lbl').html('');
                        $('#option_dest_val').html('');
                        if ($('#option_ori_lbl').html()==''){
                            $('#options').hide();
                        }
		}
		
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

function removeProducts(){
    if (confirm('<?php echo $text_removeMsg; ?>')){
        $('#form').attr('action', '<?php echo html_entity_decode($delete); ?>'); 
        $('#form').attr('target', '_self'); 
        $('#form').submit();
    }
}

$(document).ready(function() {
	$('#filter_date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#filter_date-end').datepicker({dateFormat: 'yy-mm-dd'});
        
        if($('#product_to_delete').val()==''){
            $('#options').hide();
        }
        
        $('#product_to_delete').change(function(){
            if($('#product_to_delete').val()==''){
                $('#option_ori_lbl').html('');
                $('#option_ori_val').html('');
                $('#product_to_delete_id').val('');
            }
        });
        
        $('#product_to_add').change(function(){
            if($('#product_to_add').val()==''){
                $('#option_dest_lbl').html('');
                $('#option_dest_val').html('');
                $('#product_to_add_id').val('');
            }
        });
});
//--></script> 
<!--<script type="text/javascript">
$('select[name=\'product_to_delete\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=sale/sid_orders_products_updater/options&token=<?php echo $token; ?>&product_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'products_to_delete\']').after('<span class="wait">&nbsp;<img src="../catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
                        $('#product_optionsBox').html("");
                        $('#product_optionsBox').append('<div id="product_options" class="scrollbox"></div>');
                        $.each(json, function(oindex,option){
                            $('#product_options').append('<div><input type="checkbox" name="filter_product_options[]" value="'+oindex+ '" />' +option+'</div>')
                            $('#product_options div:odd').attr('class', 'odd');
                            $('#product_options div:even').attr('class', 'even');
                        });
                        $('#product_optionsBox').show();
			
			console.log(json);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');

//</script> 
-->
<?php echo $footer; ?>