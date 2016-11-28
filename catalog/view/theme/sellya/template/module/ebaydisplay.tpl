<div class="box">
  <div class="box-heading"><h2><?php echo $heading_title; ?></h2></div>
  <div class="box-content">
    <div class="box-product">
      <?php foreach ($products as $product) { ?>
      <div class="l_column">
        <?php if ($product['thumb']) { ?>
        <div class="image hidden-tablet"><a href="<?php echo $product['href']; ?>" target="_blank"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>" target="_blank"><?php echo $product['name']; ?></a></div>
        <div class="price">
            <?php echo $product['price']; ?>
        </div>
      </div>
      <?php } ?>
      <img src="<?php echo $tracking_pixel; ?>" height="0" width="0" />
    </div>
  </div>
</div>