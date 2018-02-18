<div id="blogvideo_home" class="menu-recent owl-style3">
	 <div>
		  <div class="blog-title module-title">
			    <h2><?php echo $heading_title; ?></h2>
		  </div>
		<!-- <?php
			$count = 0;
			$rows = $slide['rows'];
			if(!$rows) { $rows = 1;}
			$j=0;
		?> -->
	 <?php if ($blogvideos) {?>
      <div class="row">
      <div class="articles-container">
        <?php foreach ($blogvideos as $blogvideo) { $j++; ?>
		  <!-- <?php  if($count % $rows == 0 ) { echo '<div class="row_items">'; }  $count++; ?> -->
          <div class="articles-inner item-inner">
            <div class="col col-md-6 col-xs-12">
              <div class="articles-image">

                <video width="320" height="240" controls>
                  <source src="https://onedrive.live.com/download?cid=364DB986E850480C&resid=364DB986E850480C%2121518&authkey=AJLO1H8EeZFc_tE" type="video/mp4">

                  Your browser does not support the video tag.
                </video>


              </div>
          </div>
			   <div class="col col-md-6 col-xs-12">
					<div class="aritcles-content">
						<div class="articles-date">


					   </div>
					   <a class="articles-name" href="#"><?php echo $blogvideo['title']; ?></a>
					   <div class="articles-intro"><?php echo html_entity_decode($blogvideo['short_description'], ENT_QUOTES, 'UTF-8');?></div>

					</div>
			   </div>
          </div>
		  <!-- <?php if($count % $rows == 0 || $count == count($articles)): ?>
	  		</div>
		 <?php endif; ?> -->
        <?php } ?>
      </div>
      </div>
      <?php } ?>

      <!-- <?php if (!$articles) { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?> -->
	  </div>
 <script>
 $(document).ready(function() {
	  $(".articles-container").owlCarousel({
			autoPlay : <?php if($slide['auto']) { echo 'true' ;} else { echo 'false'; } ?>,
			items : <?php echo $slide['items'] ?>,
			itemsDesktop : [1199,2],
			itemsDesktopSmall : [991,2],
			itemsTablet: [700,1],
			itemsMobile : [400,1],
			slideSpeed : <?php echo $slide['speed']; ?>,
			paginationSpeed : <?php echo $slide['speed']; ?>,
			rewindSpeed : <?php echo $slide['speed']; ?>,
			navigation : <?php if($slide['navigation']) { echo 'true' ;} else { echo 'false'; } ?>,
			pagination : <?php if($slide['pagination']) { echo 'true' ;} else { echo 'false'; } ?>,
			stopOnHover : true,
			addClassActive: true,
			navigationText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>']
	  });
 });
 </script>
</div>
