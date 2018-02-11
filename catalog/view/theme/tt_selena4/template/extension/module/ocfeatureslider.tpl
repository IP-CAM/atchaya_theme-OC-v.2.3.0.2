<div class="featuredslider special-button-owl">
  <div class="module-title">
    <h2><?php echo $title; ?></h2>
  </div>
  <?php
	  $count = 0;
	  $rows = $config_slide['f_rows'];
	  if(!$rows) { $rows=1; }
   ?>
  <div class="featured-product-slider">
    <?php if($products): ?>
            <?php foreach ($products as $product) { ?>
            <?php  if($count % $rows == 0 ) { echo '<div class="row_items">'; } $count++; ?>
            <div class="item_product">
              <div class="layout1">
                <div class="image">
                  <a class="product-image" href="<?php echo $product['href']; ?>">
                    <?php if($product['rotator_image']): ?>
                    <img class="img2" src="<?php echo $product['rotator_image']; ?>" alt="<?php echo $product['name']; ?>" />
                    <?php endif; ?>
                    <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
                  </a>
                </div><!--images-->
                <div class="caption">
					<?php if (isset($product['rating'])) { ?>
                  <div class="ratings">
                    <div class="rating-box">
                      <?php for ($i = 0; $i <= 5; $i++) { ?>
                      <?php if ($product['rating'] == $i) {
                                                $class_r= "rating".$i;
                                                echo '<div class="'.$class_r.'">rating</div>';
                    }
                    }  ?>
                  </div>
                </div>
                <?php } ?>
                  <h2 class="product-name">
                    <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                  </h2>
				   <?php if($config_slide['f_show_price']) { ?>
						<p class="price">
						  <?php if (!$product['special']) { ?>
							<?php echo $product['price']; ?>
						  <?php } else { ?>
								<span class="price-new"><?php echo $product['special']; ?></span>
								<span class="price-old"><?php echo $product['price']; ?></span>
						  <?php } ?>
						</p>
					<?php } ?>
                  <?php if($config_slide['f_show_des']){ ?>
                  <p><?php echo $product['description']; ?></p>
                  <?php } ?>
                <?php if($config_slide['f_show_addtocart']) { ?>
                <button class="button btn-cart" type="button" data-toggle="tooltip" title="<?php echo $button_cart; ?>" onclick="cart.add('<?php echo $product['product_id']; ?>');">
                  <span><span><?php echo $button_cart; ?></span></span>
                </button>
                <?php } ?>
              </div><!--des-container-->
            </div> <!-- item-inner -->
          </div> <!-- item -->
          <?php if($count % $rows == 0 || $count == count($products)): ?>
        </div>
        <?php endif; ?>
        <?php } ?>
    <?php else: ?>
      <p><?php echo $text_empty; ?></p>
    <?php endif; ?>

  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $(".featured-product-slider").owlCarousel({
      autoPlay: <?php if($config_slide['autoplay']) { echo 'true' ;} else { echo 'false'; } ?>,
    items : <?php if($config_slide['items']) { echo $config_slide['items'] ;} else { echo 3; } ?>,
    slideSpeed : <?php if($config_slide['f_speed']) { echo $config_slide['f_speed']; } else { echo 200;} ?>,
    navigation : <?php if($config_slide['f_show_nextback']) { echo 'true' ;} else { echo 'false'; } ?>,
    paginationNumbers : true,
            pagination : <?php if($config_slide['f_show_ctr']) { echo 'true' ;} else { echo 'false';} ?>,
    stopOnHover : false,
            itemsDesktop : [1199,3],
            itemsDesktopSmall : [991,2],
            itemsTablet: [700,2],
            itemsMobile : [400,1],
  });
  });
</script>