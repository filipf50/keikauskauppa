<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" class="span9"><div class="row-fluid"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <table class="list">
    <thead>
      <tr>
        <td class="left" colspan="2"><?php echo $text_order_detail; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left" style="width: 50%;"><?php if ($invoice_no) { ?>
          <b><?php echo $text_invoice_no; ?></b> <?php echo $invoice_no; ?><br />
          <?php } ?>
          <b><?php echo $text_order_id; ?></b> #<?php echo $order_id; ?><br />
          <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?></td>
        <td class="left" style="width: 50%;"><?php if ($payment_method) { ?>
          <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
          <?php } ?>
          <?php if ($shipping_method) { ?>
          <b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?>
          <?php } ?></td>
      </tr>
    </tbody>
  </table>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $text_payment_address; ?></td>
        <?php if ($shipping_address) { ?>
        <td class="left"><?php echo $text_shipping_address; ?></td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left"><?php echo $payment_address; ?></td>
        <?php if ($shipping_address) { ?>
        <td class="left"><?php echo $shipping_address; ?></td>
        <?php } ?>
      </tr>
    </tbody>
  </table>
  <div class="order-i">
  <table class="list">
    <thead>
      <tr>
        <td class="left name"><?php echo $column_name; ?></td>
        <td class="left model"><?php echo $column_model; ?></td>
        <td class="right quantity"><?php echo $column_quantity; ?></td>
        <td class="right price"><?php echo $column_price; ?></td>
        <td class="right total"><?php echo $column_total; ?></td>
        <?php if ($products) { ?>
        <td style="width: 1px;"></td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
        <td class="left name"><?php echo $product['name']; ?>
          <?php foreach ($product['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
          <?php } ?></td>
        <td class="left model"><?php echo $product['model']; ?></td>
        <td class="right quantity"><?php echo $product['quantity']; ?></td>
        <td class="right price"><?php echo $product['price']; ?></td>
        <td class="right total"><?php echo $product['total']; ?></td>
        <td class="right"><a href="<?php echo $product['return']; ?>"><img src="catalog/view/theme/sellya/image/return.png" alt="<?php echo $button_return; ?>" title="<?php echo $button_return; ?>" /></a></td>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td class="left name"><?php echo $voucher['description']; ?></td>
        <td class="left model"></td>
        <td class="right quantity">1</td>
        <td class="right price"><?php echo $voucher['amount']; ?></td>
        <td class="right total"><?php echo $voucher['amount']; ?></td>
        <?php if ($products) { ?>
        <td></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td class="name"></td>
        <td class="model"></td>
        <td class="quantity"></td>
        <td class="right price"><b><?php echo $total['title']; ?>:</b></td>
        <td class="right total"><?php echo $total['text']; ?></td>
        <?php if ($products) { ?>
        <td></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
  </div>
  <?php if ($comment) { ?>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $text_comment; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left"><?php echo $comment; ?></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>

				<?php if ($layaways) { ?>
					<h2><?php echo $text_layaway_payment_history; ?></h2>
					<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
					<table class="list">
						<thead>
							<tr>
								<td class="left"><?php echo $column_description; ?></td>
								<td class="left"><?php echo $column_date_added; ?></td>
								<td class="right"><?php echo $column_amount; ?></td>
								<td class="right"><?php echo $column_balance; ?></td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($layaways as $layaway) { ?>
								<tr>
									<td class="left"><?php echo $layaway['description']; ?></td>
									<td class="left"><?php echo $layaway['date_added']; ?></td>
									<td class="right"><?php echo $layaway['amount']; ?></td>
									<td class="right"><font color="#2755bb"><?php echo $layaway['balance']; ?></font></td>
								</tr>
							<?php } ?>
							<?php if ($balance > 0) { ?>
							  <tr>
								<td class="right" colspan="3"><?php echo $entry_payment_amount; ?><input style="margin-left: 5px;" type="text" name="payment_amount" value="" size="8" /></td>
								<td class="center"><a id="make_payment" class="button"><span><?php echo $button_payment; ?></span></a></td>
							  </tr>
							<?php } ?>
						</tbody>
					</table>
					</form>
				<?php } ?>
			
  <?php if ($histories) { ?>
  <h2><?php echo $text_history; ?></h2>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $column_date_added; ?></td>
        <td class="left"><?php echo $column_status; ?></td>
        <td class="left"><?php echo $column_comment; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($histories as $history) { ?>
      <tr>
        <td class="left"><?php echo $history['date_added']; ?></td>
        <td class="left"><?php echo $history['status']; ?></td>
        <td class="left"><?php echo $history['comment']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div></div>

				<?php if ($layaways) { ?>
					<script type="text/javascript">
						$(document).ready(function() {
							$('#make_payment').live('click', function() {
								if (parseFloat($('input[name=\'payment_amount\']').val()) > parseFloat('<?php echo $balance; ?>') || parseFloat($('input[name=\'payment_amount\']').val()) <= 0 || $('input[name=\'payment_amount\']').val() == '') {
									alert('<?php echo $error_payment_amount; ?>');
									$('input[name=\'payment_amount\']').val('');
									$('input[name=\'payment_amount\']').focus();
									return false;
								} else {
									$('#form').submit();
								}
							});
						});
					</script>
				<?php } ?>
			
<?php echo $footer; ?> 