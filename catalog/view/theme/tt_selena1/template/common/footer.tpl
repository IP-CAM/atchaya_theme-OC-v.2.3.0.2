<footer class="custom_organic">
  <div class="container">
	<!--<div class="footer-border"></div>-->
 
          
    <div class="row">
		<div class="footer-top">
		  <?php if ($informations) { ?>
		  <div class="col-md-3 col-sm-6 col-footer">
			<div class="title-footer"><?php echo $text_contact; ?></div>
			<div class="list-unstyled footer-contact text-content">
			  <p class="address">Address: <span>110-114 W George St, City Centre, Glasgow G2 1NF, USA</span></p>
			  <p class="phone">Call Us Now: <span>+0123 - 456 - 78 - 89<br>+0123 - 567 - 78 - 89</span></p>
			  <p class="email">Email: <span><a href="#">support@plazathemes.com</a></span></p>
			</div>
		  </div>
		  <?php } ?>
		  <div class="col-md-2 col-sm-6 col-footer">
			<div class="title-footer"><?php echo $text_account; ?></div>
			<ul class="list-unstyled text-content">
			  <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
			  <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
			  <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
			  <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
			  <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
			  <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
			</ul>
		  </div>
              <div class="col-md-3 col-sm-6 col-footer">
                    <?php if(isset($block3)){ ?>
                        <?php echo $block3; ?>
                    <?php } ?>
              </div>
              
                 
    <div class="col-md-4 col-sm-6 col-footer">
			<?php if(isset($block2)){ ?>
					<?php echo $block2; ?>
				<?php } ?>
		  </div>
		  
		</div>
	</div>
  </div>
  <div class="footer-botton">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<p class="text-powered">
					<?php echo $powered; ?>
				</p>
			</div>
			<!--<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="payment"><img src="image/catalog/cmsblock/payment.png" alt="" class="img-responsive"></div>
			</div>-->
		</div>
	</div>
	</div>
  <div id="back-top"><i class="fa fa-angle-up"></i></div>
<script type="text/javascript">
$(document).ready(function(){
	// hide #back-top first
	$("#back-top").hide();
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 300) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});
		// scroll body to 0px on click
		$('#back-top').click(function () {
			$('body,html').animate({scrollTop: 0}, 800);
			return false;
		});
	});
});
</script>
</footer>

<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->

<!-- Theme created by Welford Media for OpenCart 2.0 www.welfordmedia.co.uk -->

</body></html>