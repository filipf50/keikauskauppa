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
                        <td><select style="min-width: 100px;" name="cob_status">
                                <?php if ($cob_status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select></td>
                    </tr>  
                    <tr>
                        <td><?php echo $entry_order_statuses; ?></td>
                        <td><div class="scrollbox" style="width: 220px">
                                <?php $class = 'odd'; ?>
                                <?php foreach ($order_status_list as $order_status) { ?>
                                    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                    <div class="<?php echo $class; ?>">
                                        <?php if (in_array($order_status['order_status_id'], $cob_order_statuses_allow_cancel)) { ?>
                                            <input id="ss<?php echo $order_status['order_status_id']; ?>" type="checkbox" name="cob_order_statuses_allow_cancel[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                                            <label for="ss<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></label>
                                        <?php } else { ?>
                                            <input id="ss<?php echo $order_status['order_status_id']; ?>" type="checkbox" name="cob_order_statuses_allow_cancel[]" value="<?php echo $order_status['order_status_id']; ?>" />
                                            <label for="ss<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></label>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_cancelled_status; ?></td>
                        <td><select name="cob_cancelled_status_id">
                            <?php foreach ($order_status_list as $order_status) { ?>
                            <?php if ($order_status['order_status_id'] == $cob_cancelled_status_id) { ?>
                            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                            <?php } ?>
                            <?php } ?>
                          </select></td>
                      </tr>
                </table>
            </form>
        </div>      
    </div>
</div>
<?php echo $footer; ?> 