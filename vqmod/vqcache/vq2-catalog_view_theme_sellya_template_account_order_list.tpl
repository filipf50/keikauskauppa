<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" class="span9"><div class="row-fluid"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php if ($orders) { ?>
  <?php foreach ($orders as $order) { ?>
  <div class="order-list">
    <div class="order-id"><b><?php echo $text_order_id; ?></b> #<?php echo $order['order_id']; ?></div>
    <div class="order-status"><b><?php echo $text_status; ?></b> <?php echo $order['status']; ?></div>
    <div class="order-content">
      <div><b><?php echo $text_date_added; ?></b> <?php echo $order['date_added']; ?><br />
        <b><?php echo $text_products; ?></b> <?php echo $order['products']; ?></div>
      <div><b><?php echo $text_customer; ?></b> <?php echo $order['name']; ?><br />
        <b><?php echo $text_total; ?></b> <?php echo $order['total']; ?></div>
      
                <div class="order-info"><?php if(strlen($order['cancel'])>0){?><a onclick="if(confirm('<?php echo $cancellation_msg; ?>'))window.location='<?php echo $order['cancel']; ?>';"><img src="catalog/view/theme/sellya/image/remove.png" alt="<?php echo $button_cancel ?>" title="<?php echo $button_cancel ?>" /></a>&nbsp;&nbsp;<?php } ?><a href="<?php echo $order['href']; ?>"><img src="catalog/view/theme/sellya/image/info.png" alt="<?php echo $button_view; ?>" title="<?php echo $button_view; ?>" /></a>&nbsp;&nbsp;<a href="<?php echo $order['reorder']; ?>"><img src="catalog/view/theme/sellya/image/reorder.png" alt="<?php echo $button_reorder; ?>" title="<?php echo $button_reorder; ?>" /></a></div>

                    <?php if ($order['balance']!=0 && $order['currency_balance']!=$order['total']) { ?>
                        <div style="padding-top: 1em;">
                            <form enctype="multipart/form-data" id="layaway" method="post" action=<?php echo $order['layaway_action']; ?>>
                                <?php echo $text_layaway_pending_amount . ' ' . $order['currency_balance']; ?> <a class="button" onclick="$('#layaway').submit();"><?php echo $button_layaway_pay_now ;?></a>
                                <input type="hidden" name="payment_amount" value="<?php echo $order['balance']; ?>">
                            </form>
                        </div>
                   <?php } ?>
                
                
            
    </div>
  </div>
  <?php } ?>
  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } else { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div></div>
<?php echo $footer; ?>