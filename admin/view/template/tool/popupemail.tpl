<?php echo $header; ?>
<link rel="stylesheet" type="text/css" href="view/stylesheet/popupemail.css">
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
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
     <div class="buttons"><a href="<?php echo $action; ?>" class="button"><?php echo $popupemail_setting; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel ?></a></div>
    </div>
    <div class="content">
        <table class="list">
          <thead>
            <tr>
              <td class="center" style="width:100px"><?php if ($sort == 'id') { ?>
                <a href="<?php echo $sort_id; ?>" title="popupemail Number" class="<?php echo strtolower($order); ?>"><?php echo $popupemail_id; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_id; ?>" title="popupemail Number"><?php echo $popupemail_id; ?></a>
                <?php } ?></td>
              <td class="center"><?php echo $popupemail_fname; ?></td>
              <td class="center"><?php echo $popupemail_lname; ?></td>
              <td class="center"><?php echo $popupemail_email; ?></td>
              <td class="center" style="width:100px"><?php echo $popupemail_date; ?></td>
              <td class="center" style="width:100px"><?php echo $popupemail_delete; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($popupemail)) { ?>
            <?php foreach ($popupemail as $fh) { ?>
            <tr class="<?php echo $fh['id']; ?>">
              <td class="center"><?php echo $fh['id']; ?></td>
              <td class="center"><?php echo $fh['fname']; ?></td>
              <td class="center"><?php echo $fh['lname'] ?></td>
              <td class="center"><?php echo $fh['email']; ?></td>
              <td class="center"><?php echo $fh['date'] ?></td>
              <td class="center"> <a onclick='deletes(<?php echo $fh['id']; ?>)'><img src="view/image/error.png"></a></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          
          </tbody>
        </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script>
  function getdetail(id) {
    $.ajax({
      url: 'index.php?route=tool/popupemail/getd&token=<?php echo $token; ?>&id=' +  id,
      dataType: 'json',
      success: function(data) { 
        var html = '';
        html += '<div class="popupemailhpopup"></div>';
        html += '<div class="popupemailhpopupc"><h4>Message:</h4><div class="message">'+data+'</div><br><button class="fclose">Got it</button></div>';
        $(html).insertBefore('body');
        $('.popupemailhpopup').show(); 
        $('.popupemailhpopup').show();
        $('.popupemailhpopup,.fclose').live('click', function() {
          $('.popupemailhpopup').remove();
          $('.popupemailhpopupc').remove();
        });
      }
    });
  };
</script>
<script>
 function deletes(id) {
      if (confirm('Are you sure you want to delete this popupemail?')) {
            $.ajax({
              url: 'index.php?route=tool/popupemail/delete&token=<?php echo $token; ?>&id=' +  id,
              dataType: 'json',
              success: function(data) { 
               $('tr.'+id).remove();
               $('<div class="success">Deleted Successfully</div>').insertAfter('.breadcrumb');
              }
            });
      } else {
        return false;
      }
  };
</script>
<?php echo $footer; ?>