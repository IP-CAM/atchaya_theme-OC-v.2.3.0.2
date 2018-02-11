<div class="bestseller">
<div class="module-title"><h2><?php echo $title; ?></h2></div>
<div class="bestseller-products-slider">
    <?php
        $count = 0;
        $rows = $config_slide['f_rows'];
        if(!$rows) { $rows=1; }
    ?>
    <?php if($products): ?>
        <?php foreach ($products as $product) { ?>
        <?php if($count++ % $rows == 0 ) { echo '<div class="row_items">'; } ?>
        <div class="item_product <?php if($count==1): ?> first-item <?php endif; ?> <?php if($count==count($products)): ?> last-item <?php endif; ?>">
            <div class="product-thumb layout1 transition">
                <div class="image">
                    <a href="<?php echo $product['href']; ?>">
                        <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive"/>
                        <?php if($product['rotator_image']): ?>
                        <img src="<?php echo $product['rotator_image']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive rotator-image" />
                        <?php endif; ?>
                    </a>
                </div>
                <div class="caption">
                    <?php if($config_slide['f_show_label']): ?>
                        <?php if ($product['is_new']):
                            if($product['special']): ?>
                                <div class="label-pro-sale"><?php echo $text_sale; ?></div>
                            <?php else: ?>
                                <div class="label-pro-new"><?php echo $text_new; ?></div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if($product['special']): ?>
                                <div class="label-pro-sale"><?php echo $text_sale; ?></div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
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
                    <h2 class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h2>
                    <?php if($config_slide['f_show_des']){ ?>
                    <p><?php echo $product['description']; ?></p>
                    <?php } ?>
                    
                    <?php if($config_slide['f_show_price']){ ?>
                    <?php if ($product['price']) { ?>
                    <p class="price">
                        <?php if (!$product['special']) { ?>
                        <?php echo $product['price']; ?>
                        <?php } else { ?>
                        <span class="price-new"><?php echo $product['special']; ?></span> <span
                            class="price-old"><?php echo $product['price']; ?></span>
                        <?php } ?>
                    </p> <?php } ?>
                    <?php } ?>
                </div>
                <div class="button-group">
                    <?php if($config_slide['f_show_addtocart']) { ?>
                    <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i
                            class="fa fa-shopping-cart"></i> <span
                            class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if($count % $rows == 0 || $count == count($products)) { echo '</div>'; } ?>
        <?php } ?>
    <?php else: ?>
        <p><?php echo $text_empty; ?></p>
    <?php endif; ?>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $(".bestseller-products-slider").owlCarousel({
        autoPlay: <?php if($config_slide['autoplay']) { echo 'true' ;} else { echo 'false'; } ?>,
        items : <?php if($config_slide['items']) { echo $config_slide['items'] ;} else { echo 3; } ?>,
        slideSpeed : <?php if($config_slide['f_speed']) { echo $config_slide['f_speed']; } else { echo 200;} ?>,
        navigation : <?php if($config_slide['f_show_nextback']) { echo 'true' ;} else { echo 'false'; } ?>,
        paginationNumbers : true,
        pagination : <?php if($config_slide['f_show_ctr']) { echo 'true' ;} else { echo 'false';} ?>,
        stopOnHover : false,
		itemsDesktop : [1199,2], 
    itemsDesktopSmall : [900,2], // betweem 900px and 601px
    itemsTablet: [767,2], //2 items between 600 and 0
    itemsMobile : [480,1] // itemsMobile disabled - inherit from itemsTablet option
    });

});
</script>