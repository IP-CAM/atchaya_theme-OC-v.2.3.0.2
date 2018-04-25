<?php echo $header; ?>
<div class="gallery_homepage gallery_popup">
<div class="container">

	<div class="blog-title module-title">
			    <h2>Gallery</h2>
		  </div>

	<div class="row">
		<div class="popup-gallery">
			<?php
			if(!isset($_REQUEST['id']))
			{
				$gallery_count = '4';
			}
			else
			{
				$gallery_count = count($galleries);
			}
			$g = 1;
    		foreach($galleries as $gallery)
    		{
    			if($g <= $gallery_count)
    			{
	    			?>
	    			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 column">
	<div class="gall_image">
	    				<a href="<?php echo 'image/'.$gallery['image']; ?>" title="<?php echo 	$gallery['name']; ?>" data-source="<?php echo $gallery['description']; ?>"">
	    					<img src="<?php echo 'image/'.$gallery['image']; ?>" width="75" height="75">
	    					<div class="portfolio__item__img__mask ">
								<h3 class="text-center"><?php echo 	$gallery['name']; ?></h3>
							</div>
	    				</a>
	</div>
	    			</div>
	        		<?php
        		}
        		$g++;
    		}
    		?>
    	</div>
    	<?php
    		if(!isset($_REQUEST['id']))
    		{
    			echo '<div class="banner7-readmore gallery_readmore"><a href="index.php?route=extension/module/gallerymodule&id=1">View More</a></div>';
    		}
    	?>
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
<style>
.gallery_popup .column 
{
	  padding:0px;
	  margin:0px;
}

.gallery_popup:after 
{
  content: "";
  display: table;
  clear: both;
}

  .gallery_popup .column  
 {
float: left;
padding: 0px;
margin: 10px;
width: 23%;
position: relative;
overflow: hidden;
}
  .gallery_popup .column a {
	  display:block;
	  padding:0px;
	  margin:0px;
}
.gallery_popup .column img
  {
padding: 0px;
margin: 0px;
width: 100%;
border-radius: 3px;
cursor: pointer;
position:relative;
-webkit-transition: all 1s ease;
transition: all 1s ease;
  }
 .gallery_popup .column:hover > img {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}
 .gallery_popup .column:hover > .zoom_hover > img {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}
  .gallery_popup .column:hover .portfolio__item__img__mask {
    -webkit-transform: scale(1);
    transform: scale(1);
    opacity: 1;
}
  .gallery_popup .column:hover .portfolio__item__img__mask > * {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    opacity: 1;
}
  .gallery_popup .column:hover .portfolio__item__img__mask > * {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    opacity: 1;
}
 .gallery_popup .column:hover .portfolio__item__img__mask {
    -webkit-transform: scale(1);
    transform: scale(1);
    opacity: 1;
}
.portfolio__item__img__mask {
    display: -webkit-box;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    flex-direction: column;
    -webkit-box-pack: center;
    justify-content: center;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    padding: 15px;
    background-color: rgba(0, 0, 0, 0.5);
    opacity: 0;
    -webkit-transform: scale(0);
    transform: scale(0);
    -webkit-transition: opacity 1s ease;
    transition: opacity 1s ease;
}
 .portfolio__item__img__mask > h3 {
margin-bottom: 1em;
color: white;
-webkit-transform: translateY(-100%);
transform: translateY(-100%);
font-size: 20px;
font-weight: 600;
}
 .portfolio__item__img__mask > * {
    -webkit-transform: translateY(100%);
    transform: translateY(100%);
    opacity: 0;
    -webkit-transition: all 0.5s ease;
    transition: all 0.5s ease;
}
.gallery_readmore
{
	display: table;
	width: 100%;
}

</style>
<?php echo $footer; ?>