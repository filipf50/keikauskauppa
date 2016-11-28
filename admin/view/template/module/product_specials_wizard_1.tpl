<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $title; ?></title>
    <base href="<?php echo $base; ?>" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.js"></script>
    <script type="text/javascript" src="view/javascript/jquery/ui/minified/datepicker/jquery.plugin.min.js"></script> 
    <script type="text/javascript" src="view/javascript/jquery/ui/minified/datepicker/jquery.datepick.min.js"></script>
    <link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery.datepick.css"> 
    <style>
        #settings{
            width: 100%;
            margin-left: 4ex;
        }
        .dp{
            margin-top: 2ex;
        }
    </style>
</head>
<body>
    <div id="header">
        <table id="settings"  >
            <tbody>
                <tr>
                    <td><?php echo $entry_customer_group; ?> </td>
                    <td><select name="customer_group_id">
                        <?php foreach ($customer_groups as $customer_group) { ?>
                        <?php if ($customer_group['customer_group_id'] == $product_special['customer_group_id']) { ?>
                        <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select></td>
                   <td><?php echo $entry_starting_price; ?> </td>
                   <td><input type="text" name="starting_price" value="<?php echo $starting_price; ?>"> 
                </tr>
                <tr>
                   <td><?php echo $entry_steps; ?> </td>
                   <td><input type="text" name="steps" value=""></td> 
                   <td><?php echo $entry_days_betteen_steps; ?> </td>
                   <td><input type="text" name="days_between_steps" value=""> </td>
                </tr>
                <tr>
                   <td><?php echo $entry_starting_date; ?> </td>
                   <td><input type="text" name="starting_date" value="<?php echo $starting_date; ?>"> </td>
                   <td colspan="2" rowspan="2" >
                        <?php echo $entry_free_days; ?>
                        <div id="free_dates" class="dp">
                            <script type="text/javascript"><!--
                                $(".dp").datepick({ 
                                multiSelect: 999, monthsToShow: 1, 
                                showTrigger: '#calImg'});
                        //--></script> 
                        </div>
                    </td>
                </tr>
                <tr>
                   <td><?php echo $entry_ending_date; ?> </td>
                   <td><input type="text" name="ending_date" value="<?php echo $ending_date; ?>"> </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <a style="width:90%;text-align: center;" onclick="generateSpecials()" class="button"><?php echo $button_calculate; ?></a>
                    </td>
                </tr>
            </tbody>
        </table>
        
    </div>
    <div id="container">
        <table id="special" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $column_customer_group; ?></td>
              <td class="right"><?php echo $column_price; ?></td>
              <td class="left"><?php echo $column_date_start; ?></td>
              <td class="left"><?php echo $column_date_end; ?></td>
            </tr>
          </thead>
          <?php $special_row = 0; ?>
          <?php if(isset($product_specials)){
            foreach ($product_specials as $product_special) { ?>
          <tbody id="special-row<?php echo $special_row; ?>">
            <tr>
              <td class="left"><select name="product_special[<?php echo $special_row; ?>][customer_group_id]">
                  <?php foreach ($customer_groups as $customer_group) { ?>
                  <?php if ($customer_group['customer_group_id'] == $product_special['customer_group_id']) { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td class="right"><input type="text" name="product_special[<?php echo $special_row; ?>][price]" value="<?php echo $product_special['price']; ?>" /></td>
              <td class="left"><input type="text" name="product_special[<?php echo $special_row; ?>][date_start]" value="<?php echo $product_special['date_start']; ?>" class="date" /></td>
              <td class="left"><input type="text" name="product_special[<?php echo $special_row; ?>][date_end]" value="<?php echo $product_special['date_end']; ?>" class="date" /></td>
              <td class="left"><a onclick="$('#special-row<?php echo $special_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
            </tr>
          </tbody>
          <?php $special_row++; ?>
          <?php }
            }?>
        </table>
    </div>
    <div id="footer">
        <div class="buttons"><a href="http://localhost/keikauskauppa/admin/index.php?route=catalog/product&amp;token=42f532b1af22891e53db9231ac8b0ba6" class="button">Cancel</a><a onclick="$('#form').submit();" class="button">Save</a></div>
    </div>
</body>
</html>