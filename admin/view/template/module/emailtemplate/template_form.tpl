<?php echo $header; ?>

<div id="content">
	<div class="breadcrumb">
 	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
  		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  	<?php } ?>
	</div>

	<?php if ($error_warning) { ?><div class="warning"><?php echo $error_warning; ?></div><?php } ?>
	<?php if ($error_attention) { ?><div class="attention"><?php echo $error_attention; ?></div><?php } ?>
	<?php if ($success) { ?><div class="success"><?php echo $success; ?></div><?php } ?>

	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">	
		<div class="box" id="emailtemplate">		
			<div class="heading">
				<h1><img src="view/image/review.png" alt="<?php echo $heading_title; ?>" /><?php echo $heading_title; ?></h1>
	
				<div class="buttons">
					<?php if(isset($insertMode)){ ?>
						<a onclick="$('#form').attr('action', '<?php echo $action; ?>'); $('#form').submit();" class="button"><span><?php echo $button_create; ?></span></a>
						<a onclick="$('#form').attr('action', '<?php echo $action.'&amp;exit=true'; ?>'); $('#form').submit();" class="button"><span><?php echo $button_create_exit; ?></span></a>
					<?php } else { ?>
						<a onclick="$('#form').attr('action', '<?php echo $action; ?>'); $('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
						<a onclick="$('#form').attr('action', '<?php echo $action.'&amp;exit=true'; ?>'); $('#form').submit();" class="button"><span><?php echo $button_save_exit; ?></span></a>
						<button type="submit" name="delete_btn" class="button"><span><?php echo $button_delete; ?></span></button>
					<?php }?>
					<a href="<?php echo $cancel; ?>" class="button"><span><?php echo $button_back; ?></span></a>
				</div>
			</div>
	
			<div class="content">
				<table class="form">
					<tr>
						<td>
							<label for="field_name"><b><?php echo $entry_name; ?></b></label>
						</td>
						<td>
							<input class="large" type="text" name="name" value="<?php echo $dataset['name']; ?>" id="field_name" />
							<?php if (isset($error_name)) {?><span class="error"><?php echo $error_name; ?></span><?php } ?> 							
						</td>
					</tr>
					<tr>
						<td>
							<label for="field_type"><b><?php echo $entry_type; ?></b></label>
						</td>
						<td>
							<select name="type" id="field_type">
								<option value="order_status"<?php if($dataset['type'] == 'order_status'){ ?> selected="selected"<?php } ?>><?php echo $text_order_status; ?></option>
								<option value="newsletter"<?php if($dataset['type'] == 'newsletter'){ ?> selected="selected"<?php } ?>><?php echo $text_newsletter; ?></option>
							</select>
							<?php if (isset($error_type)) {?><span class="error"><?php echo $error_type; ?></span><?php } ?> 							
						</td>
					</tr>
				</table>
				
				<div id="language-body" class="htabs">
					<?php foreach ($languages as $language) { ?>
					<a href="#tab-language-<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
					<?php } ?>
				</div>
				
				<?php foreach ($languages as $language) { ?>
				<div id="tab-language-<?php echo $language['language_id']; ?>" class="tabHolder" style="display:none">
					<table class="form">
						<tr>			          
							<td>
								<label for="field_body_<?php echo $language['language_id']; ?>"><b><?php echo $entry_body; ?></b></label>
							</td>
							<td>
								<textarea name="body[<?php echo $language['language_id']; ?>]" id="field_body_<?php echo $language['language_id']; ?>"><?php echo $dataset['body'][$language['language_id']]; ?></textarea>							
								<?php if (isset($error_body[$language['language_id']])) {?><span class="error"><?php echo $error_body[$language['language_id']]; ?></span><?php } ?>	 							
							</td>
						</tr>
					</table>
				</div>
				<?php } ?>
			</div>	
						
			<?php if(!empty($tags)){ ?>
			<table cellspacing="0" cellpadding="5" border="0" class="list">
				<thead>
					<tr>
						<td colspan="5" style="padding: 8px 5px"><?php echo $heading_tags; ?></td>
					</tr>
				</thead>
				<tbody>
					<tr>
					<?php $i=0; foreach($tags as $tag){ ?>
						<?php if($i % 5 == 0 && $i != 0){ echo '</tr><tr>'; } ?>
						<td style="padding: 5px" class="insertHander" data-tag="{$<?php echo $tag; ?>}">{$<?php echo $tag; ?>}</td>						
					<?php $i++; } ?>
					</tr>  
				</tbody> 	
			</table>	
			<?php } ?>		
		</div>
	</form>
</div>

<link type="text/css" href="view/stylesheet/colorpicker.css" rel="stylesheet" media="screen" />
<link type="text/css" href="view/stylesheet/module/emailtemplate.css" rel="stylesheet" media="screen" />

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--

$('#language-body a').tabs();

<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('field_body_<?php echo $language['language_id']; ?>', {
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
(function($){				
	$(document).ready(function() {
		$(".insertHander").click(function(e){
    	    e.preventDefault();
    	    var editorId = $('.tabHolder:visible textarea[name^=body]').eq(0).attr('id');
	    	CKEDITOR.instances[editorId].insertText($(this).data("tag"));
	    });
	});	
})(jQuery);
//--></script>

<?php echo $footer; ?>