<div id="blogvideo_home" class="menu-recent owl-style3">
	<div>

		<div class="blog-title module-title">
			<h2><?php echo $heading_title; ?></h2>
		</div>

		<?php if ($blogvideos) {?>

			<div class="row">
				<div class="articles-container">

					<?php foreach ($blogvideos as $blogvideo) { ?>
						<div class="articles-inner item-inner">
							<div class="col col-md-6 col-xs-12">

								<div class="articles-image">
									<video width="320" height="240" controls>
										<source src="<?php echo $blogvideo['url'];?>" type="video/mp4">
				            Your browser does not support the video tag.
				          </video>
								</div>

							</div>

							<div class="col col-md-6 col-xs-12">
								<div class="aritcles-content">

									<p class="articles-name">
										<?php echo $blogvideo['title']; ?>
									</p>

									<div class="articles-intro">
										<?php echo html_entity_decode($blogvideo['short_description'], ENT_QUOTES, 'UTF-8');?>
									</div>

								</div>
							</div>

						</div>
					<?php } ?>

				</div>
			</div>

		<?php } ?>

	</div>
</div>
