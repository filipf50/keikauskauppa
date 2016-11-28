<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<table class="list" style="width:100%;">
  <thead>
    <tr>
      <td class="left"><?php echo $column_description; ?></td>
      <td class="left"><?php echo $column_date_added; ?></td>
      <td class="left"><?php echo $column_amount; ?></td>
  </tr>
  </thead>
  <tbody>
    <?php if ($layaways) { ?>
    <?php foreach ($layaways as $layaway) { ?>
    <tr>
      <td class="left"><?php echo $layaway['description']; ?></td>
      <td class="left"><?php echo $layaway['date_added']; ?></td>
      <td class="left"><?php echo $layaway['amount']; ?></td>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td class="center" colspan="3"><?php echo $text_no_results; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<!--paid to date-->
<div><p style="color:#069; font-size:18px;"><?php echo $text_paid; ?><?php echo $paid; ?></p>  <p style="color:#069; font-size:18px;"><?php echo $text_balance; ?><?php echo $balance; ?></p></div>
