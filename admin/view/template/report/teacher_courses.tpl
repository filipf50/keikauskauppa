<?php echo $header;?>
<style>
		.ui-highlight .ui-state-default{
			background: lightgreen !important;
		}
                
                .ui-coursedate .ui-state-default{
			background: lightpink !important;
		}
	</style>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
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
            <td style="text-align: right;"><a onclick="export_data('excell');" class="button"><?php echo $button_excel; ?></a></td>  
          <td style="text-align: right;"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_order; ?></td>
            <td class="left"><?php echo $column_status; ?></td>
            <td class="left"><?php echo $column_date_added; ?></td>
            <td class="left"><?php echo $column_email; ?></td>
            <td class="left"><?php echo $column_phone; ?></td>
            <td class="left"><?php echo $column_product_name; ?></td>
            <td class="left"><?php echo $column_model; ?></td>
            <td class="left"><?php echo $column_option; ?></td>
            <?php if($rc_status){ ?>
                <td class="left"><?php echo $column_roll; ?></td>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php if (isset($courses)) { ?>
          <?php foreach ($courses as $course) { ?>
          <tr>
            <td class="left"><?php echo $course['order_id']; ?></td>
            <td class="left"><?php echo $course['status']; ?></td>
            <td class="left"><?php echo $course['date_added']; ?></td>
            <td class="left"><?php echo $course['email']; ?></td>
            <td class="left"><?php echo $course['telephone']; ?></td>
            <td class="left"><?php echo $course['name']; ?></td>
            <td class="left"><?php echo $course['model']; ?></td>
            <td class="left">
                <?php foreach ($course['options'] as $option) { ?>
                    <br />
                    &nbsp; - <?php echo $option['name']; ?>: <?php echo $option['value']; ?>
                <?php } ?>
            </td>
            <?php if($rc_status){ ?>
                <td class="left">
                    <div id="<?php echo $course['order_id'] . '-' . $course['order_product_id']; ?>" class="dp">
                        <script type="text/javascript"><!--
                            $(".dp").datepicker({
                                    dateFormat: 'yyyy-mm-dd',
                                    beforeShowDay : function(date){
                                        var y = date.getFullYear().toString(); // get full year
                                        var dates=[<?php echo "'" . implode("','",$course['roll_call_dates']) . "'"; ?>] //['2014-10-01','2014-10-08','2014-10-15']
                                        var course_dates=[<?php echo "'" . implode("','",$course['time_table']) . "'"; ?>]//['2014-10-01','2014-10-08','2014-10-15','2014-10-22','2014-10-29']
                                        var m = (date.getMonth() + 1).toString(); // get month.
                                        var d = date.getDate().toString(); // get Day
                                        if(m.length == 1){ m = '0' + m; } // append zero(0) if single digit
                                        if(d.length == 1){ d = '0' + d; } // append zero(0) if single digit
                                        var currDate = y+'-'+m+'-'+d;
                                        if(dates.indexOf(currDate) >= 0){
                                                return [true, "ui-highlight"];	
                                        }else if (course_dates.indexOf(currDate)>=0){
                                                return [true,"ui-coursedate"];
                                        }else{
                                            return[true];
                                        }
                                    }
                                });
                    //--></script> 
                    </div>
                </td>
           <?php } ?>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/teacher_courses&token=<?php echo $token; ?>';
	
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
            url = 'index.php?route=report/teacher_courses&token=<?php echo $token; ?>'

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

<?php echo $footer; ?>