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
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
	 <div class="vtabs">
	             <a href="#tab-general" class="tab"><?php echo $tab_general; ?></a>	
				 <?php
				    foreach($xshippingpro['name'] as $no_of_tab=>$names){
					  if(!is_array($names))$names=array();
					  if(!isset($names[$language_id]) || !$names[$language_id])$names[$language_id]='Untitled Method '.$no_of_tab;
					  echo '<a class="tab tab'.$no_of_tab.'" href="#shipping-'.$no_of_tab.'"><span class="delete">x</span><strong>'.$names[$language_id].'</strong></a>';
					}
				 ?>	
				 <a href="#" class="add-new"><span>+</span>&nbsp;Add New Method</a>			
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
	  
	  <div id="tab-general" class="vtabs-content">
          <table class="form">
            <tr>
              <td><?php echo $tab_general; ?></td>
              <td><select name="xshippingpro_status">
                  <?php if ($xshippingpro_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
		   <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="xshippingpro_sort_order" value="<?php echo $xshippingpro_sort_order; ?>" size="1" /></td>
          </tr>
          </table>
        </div>
        <?php echo $form_data;?>
	   
      </form>
    </div>
  </div>
</div>
<style type="text/css">
  .add-new span{ border: medium none;
    color: #000000;
    display: inline;
    font-size: 24px;
    height: 6px;
    line-height: 5px;
    margin-right: 0;
    padding-bottom: 0;
    padding-right: 0;
    width: 25px;}

.tab span.delete {
    border: medium none;
    color: #000000;
    cursor: pointer;
    font-size: 17px;
    height: 6px;
    line-height: 5px;
    margin-right: 0;
    padding-bottom: 0;
    padding-left: 1px;
    padding-right: 0;
    width: 10px;
	display:none;
}
.tab strong{font-weight:bold;}
.tab:hover span{ display:inline;}
.tab span.delete:hover {
    color: #FF0000;
}
.vtabs{ min-height:530px;}	
tr.category{ display:none;}
.any-class {
    display: block;
    font-weight: bold;
    margin-bottom: 10px;
}
.scrollbox-wrapper{ display:none;}
</style>
<script type="text/javascript"><!--
var tmp='<div id="__ID__" class="vtabs-content shipping">'
          +'<div class="htabs">'
            <?php foreach ($languages as $language) { ?>
            +'<a href="#language<?php echo $language['language_id']; ?>___INDEX__"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>'
            <?php } ?>
          +'</div>'
		  <?php $inc=0;foreach ($languages as $language) { $lang_cls=($inc==0)?'':'-lang'; $inc++;  ?>
          +'<div id="language<?php echo $language['language_id']; ?>___INDEX__">'
          +'<table class="form">'
		  +'<tr>'
            +'<td><?php echo $entry_name; ?></td>'
            +'<td><input type="text" class="method-name<?php echo $lang_cls?>" size="45" name="xshippingpro[name][__INDEX__][<?php echo $language['language_id']; ?>]" value="" /></td>'
          +'</tr>'
		   +'<tr>'
            +'<td><?php echo $entry_desc; ?></td>'
            +'<td><input type="text" size="45" name="xshippingpro[desc][__INDEX__][<?php echo $language['language_id']; ?>]" value="" /></td>'
          +'</tr>'
		  +'</table>'
		  +'</div>'
		  <?php } ?>
		  +'<table class="form">'
		   +'<tr>'
            +'<td><?php echo $entry_weight_include; ?></td>'
            +'<td><input type="checkbox" name="xshippingpro[inc_weight][__INDEX__]" value="1" /></td>'
          +'</tr>'
          +'<tr>'
            +'<td><?php echo $entry_cost; ?></td>'
            +'<td><input type="text" name="xshippingpro[cost][__INDEX__]" value="" /></td>'
          +'</tr>'
          +'<tr>'
            +'<td><?php echo $entry_tax; ?></td>'
            +'<td><select name="xshippingpro[tax_class_id][__INDEX__]">'
                +'<option value="0"><?php echo $text_none; ?></option>'
                <?php foreach ($tax_classes as $tax_class) { ?>
                +'<option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>'
                <?php } ?>
              +'</select></td>'
          +'</tr>'
         +'<tr>'
            +'<td><?php echo $entry_geo_zone; ?></td>' 
            +'<td>'
			+'<label class="any-class"><input checked type="checkbox" name="xshippingpro[geo_zone_all][__INDEX__]" class="choose-any" value="1" />&nbsp;<?php echo $text_any; ?></label>'
			+'<div class="scrollbox-wrapper">'
			+'<div class="scrollbox">'
                <?php 
				$class = 'even';
				foreach ($geo_zones as $geo_zone) {
				    $class = ($class == 'even' ? 'odd' : 'even');
				 ?>
				+'<div class="<?php echo $class; ?>">'
                +'<input type="checkbox" name="xshippingpro[geo_zone_id][__INDEX__][]" value="<?php echo $geo_zone['geo_zone_id']; ?>" />&nbsp;<?php echo $geo_zone['name']; ?>'
				 +'</div>'
                <?php } ?>
              +'</div>'
			    +'<a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select_all; ?></a>'
			    +'/ <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect_all; ?></a>'
			  +'</div></td>'
          +'</tr>'
		  +'<tr>'
            +'<td><?php echo $entry_customer_group; ?></td>'
            +'<td>'
			+'<label class="any-class"><input checked type="checkbox" name="xshippingpro[customer_group_all][__INDEX__]" class="choose-any" value="1" />&nbsp;<?php echo $text_any; ?></label>'
			+'<div class="scrollbox-wrapper">'
			+'<div class="scrollbox">'
                <?php 
				 $class = 'even';
				 foreach ($customer_groups as $customer_group_id=>$name) {
				   $class = ($class == 'even' ? 'odd' : 'even');
				 ?>
				+'<div class="<?php echo $class; ?>">'
                +'<input type="checkbox" name="xshippingpro[customer_group][__INDEX__][]" value="<?php echo $customer_group_id?>" />&nbsp;<?php echo $name?>'        +'</div>'
                <?php } ?>
              +'</div>'
			    +'<a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select_all; ?></a>'
			    +'/ <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect_all; ?></a>'
			  +'</div></td>'
          +'</tr>'
		   +'<tr>'
              +'<td><?php echo $text_category; ?></td>'
              +'<td><select class="category-selection" name="xshippingpro[category][__INDEX__]">'
                  +'<option value="1"><?php echo $text_category_any; ?></option>'
                  +'<option value="2"><?php echo $text_category_all; ?></option>'
				  +'<option value="3"><?php echo $text_category_least; ?></option>'
                +'</select></td>'
            +'</tr>'
			+'<tr class="category">'
              +'<td><?php echo $entry_category; ?></td>'
              +'<td><input type="text" name="category" value="" /></td>'
            +'</tr>'
            +'<tr class="category">'
              +'<td>&nbsp;</td>'
              +'<td><div class="scrollbox product-category">'
                +'</div></td>'
            +'</tr>'
		   +'<tr>'
            +'<td><?php echo $entry_order_total; ?></td>'
            +'<td><input size="15" type="text" name="xshippingpro[order_total_start][__INDEX__]" value="" /> &nbsp;<?php echo $entry_to?>&nbsp; <input size="15" type="text" name="xshippingpro[order_total_end][__INDEX__]" value="" />&nbsp;&nbsp;[<?php echo $entry_order_hints?>]</td>'
          +'</tr>'
		  +'<tr>'
          +'<td><?php echo $entry_order_weight; ?></td>'
            +'<td><input size="15" type="text" name="xshippingpro[weight_start][__INDEX__]" value="" /> &nbsp;<?php echo $entry_to?>&nbsp; <input size="15" type="text" name="xshippingpro[weight_end][__INDEX__]" value="" />&nbsp;&nbsp;[<?php echo $entry_order_hints?>]</td>'
          +'</tr>'
          +'<tr>'
            +'<td><?php echo $entry_sort_order; ?></td>'
            +'<td><input type="text" name="xshippingpro[sort_order][__INDEX__]" value="" size="1" /></td>'
          +'</tr>'
		  +'<tr>'
              +'<td><?php echo $entry_status; ?></td>'
              +'<td><select name="xshippingpro[status][__INDEX__]">'
                  +'<option value="1" selected="selected"><?php echo $text_enabled; ?></option>'
                  +'<option value="0"><?php echo $text_disabled; ?></option>'
                +'</select></td>'
            +'</tr>'
        +'</table>'
        +'</div>';


$('.add-new').live('click',function(e) {

		  e.preventDefault();
		  $this=$(this);

		  var no_of_tab=$('#form').find('div.shipping').length;
		  no_of_tab=parseInt(no_of_tab)+1;
		
		  //finding qnique id
		  while($('#shipping-'+no_of_tab).length!=0)
		   {
		     no_of_tab++;
		   }

		  var tab_html=tmp;
		  tab_html=tab_html.replace('__ID__','shipping-'+no_of_tab);
		  tab_html=tab_html.replace(/__INDEX__/g, no_of_tab);
		  $('#form').append(tab_html);
		  
		  $('<a class="tab tab'+no_of_tab+'" href="#shipping-'+no_of_tab+'"><span class="delete">x</span><strong>Untitled Method '+no_of_tab+'</strong></a>').insertBefore($this);
		  
		  $('#form #shipping-'+no_of_tab+' input.method-name').keyup(function(){
		      var tabId=$(this).closest('div.shipping').attr('id');
			  tabId=tabId.replace('shipping-','');
			  tabId=parseInt(tabId);
			  var method_name=$(this).val();
			  if(method_name=='')method_name='Untitled Method '+tabId;
			  $('a.tab'+tabId+' strong').html(method_name);
		   });
		   
		    $('a.tab'+no_of_tab+' span.delete').click(function(){
			  if(confirm('Are you sure to delete this method?')){
				  var tabId=$(this).parent().attr('href');
				  tabId=tabId.replace('#shipping-','');
				  tabId=parseInt(tabId);
				  $('a.tab'+tabId).remove();
				  $('#shipping-'+tabId).remove();
				  $('.vtabs a.tab').first().click();
			  }
			  return false;
		   });
		   
		   $('#form #shipping-'+no_of_tab+' input[name=\'category\']').autocomplete({
			delay: 500,
			source: function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
					dataType: 'json',
					success: function(json) {		
						response($.map(json, function(item) {
							return {
								label: item.name,
								value: item.category_id
							}
						}));
					}
				});
			}, 
			select: function(event, ui) {
				$('#form #shipping-'+no_of_tab+' .product-category' + ui.item.value).remove();
				
				$('#form #shipping-'+no_of_tab+' .product-category').append('<div class="product-category' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="xshippingpro[product_category]['+no_of_tab+'][]" value="' + ui.item.value + '" /></div>');
						
				return false;
			},
			focus: function(event, ui) {
			  return false;
		   }
		  });
		  
		  
		  $('.vtabs a.tab').each(function(){
		     $(this).unbind('click');
		  });
		  
		  $('.vtabs a.tab').tabs();
		  $('#form #shipping-'+no_of_tab+' .htabs a').tabs();

    });

$(document).ready(function () {		
	 $('.vtabs a.tab').tabs(); 
	 $('div.shipping').each(function(){
	   $(this).find('.htabs a').tabs();
	 });
	 
	 $('a.tab span.delete').click(function(){
				  if(confirm('Are you sure to delete this method?')){
					  var tabId=$(this).parent().attr('href');
					  tabId=tabId.replace('#shipping-','');
					  tabId=parseInt(tabId);
					  $('a.tab'+tabId).remove();
					  $('#shipping-'+tabId).remove();
					  $('.vtabs a.tab').first().click();
				}
		   return false;			  
	   });
	   
     $('#form input.method-name').keyup(function(){
		  var tabId=$(this).closest('div.shipping').attr('id');
		  tabId=tabId.replace('shipping-','');
		  tabId=parseInt(tabId);
		  var method_name=$(this).val();
		  if(method_name=='')method_name='Untitled Method '+tabId;
		  $('a.tab'+tabId+' strong').html(method_name);
	   });
	   
	   
	   $('input[name=\'category\']').autocomplete({
			delay: 500,
			source: function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
					dataType: 'json',
					success: function(json) {		
						response($.map(json, function(item) {
							return {
								label: item.name,
								value: item.category_id
							}
						}));
					}
				});
			}, 
			select: function(event, ui) {
			    var no_of_tab=$(this).closest('div.shipping').attr('id');
				no_of_tab=no_of_tab.replace('shipping-','');
				no_of_tab=parseInt(no_of_tab);
				$('#form #shipping-'+no_of_tab+' .product-category' + ui.item.value).remove();
				
				$('#form #shipping-'+no_of_tab+' .product-category').append('<div class="product-category' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="xshippingpro[product_category]['+no_of_tab+'][]" value="' + ui.item.value + '" /></div>');		
				return false;
			},
			focus: function(event, ui) {
			  return false;
		   }
		});
		
		$('.product-category div img').live('click', function() {
			var no_of_tab=$(this).closest('div.shipping').attr('id');
				no_of_tab=no_of_tab.replace('shipping-','');
				no_of_tab=parseInt(no_of_tab);
			$(this).parent().remove();	
		});
		
		$('select.category-selection').live('change', function() {
		    var no_of_tab=$(this).closest('div.shipping').attr('id');
				no_of_tab=no_of_tab.replace('shipping-','');
				no_of_tab=parseInt(no_of_tab);
			 if($(this).val()=='1'){
			    $('#form #shipping-'+no_of_tab+' tr.category').css('display', 'none');
			 }else{
			   $('#form #shipping-'+no_of_tab+' tr.category').css('display', 'table-row');
			 }
		});
		
		$('.choose-any').live('click', function() {
		
		     if($(this).prop('checked')){
			     $(this).parent().parent().find('div.scrollbox-wrapper').slideUp();  
			 }else{
				$(this).parent().parent().find('div.scrollbox-wrapper').slideDown();
			}
		});
	    
 });
 
 
 	 
//--></script> 
<?php echo $footer; ?> 