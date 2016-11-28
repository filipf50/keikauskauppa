<?php if ($out_stock_list) { ?>
    <div id="nwa_list_container">
        <div class="box" id="nwa_list" >
            <div class="box-content">
                <b id="nwa_list_box_title"><?php echo $heading_title; ?></b>
                <br/>
                <span id="nwa_list_box_description"><?php echo $text_description; ?></span>
                <br/>
                <?php if ($nwa_use_name){?>
                <span class="help"><?php echo $nwa_entry_name; ?></span> 
                <input type="text"    name="notify_name"  value="<?php echo $notify_name; ?>"  id="nwa_list_name" />
                <br/>               
                <?php }?>
                <?php if ($nwa_use_phone){?>
                 <span class="help"><?php echo $nwa_entry_phone; ?></span> 
                <input type="text"    name="notify_phone"    value="<?php echo $notify_phone; ?>"   id="nwa_list_phone" />
                <br/>
                <?php }?>   
                <?php if ($nwa_use_custom){?>
                 <span class="help"><?php echo $nwa_entry_custom; ?></span> 
                <input type="text"    name="notify_custom"      id="nwa_list_custom" />
                <br/>
                <?php }?> 
                 <?php if ($nwa_entry_mail){?>
                 <span class="help"><?php echo $nwa_entry_mail; ?></span> 
                 <?php }?> 
                <input type="text"    name="notify_email"      id="nwa_list_email" value="<?php echo $notify_email; ?>" />
                <br/>
                <br/>
		 <?php  if ($nwa_use_captcha){ ?> 
		    <br />
		    <span class="help"><?php echo $nwa_entry_captcha; ?></span><br />
		   <input type="text" name="nwa_captcha" id="nwa_list_captcha"  value="" />
		   <br />
		   <img src="index.php?route=module/notify_when_arrives/captcha" alt="" id="nwa_list_captcha_img" />
		   <br />
		 <?php }?> 
                <input type="hidden"  name="notify_product_id" id="nwa_list_product_id" value="<?php echo $notify_product_id; ?>"/>
                <a class="button" id="nwa_list_register">
                    <span><?php echo $button_register; ?></span>
                </a>
                <a class="button" id="nwa_list_close">
                    <span><?php echo $button_close; ?></span>
                </a>
                <div  id="nwa_list_msg"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
                         
        $(function() { 
                                     
            $('input[onclick*="addToCart"],a[onclick*="addToCart"]').nwaList({
                title:'<?php echo $heading_title; ?>',
                text:'<?php echo $button_category; ?>',
                out_stock_list:[<?php echo $out_stock_list; ?>],
                gray_style:<?php echo ($gray_style) ? 'true' : 'false'; ?>,
                show_mode: <?php echo $nwa_list_show_mode; ?>
            })         
        });
                            
    </script>
<?php } ?>
<?php if ($out_stock_product || $out_stock_option) { ?>
    <div id="nwa_product_container">
        <div class="box">
            <div class="box-content" id="nwa_product">
                <b id="nwa_product_box_title"><?php echo $heading_title; ?></b>
                <br/>
                <span id="nwa_product_box_description"><?php echo $text_description; ?></span>
                 <br/>
                <?php if ($nwa_use_name){?>
                <span class="help"><?php echo $nwa_entry_name; ?></span> 
                <input type="text"    name="notify_name"   value="<?php echo $notify_name; ?>"    id="nwa_name"  />
                <br/>               
                <?php }?>
                <?php if ($nwa_use_phone){?>
                 <span class="help"><?php echo $nwa_entry_phone; ?></span> 
                <input type="text"    name="notify_phone"    value="<?php echo $notify_phone; ?>"   id="nwa_phone" />
                <br/>
                <?php }?>   
                <?php if ($nwa_use_custom){?>
                 <span class="help"><?php echo $nwa_entry_custom; ?></span> 
                <input type="text"    name="notify_custom"      id="nwa_custom" />
                <br/>
                <?php }?> 
                 <?php if ($nwa_entry_mail){?>
                 <span class="help"><?php echo $nwa_entry_mail; ?></span> 
                 <?php }?> 
                <input type="text"     name="nwa_email"           id="nwa_email"       value="<?php echo $notify_email; ?>"/>
                <input type="hidden"   name="nwa_product_id"      id="nwa_product_id"  value="<?php echo $notify_product_id; ?>"/>
                <input type="hidden"   name="nwa_option_id"       id="nwa_option_id"   value=""/>
                <input type="hidden"   name="nwa_option_value_id" id="nwa_option_value_id" value=""/>
		 <?php  if ($nwa_use_captcha){ ?> 
		    <br />
		    <span class="help"><?php echo $nwa_entry_captcha; ?></span>
		   <input type="text" name="nwa_captcha" id="nwa_captcha" value="" />
		   <br />
		   <img src="index.php?route=module/notify_when_arrives/captcha" alt="" id="nwa_captcha_img" />
		   <br />
		   <br />
		 <?php }?> 
                <a class="button" id="nwa_product_register">
                    <span><?php echo $button_register; ?></span>
                </a>
                <a class="button" id="nwa_product_close">
                    <span><?php echo $button_close; ?></span>
                </a>
                <div  id="nwa_product_msg"></div>
            </div>
        </div>
    </div>
    <?php if ($out_stock_product) { ?>
        <script type="text/javascript">
            $(function() { 
                $('body').nwaProduct({
                    title:'<?php echo $heading_title; ?>',
                    text:'<?php echo $button_category; ?>',
                    out_stock_list:[<?php echo $out_stock_list; ?>],
                    gray_style:<?php echo ($gray_style) ? 'true' : 'false'; ?>,
                    show_mode: <?php echo $nwa_product_show_mode; ?>,
                    button_cart: '#button-cart'
                });
            });
        </script>
    <?php } ?>
<?php } ?>	

