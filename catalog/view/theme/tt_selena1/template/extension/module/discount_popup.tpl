<div class="newletter-popup bgimg_popup">
<div id="boxes" class="newletter-container">
 <div id="dialog" class="window">
 <div id="popup2">
	<span class="b-close"><span>X</span></span>
</div>
	<div class="box">
		<div class="newletter-title"><h2>Special Offer</h2>
        <hr  />
        </div>
	  <div class="box-content newleter-content">
		<div class="special-product-slider special-button-owl">
	  <div class="special-products-slider">
	   	<?php if($products): ?>
			<?php foreach ($products as $product) { ?>
			<?php $count = 4;  if($count % 2 == 0 ) { echo '<div class="row_items">'; } $count++; ?>

			<div class="product-layout product-grid">
					<div class="product-thumb layout2">
						<div class="image">
							<a class="product-image" href="<?php echo $product['href']; ?>">
								<?php if($product['rotator_image']): ?>
								<img class="img-r lazy" src="<?php echo $product['rotator_image']; ?>" alt="<?php echo $product['name']; ?>" />
								<?php endif; ?>
								<img class="lazy" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
							</a>
								
								  <div class="label-product l-new">
									  <span><?php echo $text_new; ?></span>
								  </div>
								  <div class="label-product">
									  <span><?php echo $text_sale; ?></span>
								  </div>
								  
							
							</div><!-- image -->
					<div class="product-inner">
					
					
						<div class="product-caption">
							<?php if ($product['tags']) { ?>
						  <p class="tags-product">
							<?php for ($i = 0; $i < count($product['tags']); $i++) { ?>
							<?php if ($i < (count($product['tags']) - 1)) { ?>
							<a href="<?php echo $product['tags'][$i]['href']; ?>"><?php echo $product['tags'][$i]['tag']; ?></a>,
							<?php } else { ?>
							<a href="<?php echo $product['tags'][$i]['href']; ?>"><?php echo $product['tags'][$i]['tag']; ?></a>
							<?php } ?>
							<?php } ?>
						  </p>
					  <?php } ?>
							<h2 class="product-name">
								<a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
							</h2>
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
					
						<p class="product-des"><?php echo substr($product['description'], 0, 50).'...'; ?></p>
					
					
						<p class="price">
						  
								<span class="price-new"><?php echo $product['special']; ?></span>
								<span class="price-old"><?php echo $product['price']; ?></span>
						  
						</p>
						
					<div class="product-intro">
						<div class="actions-link">
							<a class="btn-compare" data-toggle="tooltip" title="<?php echo $button_compare; ?>"  onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="icon-refresh" aria-hidden="true"></i></a>
							
							<a class="button show_offers" href="<?php echo HTTPS_SERVER.'index.php?route=product/special'; ?>"></i><span class="button">Show Offers</span></a>
							
							<a class="btn-wishlist" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>"  onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="icon-heart" aria-hidden="true"></i></a>
						</div>						
					</div>
				</div>
				
				</div><!-- product-inner -->
			</div>
		</div>
				</div>				
				</div>
			
			</div>
			
			<?php } ?>
		
		<?php endif; ?>
   </div>
</div>
 </div>
</div>	
<script type="text/javascript">
    $(document).ready(function() {

		if($.cookie('shownewsletter')==1) $('.newletter-popup').hide();
		$('#subscribe_pemail').keypress(function(e) {
            if(e.which == 13) {
                e.preventDefault();
                email_subscribepopup();
            }
			var name= $(this).val();
		  	$('#subscribe_pname').val(name);
        });
		$('#subscribe_pemail').change(function() {
		 var name= $(this).val();
		  		$('#subscribe_pname').val(name);
		});
        //transition effect
        $('.newletter-popup').bPopup();

        if($.cookie("shownewsletter") != "<?php echo session_id(); ?>"){

        	$('.newletter-popup').bPopup();

        	$.cookie("shownewsletter","<?php echo session_id(); ?>")

        	var sessionid = "<?php $_SESSION['dis_pop'] = session_id(); ?>";
        }
	 
    });
</script>
</div><!-- /.box -->
</div
