<?php echo $header; ?>
<style>
                #settings{
                    width: 100%;
                    margin-top: 3ex;
                }
                .dp{
                    margin-top: 2ex;
                }
                
                .scrollbox {
                    margin-top: 2ex !important;
                    height: 150px !important; 
                }
            </style>
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
            <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="generateSpecials();" class="button"><span><?php echo $button_generate; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table id="settings"  >
                    <tbody>
                        <tr>
                            <td><div style="display:none;"><span class="required">*</span><?php echo $entry_customer_group; ?></div></td>
                            <td><div style="display:none;"><select name="customer_group_id">
                                <?php foreach ($customer_groups as $customer_group) { ?>
                                 <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                                <?php } ?>
                              </select></div></td>
                        </tr>
                        <tr>
                            <td><span class="required">*</span><?php echo $entry_products; ?>
                                <div class="buttons"><a onclick="deleteSpecials();" class="button"><span><?php echo $button_delete; ?></span></a></div>
                                <input type="hidden" name="action" id="action" value="add">
                            </td>
                           <td><div id="selected_products" class="scrollbox">
                                        <?php $class = 'odd'; ?>
                                        <?php foreach( $products as $product ) { ?>
                                                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                                <div class="<?php echo $class; ?>"> 
                                                        <input 
                                                                type="checkbox" 
                                                                name="selected_products[]" 
                                                                value="<?php echo $product['product_id']; ?>" 
                                                                />
                                                        <?php echo $product['name']; ?>
                                                </div>
                                        <?php } ?>
                                </div></td>
                            <td colspan="2">
                                <span class="required">*</span><?php echo $entry_free_days; ?>
                                <input type="hidden" name="free-dates" id="free-dates" value="">
                                <div id="free_dates_dp" class="dp">
                                    <script type="text/javascript"><!--
                                        $(".dp").datepick(
                                                { 
                                                    multiSelect: 999, 
                                                    monthsToShow: 3,
                                                    showTrigger: '#calImg'
                                                }
                                            );
                                //--></script> 
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
   </div>
</div>

<script type="text/javascript"><!--
function generateSpecials(){
   var dates = $('#free_dates_dp').datepick('getDate'); 
   var value = ''; 
   for (var i = 0; i < dates.length; i++) { 
       value += (i == 0 ? '' : ',') + $.datepick.formatDate(dates[i],'dd/mm/yyyy'); 
   } 
   $('#free-dates').val(value); 
   $('#form').submit();
}       

function deleteSpecials(){
   $('#action').val('delete'); 
   $('#form').submit();
}      
//--></script> 

<?php echo $footer; ?> 