<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                    <tr>
                        <td><?php echo $entry_status; ?></td>
                        <td><select style="min-width: 100px;" name="rc_status">
                                <?php if ($rc_status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select></td>
                    </tr>  
                    
                    <tr>
                        <td><span class="required">*</span><?php echo $entry_start_date_attribute; ?> </td>
                        <td>
                            <input type="text" name="rc_attribute_start_date" value="<?php echo $rc_attribute_start_date; ?>" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"/>
                            <input type="hidden" name="rc_attribute_id_start_date" value="<?php echo $rc_attribute_id_start_date; ?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td><span class="required">*</span><?php echo $entry_end_date_attribute; ?> </td>
                        <td>
                            <input type="text" name="rc_attribute_end_date" value="<?php echo $rc_attribute_end_date; ?>" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"/>
                            <input type="hidden" name="rc_attribute_id_end_date" value="<?php echo $rc_attribute_id_end_date; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span><?php echo $entry_week_day_attribute; ?> </td>
                        <td>
                            <input type="text" name="rc_attribute_week_day" value="<?php echo $rc_attribute_week_day; ?>" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"/>
                            <input type="hidden" name="rc_attribute_id_week_day" value="<?php echo $rc_attribute_id_week_day; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span><?php echo $entry_Monday; ?></td>
                        <td><?php foreach ($languages as $language) { ?>
                          <input type="text" name="rc_monday_description[<?php echo $language['language_id']; ?>][value]" value="<?php echo isset($rc_monday_description[$language['language_id']]) ? $rc_monday_description[$language['language_id']]['value'] : ''; ?>" />
                          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
                          <?php if (isset($error_name[$language['language_id']])) { ?>
                          <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
                          <?php } ?>
                          <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span><?php echo $entry_Tuesday; ?></td>
                        <td><?php foreach ($languages as $language) { ?>
                          <input type="text" name="rc_tuesday_description[<?php echo $language['language_id']; ?>][value]" value="<?php echo isset($rc_tuesday_description[$language['language_id']]) ? $rc_tuesday_description[$language['language_id']]['value'] : ''; ?>" />
                          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
                          <?php if (isset($error_name[$language['language_id']])) { ?>
                          <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
                          <?php } ?>
                          <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span><?php echo $entry_Wednesday; ?></td>
                        <td><?php foreach ($languages as $language) { ?>
                          <input type="text" name="rc_wednesday_description[<?php echo $language['language_id']; ?>][value]" value="<?php echo isset($rc_wednesday_description[$language['language_id']]) ? $rc_wednesday_description[$language['language_id']]['value'] : ''; ?>" />
                          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
                          <?php if (isset($error_name[$language['language_id']])) { ?>
                          <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
                          <?php } ?>
                          <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span><?php echo $entry_Thursday; ?></td>
                        <td><?php foreach ($languages as $language) { ?>
                          <input type="text" name="rc_thursday_description[<?php echo $language['language_id']; ?>][value]" value="<?php echo isset($rc_thursday_description[$language['language_id']]) ? $rc_thursday_description[$language['language_id']]['value'] : ''; ?>" />
                          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
                          <?php if (isset($error_name[$language['language_id']])) { ?>
                          <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
                          <?php } ?>
                          <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span><?php echo $entry_Friday; ?></td>
                        <td><?php foreach ($languages as $language) { ?>
                          <input type="text" name="rc_friday_description[<?php echo $language['language_id']; ?>][value]" value="<?php echo isset($rc_friday_description[$language['language_id']]) ? $rc_friday_description[$language['language_id']]['value'] : ''; ?>" />
                          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
                          <?php if (isset($error_name[$language['language_id']])) { ?>
                          <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
                          <?php } ?>
                          <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span><?php echo $entry_Saturday ?></td>
                        <td><?php foreach ($languages as $language) { ?>
                          <input type="text" name="rc_saturday_description[<?php echo $language['language_id']; ?>][value]" value="<?php echo isset($rc_saturday_description[$language['language_id']]) ? $rc_saturday_description[$language['language_id']]['value'] : ''; ?>" />
                          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
                          <?php if (isset($error_name[$language['language_id']])) { ?>
                          <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
                          <?php } ?>
                          <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span><?php echo $entry_Sunday; ?></td>
                        <td><?php foreach ($languages as $language) { ?>
                          <input type="text" name="rc_sunday_description[<?php echo $language['language_id']; ?>][value]" value="<?php echo isset($rc_sunday_description[$language['language_id']]) ? $rc_sunday_description[$language['language_id']]['value'] : ''; ?>" />
                          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
                          <?php if (isset($error_name[$language['language_id']])) { ?>
                          <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
                          <?php } ?>
                          <?php } ?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>      
    </div>
</div>
<script type="text/javascript"><!--
$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';
		
		$.each(items, function(index, item) {
			if (item.category != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
				
				currentCategory = item.category;
			}
			
			self._renderItem(ul, item);
		});
	}
        });
//--></script>
<script type="text/javascript"><!--
function attributeautocomplete(name,id) {    
    
$('input[name=\'' + name + '\']').catcomplete({
		delay: 500,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/attribute/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
				dataType: 'json',
				success: function(json) {	
					response($.map(json, function(item) {
						return {
							category: item.attribute_group,
							label: item.name,
							value: item.attribute_id
						}
					}));
				}
			});
		}, 
		select: function(event, ui) {
			$('input[name=\'' + name + '\']').attr('value', ui.item.label);
			$('input[name=\'' + id + '\']').attr('value', ui.item.value);
			
			return false;
		},
		focus: function(event, ui) {
      		return false;
   		}
	});
    }
   
attributeautocomplete('rc_attribute_start_date','rc_attribute_id_start_date');
attributeautocomplete('rc_attribute_end_date','rc_attribute_id_end_date');
attributeautocomplete('rc_attribute_week_day','rc_attribute_id_week_day');
        
//--></script> 
<?php echo $footer; ?> 