<?php echo $header; ?>
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
      <h1><img src="view/image/backup.png" alt="" /> <?php echo $heading_title; ?></h1>
     <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <div id="languages" class="htabs">
            <?php foreach ($languages as $language) { ?>
            <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
          </div>
          <?php foreach ($languages as $language) {  ?>
            <div id="language<?php echo $language['language_id']; ?>">
              <h2><?php echo $text_general; ?></h2>
              <table class="form">
              <tr>
                <td><?php echo $entry_status; ?></td>
                <td><select name="contact[<?php echo $language['language_id']; ?>][status]">
                    <?php if ($contact[$language['language_id']]['status'] ) { ?>
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
                <td><?php echo $entry_blackout; ?></td>
                <td><select name="contact[<?php echo $language['language_id']; ?>][blackout]">
                    <?php if ($contact[$language['language_id']]['blackout'] ) { ?>
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
              <td><?php echo $text_allowance; ?></td>
                <td><select name="contact[<?php echo $language['language_id']; ?>][allow]">
                    <?php foreach ($allows as $key => $value) { ?>
                      <?php if ($contact[$language['language_id']]['allow'] == $key ) { ?>
                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                      <?php } else {  ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td><?php echo $text_popup_extent; ?></td>
                <td><select name="contact[<?php echo $language['language_id']; ?>][pc]">
                    <?php if ($contact[$language['language_id']]['pc'] ) { ?>
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
                <td><?php echo $text_mobile; ?></td>
                <td><select name="contact[<?php echo $language['language_id']; ?>][mobile]">
                    <?php if ($contact[$language['language_id']]['mobile'] ) { ?>
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
                <td><?php echo $entry_image; ?></td>
                <td><div class="image"><img src="<?php  echo isset($contact[$language['language_id']]['thumb']) ? $contact[$language['language_id']]['thumb'] : $no_image ?>" alt="" id="thumb<?php echo $language['language_id']; ?>" /><br />
                    <input hidden name="contact[<?php echo $language['language_id']; ?>][image]" value="<?php  echo $contact[$language['language_id']]['image']; ?>" id="image<?php echo $language['language_id']; ?>" />
                    <a onclick="image_upload('image<?php echo $language['language_id']; ?>', 'thumb<?php echo $language['language_id']; ?>', <?php echo $language['language_id']; ?>);"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb<?php echo  $language['language_id']; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image<?php echo $language['language_id']; ?>').attr('value', 'data/no_image.jpg');"><?php echo $text_clear; ?></a></div>
                </td>
              </tr>
              <tr>
                <td><?php echo $entry_image_size; ?></td>
                <td><input type="text" name="contact[<?php echo $language['language_id']; ?>][width]" value="<?php  echo isset($contact[$language['language_id']]['width']) ? $contact[$language['language_id']]['width']: '220'; ?>" size="3" placeholder="width" />
                  x
                  <input type="text" name="contact[<?php echo $language['language_id']; ?>][height]" value="<?php  echo isset($contact[$language['language_id']]['height']) ? $contact[$language['language_id']]['height']: '220'; ?>" size="3" placeholder="height" />
                </td>
              </tr>
               <tr>
                <td><?php echo $text_location; ?></td>
                <td><select name="contact[<?php echo $language['language_id']; ?>][loc]">
                  <?php foreach ($locations as $key => $value) { ?>
                  <?php if ($contact[$language['language_id']]['loc'] == $key ) { ?>
                      <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                    <?php } else {  ?>
                      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>

                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td><?php echo $c_data; ?></td>
                 <td><textarea name="contact[<?php echo $language['language_id']; ?>][left]"  id="contactl<?php echo $language['language_id']; ?>"><?php echo isset($contact[$language['language_id']]) ? $contact[$language['language_id']]['left'] : ''; ?></textarea></td>
                </td>
              </tr>
              </table>
               <h2><?php echo $text_dynamic; ?></h2>
              <table class="form">
              <tr>
                <td><?php echo $entry_status; ?></td>
                <td><select name="dynamic[<?php echo $language['language_id']; ?>][status]">
                    <?php if ($dynamic[$language['language_id']]['status']) { ?>
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
              <td><?php echo $text_theme; ?></td>
                <td><select name="dynamic[<?php echo $language['language_id']; ?>][theme]">
                    <?php foreach ($themes as $key => $value) { ?>
                      <?php if ($dynamic[$language['language_id']]['theme'] == $key ) { ?>
                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                      <?php } else {  ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <td><?php echo $text_style; ?></td>
                <td><select name="dynamic[<?php echo $language['language_id']; ?>][style]">
                    <?php foreach ($styles as $key => $value) { ?>
                      <?php if ($dynamic[$language['language_id']]['style'] == $key ) { ?>
                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                      <?php } else {  ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td><?php echo $text_url; ?></td>
                <td><input name="dynamic[<?php echo $language['language_id']; ?>][url]" type="text" size="50" placeholder="Enter url on which you need popup" value="<?php echo $dynamic[$language['language_id']]['url']; ?>">
                </td>
              </tr>
              <tr>
                <td><?php echo $text_message; ?></td>
                <td><textarea name="dynamic[<?php echo $language['language_id']; ?>][message]" placeholder="Enter url on which you need popup" rows="4" cols="50"><?php echo $dynamic[$language['language_id']]['message']; ?></textarea>
                </td>
              </tr>
              </table>
              <h2><?php echo $text_newsletter; ?></h2>
              <table class="form">
              <tr>
                <td><?php echo $entry_status; ?></td>
                <td>
                  <select name="newsletter[<?php echo $language['language_id']; ?>][status]">
                    <?php if ($newsletter[$language['language_id']]['status']) { ?>
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
                <td><?php echo $text_theme; ?></td>
                <td><select name="newsletter[<?php echo $language['language_id']; ?>][theme]">
                    <?php foreach ($themes as $key => $value) { ?>
                      <?php if ($newsletter[$language['language_id']]['theme'] == $key ) { ?>
                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                      <?php } else {  ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td><?php echo $text_logo; ?></td>
                <td>
                  <select name="newsletter[<?php echo $language['language_id']; ?>][logo]">
                    <?php if ($newsletter[$language['language_id']]['logo']) { ?>
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
                <td><?php echo $entry_image; ?></td>
                <td><div class="image"><img src="<?php  echo isset($newsletter[$language['language_id']]['thumb']) ? $newsletter[$language['language_id']]['thumb'] : $no_image ?>" alt="" id="thumb1<?php echo $language['language_id']; ?>" /><br />
                    <input hidden name="newsletter[<?php echo $language['language_id']; ?>][image]" value="<?php  echo $newsletter[$language['language_id']]['image']; ?>" id="image1<?php echo $language['language_id']; ?>" />
                    <a onclick="image_upload('image1<?php echo $language['language_id']; ?>', 'thumb1<?php echo $language['language_id']; ?>', <?php echo $language['language_id']; ?>);"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb1<?php echo  $language['language_id']; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image1<?php echo $language['language_id']; ?>').attr('value', 'data/no_image.jpg');"><?php echo $text_clear; ?></a></div>
                </td>
              </tr>
              <tr>
                <td><?php echo $entry_image_size; ?></td>
                <td><input type="text" name="newsletter[<?php echo $language['language_id']; ?>][width]" value="<?php  echo isset($newsletter[$language['language_id']]['width']) ? $newsletter[$language['language_id']]['width']: '220'; ?>" size="3" placeholder="width" />
                  x
                  <input type="text" name="newsletter[<?php echo $language['language_id']; ?>][height]" value="<?php  echo isset($newsletter[$language['language_id']]['height']) ? $newsletter[$language['language_id']]['height']: '220'; ?>" size="3" placeholder="height" />
                </td>
              </tr>
              <tr>
                <td><?php echo $text_message; ?></td>
                <td><textarea name="newsletter[<?php echo $language['language_id']; ?>][message]" placeholder="Enter Your Message" rows="4" cols="50"><?php echo $newsletter[$language['language_id']]['message']; ?></textarea>
                </td>
              </tr>
              <tr>
                <td><?php echo $text_fname; ?></td>
                <td>
                   <select name="newsletter[<?php echo $language['language_id']; ?>][fname]">
                    <?php if ($newsletter[$language['language_id']]['fname']) { ?>
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
                <td><?php echo $text_lname; ?></td>
                <td>
                   <select name="newsletter[<?php echo $language['language_id']; ?>][lname]">
                    <?php if ($newsletter[$language['language_id']]['lname']) { ?>
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
                <td><?php echo $text_viewemail; ?></td>
                <td>
                  <a href="<?php echo $action1; ?>" class="button">View Subscriber list</a>
                </td>
              </tr>
              <tr>
                <td><?php echo $text_importemail; ?></td>
                <td>
                  <a href="<?php echo $emaillist; ?>" class="button">Download Available Subscribers</a>
                </td>
              </tr>
              </table>
            </div>
          <?php } ?>
      
      </form></div></div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('contactl<?php echo $language['language_id']; ?>', {
  filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//--></script>
<script type="text/javascript"><!--
function image_upload(field, thumb, id) {
  $('#dialog').remove();
  
  $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
  
  $('#dialog').dialog({
    title: '<?php echo $text_image_manager; ?>',
    close: function (event, ui) {
      if ($('#' + field).attr('value')) {
        $.ajax({
          url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
          dataType: 'text',
          success: function(text) {
            $('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
          }
        });
      }
    },  
    bgiframe: false,
    width: 800,
    height: 400,
    resizable: false,
    modal: false
  });
};
//--></script>
<script type="text/javascript"><!--
$('#languages a').tabs(); 
//--></script> 
<?php echo $footer; ?>