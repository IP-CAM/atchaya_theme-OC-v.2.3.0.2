<?php echo $header; ?>

  <div class="container">

    <ul class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php } ?>
    </ul>

    <div class="row">
      <?php echo $column_left; ?>
      <?php if ($column_left && $column_right) { ?>
      <?php $class = 'col-sm-6'; ?>
      <?php } elseif ($column_left || $column_right) { ?>
      <?php $class = 'col-sm-9 col-xs-12'; ?>
      <?php } else { ?>
      <?php $class = 'col-sm-12'; ?>
      <?php } ?>

      <div id="content" class="<?php echo $class; ?>">
        <?php echo $content_top; ?>
          <?php if ($blogvideos) { ?>

            <div class="article-page">

              <?php $i = 0; foreach ($blogvideos as $blogvideo) { $i++;?>

                <div class="article-layout article-list">

                  <div class="article-item <?php echo ($i%2==0) ? 'even' : 'odd'; ?>">

                    <div class="article-item-inner row">

              				<div class="col-sm-4">

                        <video width="320" height="240" controls>
      										<source src="<?php echo $blogvideo['url'];?>" type="video/mp4">
      				            Your browser does not support the video tag.
      				          </video>

              				</div>

                      <div class="article-intro col-sm-8">

                        <div class="article-name">

                          <p>
                            <?php echo $blogvideo['title']; ?>
                          </p>

  				              </div>

                        <div class="intro-content">
                          <?php echo html_entity_decode($blogvideo['short_description'], ENT_QUOTES, 'UTF-8');?>
                        </div>

                        <div class="intro-text">
                          <?php echo html_entity_decode($blogvideo['description'], ENT_QUOTES, 'UTF-8');?>
                        </div>
                        
                        <a class="readmore-page" href="<?php echo 'index.php?route=blog/video_article&video_id='.$blogvideo['id'];?>">
							<?php echo 'Read More'; ?><i class="fa fa-arrow-right" aria-hidden="true"></i>
						</a>

                      </div>
                    </div>
                  </div>
                </div>

              <?php } ?>

            </div>

          <?php } ?>

          <?php echo $content_bottom; ?>
      </div>

      <?php echo $column_right; ?>
    </div>
</div>
<?php echo $footer; ?>
