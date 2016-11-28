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

	<div class="box" id="emailtemplate">
		<div class="heading">
			<h1><img src="view/image/mail.png" alt="<?php echo $heading_title; ?>" /><?php echo $heading_title; ?></h1>

			<div class="buttons">
				<span style="float: left; width: 1px; height: 24px; background: #e2e2e2; border-right: 1px solid #fff; border-left: 1px solid #fff"></span>
				<a href="<?php echo $docs_url; ?>" class="button button-secondary"><span><?php echo $text_docs; ?></span></a>
				<a href="<?php echo $language_url; ?>" class="button button-secondary"><span><?php echo $button_language; ?></span></a>
				<a href="<?php echo $support_url; ?>" class="button button-secondary" target="_blank"><span><?php echo $text_support; ?></span></a>
			</div>
			
			<div class="buttons">
				<a onclick="$('#form').attr('action', '<?php echo $action; ?>'); $('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
				<a onclick="$('#form').attr('action', '<?php echo $action_exit; ?>'); $('#form').submit();" class="button"><span><?php echo $button_save_exit; ?></span></a>
				<a href="<?php echo $cancel; ?>" class="button"><span><?php echo $button_back; ?></span></a>
			</div>
		</div>

		<div class="content">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    			<div id="tab-store" class="htabs tab-nav-store">
    				<?php foreach($stores as $_store){ ?>
    					<a href="<?php echo $form_url; ?>&amp;store_id=<?php echo $_store['store_id']; ?>"<?php if($_store['store_id'] == $store_id){ ?> class="selected"<?php }?>><?php echo $_store['store_name']; ?></a>
    				<?php } ?>
    			</div>

    			<?php foreach($stores as $_store){
					if($_store['store_id'] != $store_id) continue; 
	    			$store_id = $_store['store_id'];
	    			$store_name = $_store['store_name'];
    			?>

    			<div id="tab-store-<?php echo $store_id; ?>" class="htabs-content tab-content-store">
    				<div id="tab-store-<?php echo $store_id; ?>-languages" class="htabs tab-nav-language">
					<?php foreach ($languages as $language) { ?>
						<a href="#tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
					<?php } ?>
				</div>

	          	<?php foreach($languages as $language){ ?>
		          	<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id']; ?>" class="tab-content-language">
						<table class="form">
							<?php if(count($themes) > 1) { ?><tr>
								<td>
									<label for="store[<?php echo $store_id; ?>][emailtemplate_theme][<?php echo $language['language_id']; ?>]"><b><?php echo $entry_theme; ?></b></label>
								</td>
								<td>
									<select class="large" name="store[<?php echo $store_id; ?>][emailtemplate_theme][<?php echo $language['language_id']; ?>]" id="store[<?php echo $store_id; ?>][emailtemplate_theme][<?php echo $language['language_id']; ?>]">
										<?php foreach($themes as $theme){ ?>
										<option value="<?php echo $theme; ?>"<?php if ($theme == $_store['emailtemplate_theme'][$language['language_id']]) { ?> selected="selected"<?php } ?>><?php echo $theme; ?></option>
										<?php } ?>
									</select>
									<?php if (isset($error_theme[$store_id][$language['language_id']])) {?>
						            	<span class="error"><?php echo $error_theme[$store_id][$language['language_id']]; ?></span>
						            <?php } ?>
								</td>
							</tr><?php } elseif(count($themes) == 1) { ?><tr style="display:none;"><td colspan='2'><input type="hidden" name="store[<?php echo $store_id; ?>][emailtemplate_theme][<?php echo $language['language_id']; ?>]" value="<?php echo current($themes); ?>" id="store[<?php echo $store_id; ?>][emailtemplate_theme][<?php echo $language['language_id']; ?>]" /></td></tr><?php } ?>
						</table>

						<h2 class="editor"><?php echo $heading_editor; ?> - <?php echo $store_name; ?></h2>
			    		<div class="tabsHolder">
			    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor" class="vtabs tab-nav-editor">
			    				<a href="#tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-head"><?php echo $heading_head; ?></a>
			    				<a href="#tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-header"><?php echo $heading_header; ?></a>
			    				<a href="#tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-logo"><?php echo $heading_logo; ?></a>
			    				<a href="#tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-body"><?php echo $heading_body; ?></a>
			    				<a href="#tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-footer"><?php echo $heading_footer; ?></a>
			    				<a href="#tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-shadow"><?php echo $heading_shadow; ?></a>
			    				<a href="#tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-showcase"><?php echo $heading_showcase; ?></a>
			    				<a href="#tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-settings"><?php echo $heading_settings; ?></a>
			    				<a href="#tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-templates"><?php echo $heading_templates; ?></a>
			    				<a href="#tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-invoice"><?php echo $heading_invoice; ?></a>
			    			</div>

			    			
			    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-head" class="vtabs-content tab-content-editor">
			    				<table class="form">
			    					<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_head_section_bg_color]"><?php echo $entry_section_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_head_section_bg_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_head_section_bg_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_head_section_bg_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_head_section_bg_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label><?php echo $entry_head_text; ?></label>
										</td>
										<td>
											<textarea name="store[<?php echo $store_id; ?>][emailtemplate_head_text][<?php echo $language['language_id']; ?>]" id="store<?php echo $store_id; ?>_head_text_<?php echo $language['language_id']; ?>"><?php echo $_store['emailtemplate_head_text'][$language['language_id']]; ?></textarea>
										</td>
									</tr>
								</table>
							</div>

			    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-header" class="vtabs-content tab-content-editor">
			    				<table class="form">
			    					<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_header_section_bg_color]"><?php echo $entry_section_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_header_section_bg_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_header_section_bg_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_header_section_bg_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_header_section_bg_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_header_height][<?php echo $language['language_id']; ?>]"><?php echo $entry_header_height; ?></label>
										</td>
										<td>
											<input type="text" name="store[<?php echo $store_id; ?>][emailtemplate_header_height][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_header_height'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_header_height][<?php echo $language['language_id']; ?>]" /> px
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_header_bg_color]"><?php echo $entry_header_bg_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_header_bg_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_header_bg_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_header_bg_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_header_bg_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_header_border_color]"><?php echo $entry_header_border_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_header_border_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_header_border_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_header_border_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_header_border_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_header_border_height]"><?php echo $entry_header_border_height; ?></label>
										</td>
										<td>
											<input type="text" name="store[<?php echo $store_id; ?>][emailtemplate_header_border_height][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_header_border_height'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_header_border_height][<?php echo $language['language_id']; ?>]" /> px
										</td>
									</tr>
									<tr>
										<td>
											<label><?php echo $entry_header_bg_image; ?></label>
										</td>
										<td>
											<div class="image">
												<img src="<?php echo $_store['emailtemplate_header_bg_image_thumb'][$language['language_id']]; ?>" alt="" id="thumb-header-bg-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>" />
												<input type="hidden" name="store[<?php echo $store_id; ?>][emailtemplate_header_bg_image][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_header_bg_image'][$language['language_id']]; ?>" id="image-header-bg-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>"  />
			                  					<br />
			                  					<a onclick="image_upload('image-header-bg-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>', 'thumb-header-bg-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;
			                  					<a onclick="$('#thumb-header-bg-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image-header-bg-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>').attr('value', '');"><?php echo $text_clear; ?></a>
			                  				</div>
										</td>
									</tr>
								</table>
			    			</div><!-- tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-header -->

			    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-logo" class="vtabs-content tab-content-editor">
			    				<table class="form">
									<tr>
										<td>
											<label><?php echo $entry_logo; ?></label>
										</td>
										<td>
											<div class="image">
												<img src="<?php echo $_store['emailtemplate_logo_thumb'][$language['language_id']]; ?>" alt="" id="thumb-logo-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>" />
												<input type="hidden" name="store[<?php echo $store_id; ?>][emailtemplate_logo][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_logo'][$language['language_id']]; ?>" id="image-logo-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>"  />
			                  					<br />
			                  					<a onclick="image_upload('image-logo-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>', 'thumb-logo-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;
			                  					<a onclick="$('#thumb-logo-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image-logo-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>').attr('value', '');"><?php echo $text_clear; ?></a>
			                  				</div>
			                  				<?php if (isset($error_logo[$store_id][$language['language_id']])) {?>
								            	<span class="error"><?php echo $error_logo[$store_id][$language['language_id']]; ?></span>
								            <?php } ?>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_logo_width][<?php echo $language['language_id']; ?>]"><span class="required">*</span> <?php echo $entry_logo_resize_options; ?></label>
										</td>
										<td>
											<b>w: </b><input class="small" title="<?php echo $text_width; ?>" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_logo_width][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_logo_width'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_logo_width][<?php echo $language['language_id']; ?>]" /> px &nbsp;&nbsp;
											<b>h: </b><input class="small" title="<?php echo $text_height; ?>" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_logo_height][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_logo_height'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_logo_height][<?php echo $language['language_id']; ?>]" /> px
											<?php if (isset($error_dimension[$store_id][$language['language_id']])) {?>
								            	<span class="error"><?php echo $error_dimension[$store_id][$language['language_id']]; ?></span>
								            <?php } ?>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_logo_resize][<?php echo $language['language_id']; ?>]"> <?php echo $text_resize; ?></label>
										</td>
										<td>
					                    	<label>
												<input type="radio" name="store[<?php echo $store_id; ?>][emailtemplate_logo_resize][<?php echo $language['language_id']; ?>]" value="1" <?php if ($_store['emailtemplate_logo_resize'][$language['language_id']] == 1) { ?>checked="checked" <?php } ?>/>
												<?php echo $text_yes; ?>
											</label>&nbsp;&nbsp;&nbsp;&nbsp;
											<label>
												<input type="radio" name="store[<?php echo $store_id; ?>][emailtemplate_logo_resize][<?php echo $language['language_id']; ?>]" value="0" <?php if ($_store['emailtemplate_logo_resize'][$language['language_id']] == 0) { ?>checked="checked" <?php } ?>/>
												<?php echo $text_no; ?>
											</label>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_logo_align][<?php echo $language['language_id']; ?>]"><?php echo $text_align; ?></label>
										</td>
										<td>
											<select name="store[<?php echo $store_id; ?>][emailtemplate_logo_align][<?php echo $language['language_id']; ?>]" id="store[<?php echo $store_id; ?>][emailtemplate_logo_align][<?php echo $language['language_id']; ?>]">
												<option value="left"<?php if($_store['emailtemplate_logo_align'][$language['language_id']] == 'left'){ ?> selected="selected"<?php } ?>><?php echo $text_left; ?></option>
												<option value="right"<?php if($_store['emailtemplate_logo_align'][$language['language_id']] == 'right'){ ?> selected="selected"<?php } ?>><?php echo $text_right; ?></option>
												<option value="center"<?php if($_store['emailtemplate_logo_align'][$language['language_id']] == 'center'){ ?> selected="selected"<?php } ?>><?php echo $text_center; ?></option>
											</select>
											
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_logo_valign][<?php echo $language['language_id']; ?>]"><?php echo $text_valign; ?></label>
										</td>
										<td>
											<select name="store[<?php echo $store_id; ?>][emailtemplate_logo_valign][<?php echo $language['language_id']; ?>]" id="store[<?php echo $store_id; ?>][emailtemplate_logo_valign][<?php echo $language['language_id']; ?>]">
												<option value="top"<?php if($_store['emailtemplate_logo_valign'][$language['language_id']] == 'top'){ ?> selected="selected"<?php } ?>><?php echo $text_top; ?></option>
												<option value="middle"<?php if($_store['emailtemplate_logo_valign'][$language['language_id']] == 'middle'){ ?> selected="selected"<?php } ?>><?php echo $text_middle; ?></option>
												<option value="bottom"<?php if($_store['emailtemplate_logo_valign'][$language['language_id']] == 'bottom'){ ?> selected="selected"<?php } ?>><?php echo $text_bottom; ?></option>
												<option value="baseline"<?php if($_store['emailtemplate_logo_valign'][$language['language_id']] == 'baseline'){ ?> selected="selected"<?php } ?>><?php echo $text_baseline; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_logo_font_size][<?php echo $language['language_id']; ?>]"><?php echo $text_font_size; ?></label>
										</td>
										<td>
											<input type="text" name="store[<?php echo $store_id; ?>][emailtemplate_logo_font_size][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_logo_font_size'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_logo_font_size][<?php echo $language['language_id']; ?>]" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_logo_font_color][<?php echo $language['language_id']; ?>]"><?php echo $text_font_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_logo_font_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_logo_font_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_logo_font_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_logo_font_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
								</table>
			    			</div><!-- tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-logo -->

			    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-body" class="vtabs-content tab-content-editor">
			    				<table class="form">
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_email_width][<?php echo $language['language_id']; ?>]"><?php echo $entry_email_width; ?></label>
										</td>
										<td>
											<input type="text" name="store[<?php echo $store_id; ?>][emailtemplate_email_width][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_email_width'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_email_width][<?php echo $language['language_id']; ?>]" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_page_padding][<?php echo $language['language_id']; ?>]"><?php echo $entry_page_padding; ?></label>
										</td>
										<td>
											<input type="text" name="store[<?php echo $store_id; ?>][emailtemplate_page_padding][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_page_padding'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_page_padding][<?php echo $language['language_id']; ?>]" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_body_bg_color][<?php echo $language['language_id']; ?>]"><?php echo $entry_body_bg_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_body_bg_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_body_bg_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_body_bg_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_body_bg_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_page_bg_color][<?php echo $language['language_id']; ?>]"><?php echo $entry_page_bg_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_page_bg_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_page_bg_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_page_bg_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_page_bg_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_body_font_color][<?php echo $language['language_id']; ?>]"><?php echo $entry_body_font_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_body_font_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_body_font_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_body_font_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_body_font_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_body_link_color][<?php echo $language['language_id']; ?>]"><?php echo $entry_body_link_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_body_link_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_body_link_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_body_link_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_body_link_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_body_heading_color][<?php echo $language['language_id']; ?>]"><?php echo $entry_body_heading_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_body_heading_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_body_heading_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_body_heading_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_body_heading_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_text_align][<?php echo $language['language_id']; ?>]"><?php echo $text_align; ?></label>
										</td>
										<td>
											<select name="store[<?php echo $store_id; ?>][emailtemplate_text_align][<?php echo $language['language_id']; ?>]" id="store[<?php echo $store_id; ?>][emailtemplate_text_align][<?php echo $language['language_id']; ?>]">
												<option value="left"<?php if($_store['emailtemplate_text_align'][$language['language_id']] == 'left'){ ?> selected="selected"<?php } ?>><?php echo $text_left; ?></option>
												<option value="right"<?php if($_store['emailtemplate_text_align'][$language['language_id']] == 'right'){ ?> selected="selected"<?php } ?>><?php echo $text_right; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_body_section_bg_color]"><?php echo $entry_section_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_body_section_bg_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_body_section_bg_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_body_section_bg_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_body_section_bg_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label><?php echo $entry_page_footer_text; ?></label>
										</td>
										<td>
											<textarea name="store[<?php echo $store_id; ?>][emailtemplate_page_footer_text][<?php echo $language['language_id']; ?>]" id="store<?php echo $store_id; ?>_page_footer_text_<?php echo $language['language_id']; ?>"><?php echo $_store['emailtemplate_page_footer_text'][$language['language_id']]; ?></textarea>
										</td>
									</tr>
								</table>
			    			</div><!-- tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-body -->

			    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-footer" class="vtabs-content tab-content-editor">
			    				<table class="form">
			    					<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_footer_section_bg_color]"><?php echo $entry_section_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_footer_section_bg_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_footer_section_bg_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_footer_section_bg_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_footer_section_bg_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_footer_height][<?php echo $language['language_id']; ?>]"><?php echo $text_height; ?></label>
										</td>
										<td>
											<input type="text" name="store[<?php echo $store_id; ?>][emailtemplate_footer_height][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_footer_height'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_footer_height][<?php echo $language['language_id']; ?>]" />
										</td>
									</tr>
									<tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_footer_font_color][<?php echo $language['language_id']; ?>]"><?php echo $text_font_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_footer_font_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_footer_font_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_footer_font_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_footer_font_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_footer_align][<?php echo $language['language_id']; ?>]"><?php echo $text_align; ?></label>
										</td>
										<td>
											<select name="store[<?php echo $store_id; ?>][emailtemplate_footer_align][<?php echo $language['language_id']; ?>]" id="store[<?php echo $store_id; ?>][emailtemplate_footer_align][<?php echo $language['language_id']; ?>]">
												<option value="center"<?php if($_store['emailtemplate_footer_align'][$language['language_id']] == 'center'){ ?> selected="selected"<?php } ?>><?php echo $text_center; ?></option>
												<option value="left"<?php if($_store['emailtemplate_footer_align'][$language['language_id']] == 'left'){ ?> selected="selected"<?php } ?>><?php echo $text_left; ?></option>
												<option value="right"<?php if($_store['emailtemplate_footer_align'][$language['language_id']] == 'right'){ ?> selected="selected"<?php } ?>><?php echo $text_right; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_footer_valign][<?php echo $language['language_id']; ?>]"><?php echo $text_valign; ?></label>
										</td>
										<td>
											<select name="store[<?php echo $store_id; ?>][emailtemplate_footer_valign][<?php echo $language['language_id']; ?>]" id="store[<?php echo $store_id; ?>][emailtemplate_footer_valign][<?php echo $language['language_id']; ?>]">
												<option value="top"<?php if($_store['emailtemplate_footer_valign'][$language['language_id']] == 'top'){ ?> selected="selected"<?php } ?>><?php echo $text_top; ?></option>
												<option value="middle"<?php if($_store['emailtemplate_footer_valign'][$language['language_id']] == 'middle'){ ?> selected="selected"<?php } ?>><?php echo $text_middle; ?></option>
												<option value="bottom"<?php if($_store['emailtemplate_footer_valign'][$language['language_id']] == 'bottom'){ ?> selected="selected"<?php } ?>><?php echo $text_bottom; ?></option>
												<option value="baseline"<?php if($_store['emailtemplate_footer_valign'][$language['language_id']] == 'baseline'){ ?> selected="selected"<?php } ?>><?php echo $text_baseline; ?></option>
											</select>
										</td>
									</tr>
									<tr>
			    						<td>
											<label><?php echo $entry_footer_text; ?></label>
										</td>
										<td>
											<textarea name="store[<?php echo $store_id; ?>][emailtemplate_footer_text][<?php echo $language['language_id']; ?>]" id="store<?php echo $store_id; ?>_footer_text_<?php echo $language['language_id']; ?>"><?php echo $_store['emailtemplate_footer_text'][$language['language_id']]; ?></textarea>
										</td>
									</tr>
								</table>
							</div>

			    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-shadow" class="vtabs-content tab-content-editor">
			    				<?php echo $text_shadow_info; ?>
			    				
			    				<table class="form">
			    					<tr>
										<td>
											<b><?php echo $text_top; ?></b> 
										</td>
										<td>												
											<table class="form-vertical" cellpadding="5">
						    					<tr>
						    						<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_top_length][<?php echo $language['language_id']; ?>]">
															<?php echo $text_height; ?>
														</label>
													</td>
													<td>
						    							<input class="small" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_top_length][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_top_length'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_top_length][<?php echo $language['language_id']; ?>]" />		
						    						</td>
													<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_top_overlap][<?php echo $language['language_id']; ?>]">
															<?php echo $entry_overlap; ?>
														</label>
													</td>
						    						<td>
						    							<input class="small" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_top_overlap][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_top_overlap'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_top_overlap][<?php echo $language['language_id']; ?>]" />		
						    						</td>
													<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_top_start][<?php echo $language['language_id']; ?>]">
															<?php echo $text_start; ?>
														</label>
													</td>
													<td>
														<input class="small fieldColorPicker" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_top_start][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_top_start'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_top_start][<?php echo $language['language_id']; ?>]" />
														<span style="background-color:<?php echo $_store['emailtemplate_shadow_top_start'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
													</td>
													<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_top_end][<?php echo $language['language_id']; ?>]">
															<?php echo $text_end; ?>
														</label>
													</td>
													<td>
														<input class="small fieldColorPicker" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_top_end][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_top_end'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_top_end][<?php echo $language['language_id']; ?>]" />
														<span style="background-color:<?php echo $_store['emailtemplate_shadow_top_end'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
													</td>
												</tr>
											</table>												
										</td>
									</tr>
			    					<tr>
										<td>
											<b><?php echo $text_bottom; ?></b>
										</td>
										<td>												
											<table class="form-vertical" cellpadding="5">
						    					<tr>
						    						<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_bottom_length][<?php echo $language['language_id']; ?>]">
															<?php echo $text_height; ?>
														</label>
													</td>
													<td>
						    							<input class="small" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_bottom_length][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_bottom_length'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_bottom_length][<?php echo $language['language_id']; ?>]" />		
						    						</td>
						    						<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_bottom_overlap][<?php echo $language['language_id']; ?>]">
															<?php echo $entry_overlap; ?>
														</label>
													</td>
						    						<td>
						    							<input class="small" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_bottom_overlap][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_bottom_overlap'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_bottom_overlap][<?php echo $language['language_id']; ?>]" />		
						    						</td>
													<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_bottom_start][<?php echo $language['language_id']; ?>]">
															<?php echo $text_start; ?>
														</label>
													</td>
													<td>
														<input class="small fieldColorPicker" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_bottom_start][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_bottom_start'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_bottom_start][<?php echo $language['language_id']; ?>]" />
														<span style="background-color:<?php echo $_store['emailtemplate_shadow_bottom_start'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
													</td>
													<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_bottom_end][<?php echo $language['language_id']; ?>]">
															<?php echo $text_end; ?>
														</label>
													</td>
													<td>
														<input class="small fieldColorPicker" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_bottom_end][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_bottom_end'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_bottom_end][<?php echo $language['language_id']; ?>]" />
														<span style="background-color:<?php echo $_store['emailtemplate_shadow_bottom_end'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
													</td>
												</tr>
											</table>												
										</td>
									</tr>
			    					<tr>
										<td>
											<b><?php echo $text_left; ?></b>
										</td>
										<td>												
											<table class="form-vertical" cellpadding="5">
						    					<tr>
						    						<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_left_length][<?php echo $language['language_id']; ?>]">
															<?php echo $text_width; ?>&nbsp;&nbsp;
														</label>
													</td>
													<td>
						    							<input class="small" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_left_length][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_left_length'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_left_length][<?php echo $language['language_id']; ?>]" />		
						    						</td>
						    						<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_left_overlap][<?php echo $language['language_id']; ?>]">
															<?php echo $entry_overlap; ?>
														</label>
													</td>
						    						<td>
						    							<input class="small" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_left_overlap][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_left_overlap'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_left_overlap][<?php echo $language['language_id']; ?>]" />		
						    						</td>
													<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_left_start][<?php echo $language['language_id']; ?>]">
															<?php echo $text_start; ?>
														</label>
													</td>
													<td>
														<input class="small fieldColorPicker" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_left_start][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_left_start'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_left_start][<?php echo $language['language_id']; ?>]" />
														<span style="background-color:<?php echo $_store['emailtemplate_shadow_left_start'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
													</td>
													<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_left_end][<?php echo $language['language_id']; ?>]">
															<?php echo $text_end; ?>
														</label>
													</td>
													<td>
														<input class="small fieldColorPicker" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_left_end][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_left_end'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_left_end][<?php echo $language['language_id']; ?>]" />
														<span style="background-color:<?php echo $_store['emailtemplate_shadow_left_end'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
													</td>
												</tr>
											</table>												
										</td>
									</tr>
			    					<tr>
										<td>
											<b><?php echo $text_right; ?></b>
										</td>
										<td>												
											<table class="form-vertical" cellpadding="5">
						    					<tr>
						    						<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_right_start][<?php echo $language['language_id']; ?>]">
															<?php echo $text_width; ?>&nbsp;&nbsp;
														</label>
													</td>
													<td>
						    							<input class="small" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_right_length][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_right_length'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_right_length][<?php echo $language['language_id']; ?>]" />		
						    						</td>
						    						<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_right_overlap][<?php echo $language['language_id']; ?>]">
															<?php echo $entry_overlap; ?>
														</label>
													</td>
						    						<td>
						    							<input class="small" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_right_overlap][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_right_overlap'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_right_overlap][<?php echo $language['language_id']; ?>]" />		
						    						</td>
													<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_right_start][<?php echo $language['language_id']; ?>]">
															<?php echo $text_start; ?>
														</label>
													</td>
													<td>
														<input class="small fieldColorPicker" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_right_start][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_right_start'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_right_start][<?php echo $language['language_id']; ?>]" />
														<span style="background-color:<?php echo $_store['emailtemplate_shadow_right_start'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
													</td>
													<td>
														<label for="store[<?php echo $store_id; ?>][emailtemplate_shadow_right_end][<?php echo $language['language_id']; ?>]">
															<?php echo $text_end; ?>
														</label>
													</td>
													<td>
														<input class="small fieldColorPicker" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_right_end][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_right_end'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_shadow_right_end][<?php echo $language['language_id']; ?>]" />
														<span style="background-color:<?php echo $_store['emailtemplate_shadow_right_end'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
													</td>
												</tr>
											</table>												
										</td>
									</tr>
									<tr>
										<td><b><?php echo $entry_corner_image; ?></b></td>
										<td>
											<table class="form-vertical">
						    					<tr>
													<td>															
														<div class="image">
															<label for="image-shadow-top-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>">
																<?php echo $text_top_left; ?>
															</label> <br /><br />
														
															<?php if($_store['emailtemplate_shadow_top_left_img_thumb'][$language['language_id']]): ?><img src="<?php echo $_store['emailtemplate_shadow_top_left_img_thumb'][$language['language_id']]; ?>" alt="" id="thumb-shadow-top-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>" onclick="image_upload('image-shadow-top-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>', 'thumb-shadow-top-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>');" /><?php endif; ?>
															<input type="hidden" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_top_left_img][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_top_left_img'][$language['language_id']]; ?>" id="image-shadow-top-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>"  />
															<br />
						                  					<a onclick="image_upload('image-shadow-top-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>', 'thumb-shadow-top-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;
						                  					<a onclick="$('#thumb-shadow-top-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image-shadow-top-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>').attr('value', '');"><?php echo $text_clear; ?></a>
						                  				</div>
													</td>
													<td>
														<div class="image">
															<label for="image-shadow-top-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>">
																<?php echo $text_top_right; ?>
															</label> <br /><br />
															<?php if($_store['emailtemplate_shadow_top_right_img_thumb'][$language['language_id']]): ?><img src="<?php echo $_store['emailtemplate_shadow_top_right_img_thumb'][$language['language_id']]; ?>" alt="" id="thumb-shadow-top-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>" onclick="image_upload('image-shadow-top-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>', 'thumb-shadow-top-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>');" /><?php endif; ?>
															<input type="hidden" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_top_right_img][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_top_right_img'][$language['language_id']]; ?>" id="image-shadow-top-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>"  />
															<br />
						                  					<a onclick="image_upload('image-shadow-top-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>', 'thumb-shadow-top-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;
						                  					<a onclick="$('#thumb-shadow-top-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image-shadow-top-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>').attr('value', '');"><?php echo $text_clear; ?></a>
						                  				</div>
													</td>
												</tr>
						    					<tr>
													<td>
														<div class="image">
															<label for="image-shadow-bottom-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>">
																<?php echo $text_bottom_left; ?>
															</label> <br /><br />
															<?php if($_store['emailtemplate_shadow_bottom_left_img_thumb'][$language['language_id']]): ?><img src="<?php echo $_store['emailtemplate_shadow_bottom_left_img_thumb'][$language['language_id']]; ?>" alt="" id="thumb-shadow-bottom-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>" onclick="image_upload('image-shadow-bottom-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>', 'thumb-shadow-bottom-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>');" /><?php endif; ?>
															<input type="hidden" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_bottom_left_img][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_bottom_left_img'][$language['language_id']]; ?>" id="image-shadow-bottom-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>"  />
															<br />
						                  					<a onclick="image_upload('image-shadow-bottom-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>', 'thumb-shadow-bottom-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;
						                  					<a onclick="$('#thumb-shadow-bottom-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image-shadow-bottom-left-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>').attr('value', '');"><?php echo $text_clear; ?></a>
						                  				</div>
													</td>
													<td>
														<div class="image">
															<label for="image-shadow-bottom-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>">
																<?php echo $text_bottom_right; ?>
															</label> <br /><br />
															<?php if($_store['emailtemplate_shadow_bottom_right_img_thumb'][$language['language_id']]): ?><img src="<?php echo $_store['emailtemplate_shadow_bottom_right_img_thumb'][$language['language_id']]; ?>" alt="" id="thumb-shadow-bottom-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>" onclick="image_upload('image-shadow-bottom-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>', 'thumb-shadow-bottom-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>');" /><?php endif; ?>
															<input type="hidden" name="store[<?php echo $store_id; ?>][emailtemplate_shadow_bottom_right_img][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_shadow_bottom_right_img'][$language['language_id']]; ?>" id="image-shadow-bottom-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>"  />
															<br />
						                  					<a onclick="image_upload('image-shadow-bottom-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>', 'thumb-shadow-bottom-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;
						                  					<a onclick="$('#thumb-shadow-bottom-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image-shadow-bottom-right-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>').attr('value', '');"><?php echo $text_clear; ?></a>
						                  				</div>
													</td>
												</tr>
											</table>	
										</td>
									</tr>
								</table>
							</div><!-- tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-shadow -->
							
			    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-showcase" class="vtabs-content tab-content-editor">
			    				<table class="form">
			    					<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_showcase][<?php echo $language['language_id']; ?>]"><?php echo $entry_showcase; ?></label>
										</td>
										<td>
											<label>
												<input class="showcase-options" type="radio"name="store[<?php echo $store_id; ?>][emailtemplate_showcase][<?php echo $language['language_id']; ?>]" value="" <?php if($_store['emailtemplate_showcase'][$language['language_id']] == '') echo ' checked="checked"'; ?>/>
												<b><?php echo $text_none; ?></b>
											</label><br />
											<label>
												<input class="showcase-options" type="radio" name="store[<?php echo $store_id; ?>][emailtemplate_showcase][<?php echo $language['language_id']; ?>]" value="products" <?php if($_store['emailtemplate_showcase'][$language['language_id']] == 'products') echo ' checked="checked"'; ?>/>
												<b><?php echo $text_products; ?></b>
											</label>
										</td>
									</tr>
									<tr<?php if($_store['emailtemplate_showcase'][$language['language_id']] != 'products'){ ?> style="display:none;"<?php } ?> class="showcase_products">
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_showcase_selection][<?php echo $language['language_id']; ?>]"><?php echo $entry_selection; ?></label>
										</td>
										<td>
											<input class="large" type="text" name="" value="" id="selection_<?php echo $_store['store_id']; ?>_<?php echo $language['language_id']; ?>" />
											<input type="hidden" name="store[<?php echo $store_id; ?>][emailtemplate_showcase_selection][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_showcase_selection'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_showcase_selection][<?php echo $language['language_id']; ?>]" />
										</td>
									</tr>
									<tr<?php if($_store['emailtemplate_showcase'][$language['language_id']] != 'products'){ ?> style="display:none;"<?php } ?> class="showcase_selection">
										<td>&nbsp;</td>
										<td>
											<ol style="padding-left:20px">
											<?php if(!empty($showcase_selection[$language['language_id']])): ?>
											<?php foreach($showcase_selection[$language['language_id']] as $row){ ?>
												<li data-id="<?php echo $row['product_id']; ?>"><?php echo $row['name']; ?> <span class="remove"></span></li>
											<?php } ?>
											<?php endif; ?>
											</ol>
										</td>
									</tr>
									<tr class="showcase_limit">
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_showcase_limit][<?php echo $language['language_id']; ?>]"><?php echo $entry_limit; ?></label>
										</td>
										<td>
											<input class="small" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_showcase_limit][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_showcase_limit'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_showcase_limit][<?php echo $language['language_id']; ?>]" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_showcase_section_bg_color][<?php echo $language['language_id']; ?>]"><?php echo $entry_section_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_showcase_section_bg_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_showcase_section_bg_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_showcase_section_bg_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_showcase_section_bg_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_showcase_page_bg_color][<?php echo $language['language_id']; ?>]"><?php echo $entry_page_bg_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_showcase_page_bg_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_showcase_page_bg_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_showcase_page_bg_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_showcase_page_bg_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_showcase_title][<?php echo $language['language_id']; ?>]"><?php echo $entry_title; ?></label>
										</td>
										<td>
											<input class="large" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_showcase_title][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_showcase_title'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_showcase_title][<?php echo $language['language_id']; ?>]" />
										</td>
									</tr>
								</table>
							</div>
							
			    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-settings" class="vtabs-content tab-content-editor">
			    				<table class="form">
			    					<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_body_comment_length][<?php echo $language['language_id']; ?>]"><?php echo $entry_body_comment_length; ?></label>
										</td>
										<td>
											<input class="small" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_body_comment_length][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_body_comment_length'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_body_comment_length][<?php echo $language['language_id']; ?>]" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_body_product_option_length][<?php echo $language['language_id']; ?>]"><?php echo $entry_body_product_option_length; ?></label>
										</td>
										<td>
											<input class="small" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_body_product_option_length][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_body_product_option_length'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_body_product_option_length][<?php echo $language['language_id']; ?>]" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_body_product_option_size][<?php echo $language['language_id']; ?>]"><?php echo $entry_body_product_option_size; ?></label>
										</td>
										<td>
											<input class="small" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_body_product_option_size][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_body_product_option_size'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_body_product_option_size][<?php echo $language['language_id']; ?>]" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_customer_password][<?php echo $language['language_id']; ?>]"><?php echo $entry_customer_password; ?></label>
										</td>
										<td>
					                    	<label>
												<input type="radio" name="store[<?php echo $store_id; ?>][emailtemplate_customer_password][<?php echo $language['language_id']; ?>]" value="1" <?php if ($_store['emailtemplate_customer_password'][$language['language_id']] == 1) { ?>checked="checked" <?php } ?>/>
												<?php echo $text_yes; ?>
											</label>&nbsp;&nbsp;&nbsp;&nbsp;
											<label>
												<input type="radio" name="store[<?php echo $store_id; ?>][emailtemplate_customer_password][<?php echo $language['language_id']; ?>]" value="0" <?php if ($_store['emailtemplate_customer_password'][$language['language_id']] == 0) { ?>checked="checked" <?php } ?>/>
												<?php echo $text_no; ?>
											</label>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_unsubscribe][<?php echo $language['language_id']; ?>]"><?php echo $entry_unsubscribe; ?></label>
										</td>
										<td>
											<input class="large" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_unsubscribe][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_unsubscribe'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_unsubscribe][<?php echo $language['language_id']; ?>]" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_tracking_campaign_name][<?php echo $language['language_id']; ?>]"><?php echo $entry_tracking_campaign_name; ?></label>
										</td>
										<td>
											<input class="large" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_tracking_campaign_name][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_tracking_campaign_name'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_tracking_campaign_name][<?php echo $language['language_id']; ?>]" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_contactus_customer][<?php echo $language['language_id']; ?>]"><?php echo $entry_contactus_customer; ?></label>
										</td>
										<td>
					                    	<label>
												<input type="radio" name="store[<?php echo $store_id; ?>][emailtemplate_contactus_customer][<?php echo $language['language_id']; ?>]" value="1" <?php if ($_store['emailtemplate_contactus_customer'][$language['language_id']] == 1) { ?>checked="checked" <?php } ?>/>
												<?php echo $text_yes; ?>
											</label>&nbsp;&nbsp;&nbsp;&nbsp;
											<label>
												<input type="radio" name="store[<?php echo $store_id; ?>][emailtemplate_contactus_customer][<?php echo $language['language_id']; ?>]" value="0" <?php if ($_store['emailtemplate_contactus_customer'][$language['language_id']] == 0) { ?>checked="checked" <?php } ?>/>
												<?php echo $text_no; ?>
											</label>
										</td>
									</tr>
									<tr>
										<td>
											<label for="store[<?php echo $store_id; ?>][emailtemplate_order_picture][<?php echo $language['language_id']; ?>]"><?php echo $entry_order_picture; ?></label>
										</td>
										<td>
					                    	<label>
												<input type="radio" name="store[<?php echo $store_id; ?>][emailtemplate_order_picture][<?php echo $language['language_id']; ?>]" value="1" <?php if ($_store['emailtemplate_order_picture'][$language['language_id']] == 1) { ?>checked="checked" <?php } ?>/>
												<?php echo $text_yes; ?>
											</label>&nbsp;&nbsp;&nbsp;&nbsp;
											<label>
												<input type="radio" name="store[<?php echo $store_id; ?>][emailtemplate_order_picture][<?php echo $language['language_id']; ?>]" value="0" <?php if ($_store['emailtemplate_order_picture'][$language['language_id']] == 0) { ?>checked="checked" <?php } ?>/>
												<?php echo $text_no; ?>
											</label>
										</td>
									</tr>
			    				</table>
			    			</div><!-- tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-settings -->
			    						    						    			
			    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-templates" class="vtabs-content tab-content-editor">
			    				<div class="buttons" style="text-align:right">
									<a href="<?php echo $insert_template; ?>" class="button"><span><?php echo $button_insert; ?></span></a>
								</div>
								<br />
								
						        <table class="list">
						          <thead>
						            <tr>
						              <td class="left"><?php if ($sort == 'name') { ?>
						                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
						                <?php } else { ?>
						                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
						                <?php } ?></td>
						              <td class="left"><?php if ($sort == 'body') { ?>
						                <a href="<?php echo $sort_body; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_body; ?></a>
						                <?php } else { ?>
						                <a href="<?php echo $sort_body; ?>"><?php echo $column_body; ?></a>
						                <?php } ?></td>
						              <td class="center"><?php echo $column_type; ?></td>
						              <td class="right"><?php echo $column_action; ?></td>
						            </tr>
						          </thead>
						          <tbody>
						            <?php if ($templates) { ?>
						            <?php foreach ($templates as $template) { ?>
						            <?php if($template['language_id'] != $language['language_id']) continue; ?>
						            <tr>
						              <td class="left"><?php echo $template['name']; ?></td>
						              <td class="left"><?php echo $template['desc']; ?></td>
						              <td class="center"><?php echo $template['type']; ?></td>
						              <td class="right">[ <a href="<?php echo $template['url']; ?>"><?php echo $text_edit; ?></a> ]</td>
						            </tr>
						            <?php } ?>
						            <?php } else { ?>
						            <tr>
						              <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
						            </tr>
						            <?php } ?>
						          </tbody>
						        </table>
							      
							    <?php if ($templates) { ?>
							    	<div class="pagination"><?php echo $pagination; ?></div>
						    	<?php } ?>
			    			</div><!-- tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-templates -->
			    			
			    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-editor-invoice" class="vtabs-content tab-content-editor">
			    				<p>To generate the PDF we used TCPDF library by Nicola Asuni - Tecnick.com <a href="http://www.tcpdf.org" target="_blank">www.tcpdf.org</a></p>
			    				<p>If you like it please feel free to <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=paypal%40tecnick%2ecom&lc=US&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest" target="_blank"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" alt="PayPal - The safer, easier way to pay online!" style="vertical-align: middle;" /></a> a small amount of money to secure the future of this free library.</p> 
			    				<table class="form">
			    					<tr>
										<td>
											<label><?php echo $entry_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_invoice_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_invoice_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_invoice_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_invoice_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
			    					<tr>
										<td>
											<label><?php echo $entry_invoice_heading_color; ?></label>
										</td>
										<td>
											<input type="text" class="fieldColorPicker" name="store[<?php echo $store_id; ?>][emailtemplate_invoice_heading_color][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_invoice_heading_color'][$language['language_id']]; ?>" id="store[<?php echo $store_id; ?>][emailtemplate_invoice_heading_color][<?php echo $language['language_id']; ?>]" />
											<span style="background-color:<?php echo $_store['emailtemplate_invoice_heading_color'][$language['language_id']]; ?>; width:20px; height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>
											<label><?php echo $entry_invoice_title; ?></label>
										</td>
										<td>
											<input class="large" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_invoice_title][<?php echo $language['language_id']; ?>]" id="store<?php echo $store_id; ?>_invoice_title_<?php echo $language['language_id']; ?>" value="<?php echo $_store['emailtemplate_invoice_title'][$language['language_id']]; ?>" />
										</td>
									</tr>
									<tr>
										<td>
											<label><?php echo $entry_invoice_text; ?></label>
										</td>
										<td>
											<textarea class="large" name="store[<?php echo $store_id; ?>][emailtemplate_invoice_text][<?php echo $language['language_id']; ?>]" id="store<?php echo $store_id; ?>_invoice_text_<?php echo $language['language_id']; ?>"><?php echo $_store['emailtemplate_invoice_text'][$language['language_id']]; ?></textarea>
										</td>
									</tr>
									<tr>
										<td>
											<label><?php echo $entry_invoice_logo; ?></label>
										</td>
										<td>
											<div class="image">
												<img src="<?php echo $_store['emailtemplate_invoice_logo_thumb'][$language['language_id']]; ?>" alt="" id="thumb-invoice-logo-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>" />
												<input type="hidden" name="store[<?php echo $store_id; ?>][emailtemplate_invoice_logo][<?php echo $language['language_id']; ?>]" value="<?php echo $_store['emailtemplate_invoice_logo'][$language['language_id']]; ?>" id="image-invoice-logo-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>"  />
			                  					<br />
			                  					<a onclick="image_upload('image-invoice-logo-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>', 'thumb-invoice-logo-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;
			                  					<a onclick="$('#thumb-invoice-logo-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image-invoice-logo-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>').attr('value', '');"><?php echo $text_clear; ?></a>
			                  				</div>
										</td>
									</tr>
									<tr>
										<td>
											<label><?php echo $entry_invoice_logo_width; ?></label>
										</td>
										<td>
											<input class="small" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_invoice_logo_width][<?php echo $language['language_id']; ?>]" id="store<?php echo $store_id; ?>_invoice_logo_width_<?php echo $language['language_id']; ?>" value="<?php echo $_store['emailtemplate_invoice_logo_width'][$language['language_id']]; ?>" />
										</td>
									</tr>
									<tr>
										<td>
											<label><?php echo $entry_invoice_products_limit; ?></label>
										</td>
										<td>
											<input class="small" type="text" name="store[<?php echo $store_id; ?>][emailtemplate_invoice_products_limit][<?php echo $language['language_id']; ?>]" id="store<?php echo $store_id; ?>_invoice_products_limit_<?php echo $language['language_id']; ?>" value="<?php echo $_store['emailtemplate_invoice_products_limit'][$language['language_id']]; ?>" />
										</td>
									</tr>
								</table>
							</div>			    			
		    			</div><!-- .tabsHolder -->

		    			<h2 class="preview"><?php echo $heading_preview; ?> - <?php echo $store_name; ?></h2>
		    			<div class="tabsHolder tabsHolder-preview">
			    			<?php if(isset($demo_html[$store_id][$language['language_id']])){ ?>
				    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-preview" class="vtabs">
				    				<a href="#tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-preview-with"><?php echo $text_withimages; ?></a>
				    				<a href="#tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-preview-without"><?php echo $text_withoutimages; ?></a>
				    				<a href="#tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-test-send"><?php echo $text_test_send; ?></a>
				    			</div>

				    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-preview-with" class="vtabs-content" style="padding: 10px 0">
				    				<table cellspacing="0" cellpadding="0">
				    					<?php echo $demo_html[$store_id][$language['language_id']] ?>
			    					</table>
				    			</div>

				    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-preview-without" class="removeImages vtabs-content" style="padding: 10px 0">
				    				<table cellspacing="0" cellpadding="0">
				    					<?php echo $demo_html[$store_id][$language['language_id']] ?>
			    					</table>
				    			</div>
				    			
				    			<div id="tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id'] ?>-test-send" class="removeImages vtabs-content">
				    				<table class="form">
				    					<tr class="noBorder">
											<td>
												<label for="send_to[store][<?php echo $store_id; ?>][<?php echo $language['language_id']; ?>]"><?php echo $entry_email_address; ?></label>
											</td>
											<td>
												<input class="large" type="text" name="send_to[<?php echo $store_id; ?>][<?php echo $language['language_id']; ?>]" value="" />
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td>
												<div class="buttons">
													<a onclick="$('#form').attr('action', '<?php echo $action; ?>'); $('#form').submit();" class="button"><span><?php echo $button_send; ?></span></a>
												</div>
											</td>
										</tr>
									</table>
				    			</div>
				    		<?php } else { ?>
				    			<p class="required"><?php echo $text_no_preview; ?></p>
				    		<?php } ?>
	    				</div><!-- .tabsHolder -->

    				</div><!-- tab-store-<?php echo $store_id; ?>-language-<?php echo $language['language_id']; ?> -->
    				<?php } ?>

    		</div><!-- tab-store-<?php echo $store_id; ?> -->
    		<?php } ?>
    		</form>

    		<div class="support">
				<h3>Documentation - <a href="<?php echo $docs_url; ?>">click here!</a></h3>
				<p>Please make sure you check the documentation before contacting us wih support queries, all common issues are included in the FAQ.</p>
				
				<h3>Feedback</h3>
				<ol>
					<li>If you have any suggests for improvements or features you would like adding please open a <a href="<?php echo $support_url; ?>" target="_blank">support ticket</a> and we will let you know if its possible. </li>
					<li><b>Please dont forget to rate the extension</b> by clicking the start rating on the <a href="http://www.opencart.com/index.php?route=account/extension/update&extension_id=2221" target="_blank">extension page</a></li>
				</ol>

				<h3>Extension not working correct?</h3>
				<ol>
					<li>Check you are using the latest version of <a href="http://code.google.com/p/vqmod/downloads/list" target="_blank">vqmod</a></li>
					<li>Do you have any vqmod errors(vqmod/vqmod.log OR vqmod/log/)? <span class="help">You can install <a href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=2969" target="_blank">vQmod manager</a> to help you check for vqmod errors</span></li>
					<li>Is the correct file appearing in the vqmod cache(vqmod/vqcache), try deleteing all of the cached files. Are these files re-generated?</li>
				</ol>

				<p>This is the most useful information you can provide when opening a <a href="<?php echo $support_url; ?>" target="_blank">support ticket</a> and will help in getting your issue resolved quicker.</p><p>This Extension is brought to you by: Opencart-templates</p>
			</div>

		</div><!-- .content -->
	</div><!-- .box -->
</div>

<link type="text/css" href="view/stylesheet/colorpicker.css" rel="stylesheet" media="screen" />
<link type="text/css" href="view/stylesheet/module/emailtemplate.css" rel="stylesheet" media="screen" />
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="view/javascript/jquery/colorpicker.js"></script>
<script type="text/javascript"><!--

//Image Uploads
function image_upload(field, thumb) {
	$('#dialog').remove();

	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},
		bgiframe: false,
		width: 700,
		height: 400,
		resizable: false,
		modal: false
	});
};

(function($){
	$(document).ready(function(){

		// Each store
		<?php foreach($stores as $_store) { ?>
			<?php if($_store['store_id'] != $store_id) continue; ?>
		
		$('#tab-store-<?php echo $_store['store_id']; ?>-languages a').tabs();

		<?php foreach($languages as $language){ ?>

			$('#tab-store-<?php echo $_store['store_id']; ?>-language-<?php echo $language['language_id'] ?>-editor a').tabs(); // Editor tabs
			$('#tab-store-<?php echo $_store['store_id']; ?>-language-<?php echo $language['language_id'] ?>-preview a').tabs(); // Preview tabs

			CKEDITOR.replace('store<?php echo $_store['store_id']; ?>_head_text_<?php echo $language['language_id']; ?>', {
				filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				toolbar : [
					{ name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
					{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
					{ name: 'document', items : [ 'Source'] }
				],
				height: 100
			});

			CKEDITOR.replace('store<?php echo $_store['store_id']; ?>_page_footer_text_<?php echo $language['language_id']; ?>', {
				filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
			});

			CKEDITOR.replace('store<?php echo $_store['store_id']; ?>_footer_text_<?php echo $language['language_id']; ?>', {
				filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
			});

			CKEDITOR.replace('store<?php echo $_store['store_id']; ?>_invoice_text_<?php echo $language['language_id']; ?>', {
				filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
				filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
			});

			// showcase Area autocomplete
			$('#selection_<?php echo $_store['store_id']; ?>_<?php echo $language['language_id']; ?>').autocomplete({
				delay: 500,
				multiple: true,
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
					var $field = $('input[name=\'store[<?php echo $_store['store_id']; ?>][emailtemplate_showcase_selection][<?php echo $language['language_id']; ?>]\']');
					var $output = $field.parents('table').find('.showcase_selection');
					 
					if($field.val() == '') {
						$field.val(ui.item.value);
						$output.find('ol').append('<li data-id="'+ui.item.value+'">'+ui.item.label+'<span class="remove"></span></li>');
						$(this).val('');
					} else {
						var selection = $field.val().split(',');
						if($.inArray(ui.item.value, selection) == -1){
							selection.push(ui.item.value);
							$field.val(selection.join(','));
							$output.find('ol').append('<li data-id="'+ui.item.value+'">'+ui.item.label+'<span class="remove"></span></li>');
							$(this).val('');
						}
					}	

					$output.show();				
																			
					return false;
				},
				focus: function(event, ui) {
			      	return false;
			   	}
			});
			
		<?php } ?>
		<?php } ?>

		// showcase radio option
		$('.showcase-options').change(function(){
			var $table = $(this).parents('table');
			
			switch($(this).val()){
				case 'products':
					$table.find('.showcase_products, .showcase_selection').show();
		  		break;
				default:
					$table.find('input[type=hidden]').val('');
					$table.find('ol').html('');
					$table.find('.showcase_products, .showcase_selection').hide();
			}
		});

		// Product Remove
		$(document.body).on('click', '.remove', function(e){
			var $item = $(this).parents('li');
			var id = $item.data('id');
			var $field = $(this).parents('tr').prev().find('input[type=hidden]');
			var values = $.map($field.val().split(','), function(value){ return parseInt(value, 10) });
			var index = $.inArray(id, values);
			if(index !== -1){
				values.splice(index, 1);
			}
			$field.val(values.join(','));
			$item.remove();
		});
		
		$.fn.hasAttr = function(name) {
		   return this.attr(name) !== undefined;
		};

		// Remove images/background
		$removeImages = $(".removeImages");
		$removeImages.each(function(){
			$(this).find("img").removeAttr("src");
			$(this).find("table,td,div").css("backgroundImage", "").removeAttr("background");
		});

		//Color Pickers
		$("input.fieldColorPicker").each(function(){
			var tis = $(this);

		    tis.ColorPicker({
				onSubmit: function(hsb, hex, rgb, el) {
					$(el).val("#"+hex).next().css("background-color","#"+hex);
					$(el).ColorPickerHide();
				},
				onChange: function(hsb, hex, rgb) {
					tis.val("#"+hex).next().css("background-color","#"+hex);
				},
				onBeforeShow: function() {
					tis.ColorPickerSetColor(tis.val());
				}
			}).bind('keyup', function(){
				tis.ColorPickerSetColor("#"+tis.val());
			});
		});

		// Select first tab if errors are hidden
		var $hidden_error = $('.tabsHolder .error').eq(0);
		if($hidden_error.length > 0){
			// tabs store
			$('.tab-nav-store a[href=#'+$hidden_error.parents(".tab-content-store").eq(0).attr('id')+']').click();

			// tabs language
			$('.tab-nav-language a[href=#'+$hidden_error.parents(".tab-content-language").eq(0).attr('id')+']').click();

			// tabs editor
		    $('.tab-nav-editor a[href=#'+$hidden_error.parents(".tab-content-editor").eq(0).attr('id')+']').click();
		}
	});
})(jQuery);
//--></script>
<?php echo $footer; ?>