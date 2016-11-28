<?php echo $header;?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
 <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
     <form action="" method="post" enctype="multipart/form-data" id="form">  
        <table class="form">
           <tr>
             <td><?php echo $entry_product_name; ?>
               <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" id="filter_name" size="24" /></td>
             <td><?php echo $entry_model; ?>
               <input type="text" name="filter_model" value="<?php echo $filter_model; ?>" id="filter_model" size="12" /></td>
             <td><?php echo $entry_option; ?>
                <input type="text" name="filter_option" value="<?php echo $filter_option; ?>" id="filter_option" size="24" /></td>
             <td><?php echo $entry_status; ?>
               <select name="filter_status_id">
                 <option value="0"><?php echo $text_all_status; ?></option>
                 <?php foreach ($order_statuses as $order_status) { ?>
                 <?php if ($order_status['order_status_id'] == $filter_status_id) { ?>
                 <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                 <?php } else { ?>
                 <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                 <?php } ?>
                 <?php } ?>
               </select></td>
             <td style="text-align: right;"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
             <td style="text-align: right;"><a onclick="export_data('excell');" class="button"><?php echo $button_excel; ?></a></td>  
             <td style="text-align: right;"><?php echo $entry_roll_date; ?><input type="text" name="roll_date" class="roll" value="<?php echo $roll_date; ?>"/><a onclick="$('#form').attr('action', '<?php echo $save; ?>'); $('#form').attr('target', '_self'); $('#form').submit();" class="button"><?php echo $button_save; ?></a></td>
           </tr>
         </table>
         <table class="list">
           <thead>
             <tr>
               <td class="left"><?php echo $column_product_name; ?></td>
               <td class="left"><?php echo $column_model; ?></td>
               <td class="left"><?php echo $column_order; ?></td>
               <td class="left"><?php echo $column_status; ?></td>
               <td class="left"><?php echo $column_date_added; ?></td>
               <td class="left"><?php echo $column_email; ?></td>
               <td class="left"><?php echo $column_phone; ?></td>
               <td class="left"><?php echo $column_option; ?></td>
               <td class="left"><input type="checkbox" onclick="$('input[name*=\'assist\']').attr('checked', this.checked);" /><?php echo $column_assist; ?></td>
             </tr>
           </thead>
           <tbody>
             <?php if (isset($courses)) { ?>
             <?php foreach ($courses as $course) { ?>
             <tr>
               <td class="left"><?php echo $course['name']; ?></td>
               <td class="left"><?php echo $course['model']; ?></td>
               <td class="left"><?php echo $course['order_id']; ?></td>
               <td class="left"><?php echo $course['status']; ?></td>
               <td class="left"><?php echo $course['date_added']; ?></td>
               <td class="left"><?php echo $course['email']; ?></td>
               <td class="left"><?php echo $course['telephone']; ?></td>
               <td class="left">
                   <?php foreach ($course['options'] as $option) { ?>
                       <br />
                       &nbsp;- <?php echo $option['name']; ?>: <?php echo $option['value']; ?>
                   <?php } ?>
               </td>
               <td class="left">
                   <input type="hidden" name="fault[]" checked="checked" value="<?php echo $course['order_id'] . '-' . $course['order_product_id']; ?>"> 
                   <input type="checkbox" <?php if ($course['assist']){ echo 'checked="checked"'; } ?> name="assist[]" value="<?php echo $course['order_id'] . '-' . $course['order_product_id']; ?>">
               </td>
             </tr>
             <?php } ?>
             <?php } else { ?>
             <tr>
               <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
             </tr>
             <?php } ?>
           </tbody>
         </table>
     </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/teacher_rollcall&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_model = $('input[name=\'filter_model\']').attr('value');
	
	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}
	
        var filter_option = $('input[name=\'filter_option\']').attr('value');
	
	if (filter_option) {
		url += '&filter_option=' + encodeURIComponent(filter_option);
	}
        
	var filter_status_id = $('select[name=\'filter_status_id\']').attr('value');
	
	if (filter_status_id !== '*') {
		url += '&filter_status_id=' + encodeURIComponent(filter_status_id );
	}	
        
        var roll_date = $('input[name=\'roll_date\']').attr('value');
	
	if (roll_date !== '*') {
		url += '&roll_date=' + encodeURIComponent(roll_date);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<script type="text/javascript"><!--
    $('input[name=\'filter_name\']').autocomplete({
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
		$('input[name=\'filter_name\']').val(ui.item.label);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
    });
//--></script> 
<script type="text/javascript"><!--
    function export_data(type) {
            url = 'index.php?route=report/teacher_rollcall&token=<?php echo $token; ?>'

            url+='&export=' + encodeURIComponent(type);

            var filter_name = $('input[name=\'filter_name\']').attr('value');

            if (filter_name) {
                    url += '&filter_name=' + encodeURIComponent(filter_name);
            }

            var filter_model = $('input[name=\'filter_model\']').attr('value');

            if (filter_model) {
                    url += '&filter_model=' + encodeURIComponent(filter_model);
            }
            
            var filter_option = $('input[name=\'filter_option\']').attr('value');

            if (filter_option) {
                    url += '&filter_option=' + encodeURIComponent(filter_option);
            }
            
            var filter_status_id = $('select[name=\'filter_status_id\']').attr('value');
	
            if (filter_status_id !== '*') {
		url += '&filter_status_id=' + encodeURIComponent(filter_status_id );
            }

        location = url;
    }
//--></script> 

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.roll').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<?php echo $footer; ?>