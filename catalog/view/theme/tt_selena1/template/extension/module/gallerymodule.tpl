<div class="gallery_homepage">
<div class="container">
	<div class="blog-title module-title">
			    <h2>Gallery</h2>
		  </div>
	<div class="row">
		<div class="popup-gallery">
			<?php
    		foreach($galleries as $gallery)
    		{
    			?>
    			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="gall_image">
    				<a href="<?php echo 'image/'.$gallery['image']; ?>" title="<?php echo 	$gallery['name']; ?>" data-source="<?php echo $gallery['description']; ?>"">
    					<img src="<?php echo 'image/'.$gallery['image']; ?>" width="75" height="75">
    				</a>
</div>
    			</div>
        		<?php
    		}
    		?>
    	</div>
	</div>
</div>
</div>

<script>
	$(document).ready(function() {
		$('.popup-gallery').magnificPopup({
			delegate: 'a',
    		type: 'image',
			closeOnContentClick: false,
			closeBtnInside: false,
			mainClass: 'mfp-with-zoom mfp-img-mobile',
			image: {
				verticalFit: true,
			  	titleSrc: function(item) {
					return item.el.attr('title') + '<div>'+item.el.attr('data-source')+'</div>';
			  	}
			},
			gallery: {
			  enabled: true
			},
			zoom: {
				enabled: true,
			  	duration: 300, 
			  	opener: function(element) {
				return element.find('img');
			  	}
			}
  		});
	});
</script>