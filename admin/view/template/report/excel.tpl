<?php
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=report.xls");
?>

<html>
<head>
<title>Listado de Stock</title>
</head>
<style type="text/css">
.xl65
{
 {mso-number-format:"\@"}
}
</style>
<body>
<table width="100%"  border="1px" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
            <td align="CENTER" bgcolor="#E6E6E6" border="1px"><b><?php echo $column_order; ?></b></td>
            <td align="CENTER" bgcolor="#E6E6E6" border="1px"><b><?php echo $column_status; ?></td>
            <td align="CENTER" bgcolor="#E6E6E6" border="1px"><b><?php echo $column_date_added; ?></td>
            <td align="CENTER" bgcolor="#E6E6E6" border="1px"><b><?php echo $column_email; ?></td>
            <td align="CENTER" bgcolor="#E6E6E6" border="1px"><b><?php echo $column_phone; ?></td>
            <td align="CENTER" bgcolor="#E6E6E6" border="1px"><b><?php echo $column_product_name; ?></td>
            <td align="CENTER" bgcolor="#E6E6E6" border="1px"><b><?php echo $column_model; ?></td>
            <td align="CENTER" bgcolor="#E6E6E6" border="1px"><b><?php echo $column_option; ?></td>
        </tr>
    </thead>
    <tbody>
          <?php if (isset($courses)) { ?>
          <?php foreach ($courses as $course) { ?>
          <tr>
            <td ><?php echo $course['order_id']; ?></td>
            <td ><?php echo $course['status']; ?></td>
            <td ><?php echo $course['date_added']; ?></td>
            <td ><?php echo $course['email']; ?></td>
            <td ><?php echo $course['telephone']; ?></td>
            <td ><?php echo $course['name']; ?></td>
            <td ><?php echo $course['model']; ?></td>
            <td >
                <?php foreach ($course['options'] as $option) { ?>
                    <br />
                    &nbsp; - <?php echo $option['name']; ?>: <?php echo $option['value']; ?>
                <?php } ?>
            </td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
    </tbody>
</table>

</body>
</html>
