<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($payment_methods) { ?>
<p><?php echo $text_payment_method; ?></p>
<table class="radio">
  <?php foreach ($payment_methods as $payment_method) { ?>
  <tr class="highlight">
    <td><?php if ($payment_method['code'] == $code || !$code) { ?>
      <?php $code = $payment_method['code']; ?>
      <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" checked="checked" />
      <?php } else { ?>
      <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" />
      <?php } ?></td>
    <td><label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?></label></td>
  </tr>
  <?php } ?>

			  <?php if (isset($layaway_is_active) && !isset($below_minimum)) { ?>
				<tr id="layaway_deposit_box" class="highlight">
				  <?php if (isset($layaway_cart) && !isset($need_to_register)) { ?>
				    <td><input type="checkbox" checked="checked" disabled="disabled" name="layaway_deposit" id="layaway_deposit" onclick="return layaway_deposit();" /></td><td><?php echo $entry_layaway_deposit; ?></td>
				  <?php } else { ?>
					<?php if (!isset($need_to_register)) { ?>
				      <td><input type="checkbox" name="layaway_deposit" id="layaway_deposit" onclick="return layaway_deposit();" /></td><td><?php echo $entry_layaway_deposit; ?></td>
					<?php } else { ?>
					  <td><input type="checkbox" name="layaway_deposit" id="layaway_deposit" onclick="layaway_message();" /></td><td><?php echo $entry_layaway_deposit; ?></td>
					<?php } ?>
				  <?php } ?>
				</tr>
				<?php if (isset($layaway_cart) && !isset($need_to_register)) { ?>
				  <tr id="layaway_deposit_checkout">
				<?php } else { ?>
				  <tr id="layaway_deposit_checkout" style="display:none;">
				<?php } ?>
				  <td colspan="2">
					<?php echo $entry_layaway_amount; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input style="text-align: right;" id="layaway_amount" type="text" name="layaway_amount" value="<?php echo $required_deposit; ?>" size="8" />
					<input type="hidden" name="required_layaway" value="<?php echo $required_deposit; ?>" />
					<input type="hidden" name="order_total" value="<?php echo $order_total; ?>" />
				  </td>
				</tr>
			  <?php } ?>
			
</table>
<br />
<?php } ?>
<b><?php echo $text_comments; ?></b>
<textarea name="comment" rows="8" style="width: 95%;"><?php echo $comment; ?></textarea>
<br />
<br />
<?php if ($text_agree) { ?>
<div class="buttons">
  <div class="right"><?php echo $text_agree; ?>
    <?php if ($agree) { ?>
    <input type="checkbox" name="agree" value="1" checked="checked" />
    <?php } else { ?>
    <input type="checkbox" name="agree" value="1" />
    <?php } ?>
    <br /><br />
				<input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" class="button" onclick="$('#layaway_deposit').attr('disabled', false);" />
			
  </div>
</div>
<?php } else { ?>
<div class="buttons">
  <div class="right">
    
				<input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" class="button" onclick="$('#layaway_deposit').attr('disabled', false);" />
			
  </div>
</div>
<?php } ?>
<script type="text/javascript"><!--
$('.colorbox').colorbox({
	width: 560,
	height: 560
});
//--></script> 

				<script type="text/javascript"><!--
					function layaway_deposit(){
						var satisfied = $('#layaway_deposit:checked').val();
						if ($('#layaway_deposit').is(':checked')) {
							$('#layaway_deposit_checkout').show();
                                                        $('#total_amount').html($('#layaway_amount').val());    
							$('#installment_box').hide();
						} else {
							$('#layaway_deposit_checkout').hide();
                                                        $('#total_amount').html($('input[name=\'order_total\']').val());    
							$('#installment_box').show();
						}
					}
						
					$(document).ready(function() {
						<?php if (isset($layaway_is_active) && !isset($below_minimum)) { ?>
							$('#layaway_amount').live('change', function() {
								if (parseFloat($('#layaway_amount').val()) < parseFloat($('input[name=\'required_layaway\']').val())) {
									alert('<?php echo $error_amount_low; ?>');
									$('#layaway_amount').val($('input[name=\'required_layaway\']').val());
									return false;
								} else if (parseFloat($('#layaway_amount').val()) > parseFloat($('input[name=\'order_total\']').val())) {
									alert('<?php echo $error_amount_high; ?>');
									$('#layaway_amount').val($('input[name=\'required_layaway\']').val());
									return false;
								}
                                                                $('#total_amount').html($('#layaway_amount').val());    
							});
						<?php } elseif (isset($layaway_cart) && isset($below_minimum)) { ?>
							$('#button-payment-method').hide();
							$('#button-payment').hide();
							$('.buttons').html('<?php echo $below_minimum_msg; ?>');
						<?php } ?>
					});
					
					function layaway_message() {
						alert('<?php echo $error_not_registered; ?>');
						$('#layaway_deposit').attr('checked', false);
						return;
					}
				//--></script>
			

                        <script type="text/javascript"><!--
                                $(document).ready(function() {
                                        <?php if (isset($layaway_is_active) && $layaway_checked) { ?>
                                                $('#layaway_deposit').attr('checked', true);
                                                layaway_deposit();
                                        <?php } ?>
                                });
                        //--></script>

				<script type="text/javascript"><!--
					function layaway_deposit(){
						var satisfied = $('#layaway_deposit:checked').val();
						if ($('#layaway_deposit').is(':checked')) {
							$('#layaway_deposit_checkout').show();
                                                        $('#total_amount').html($('#layaway_amount').val());    
							$('#installment_box').hide();
						} else {
							$('#layaway_deposit_checkout').hide();
                                                        $('#total_amount').html($('input[name=\'order_total\']').val());    
							$('#installment_box').show();
						}
					}
						
					$(document).ready(function() {
						<?php if (isset($layaway_is_active) && !isset($below_minimum)) { ?>
							$('#layaway_amount').live('change', function() {
								if (parseFloat($('#layaway_amount').val()) < parseFloat($('input[name=\'required_layaway\']').val())) {
									alert('<?php echo $error_amount_low; ?>');
									$('#layaway_amount').val($('input[name=\'required_layaway\']').val());
									return false;
								} else if (parseFloat($('#layaway_amount').val()) > parseFloat($('input[name=\'order_total\']').val())) {
									alert('<?php echo $error_amount_high; ?>');
									$('#layaway_amount').val($('input[name=\'required_layaway\']').val());
									return false;
								}
                                                                $('#total_amount').html($('#layaway_amount').val());    
							});
						<?php } elseif (isset($layaway_cart) && isset($below_minimum)) { ?>
							$('#button-payment-method').hide();
							$('#button-payment').hide();
							$('.buttons').html('<?php echo $below_minimum_msg; ?>');
						<?php } ?>
					});
					
					function layaway_message() {
						alert('<?php echo $error_not_registered; ?>');
						$('#layaway_deposit').attr('checked', false);
						return;
					}
				//--></script>
			
                