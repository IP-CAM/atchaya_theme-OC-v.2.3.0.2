<div class="container">
	<div class="row">
		<?php
			if ($blogvideos) {
				foreach ($blogvideos as $blogvideo) {
		?>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="organic_blog">
					<a href="#" class="img_video">
						<video width="100%" height="270" controls>
							<source src="<?php echo $blogvideo['url'];?>" type="video/mp4">
							Your browser does not support the video tag.
						</video>
					</a>
					<div class="single_blog_details">
						<h3><?php echo $blogvideo['title']; ?></h3>
						<ul class="date_username">
							<li>
								<p>
									<i class="fa fa-calendar" aria-hidden="true"></i>
									<?php echo $blogvideo['created_at'];?>
								</p>
							</li>
							<li>
								<p>
									<i class="fa fa-user" aria-hidden="true"></i>
									<?php echo $blogvideo['author'];?>
								</p>
							</li>
						</ul>
						<p>
							<?php echo $blogvideo['short_description'];?>
						</p>
						<a href="<?php echo $blogvideo['href'];?>" class="read_more">Read More</a>
					</div>
				</div>
			</div>
		<?php }}?>
	</div>
</div>
