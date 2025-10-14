<?
# include ccsdtv functions
include('/www/apache/htdocs/ccsd/_api/ccsdtv/ccsdtv-plugin.php');

# get videos for news channel
$video_list = getVideos('channel', 'News', 'newest', 1, 'image', 10, true);
$video_list = array_slice($video_list, 0, 4);
?>
<div id="newsbox_wrap" class="newsbox-wrap" role="ccsd news">
	<div class="newsbox-nav-wrap">
		<h2 class="section-title">CCSD News</h2>
		<ul class="newsbox-list">
			<li id="newsbox_item_art" class="newsbox-item">
				<div class="newsbox-item-title newsbox-item-title-active">Articles</div>
				<div class="newsbox-content-wrap">
					<?
					$nb_limit = 4;
					
					# place news articles into an array
					$news_list = get_ccsd_news_and_events(NULL,$nb_limit);
					foreach($news_list AS $key => $news_item) {
						$news_article[] = $news_item;					
					}
					?>
					<!-- left pane -->
					<div style="width: 270px; float: left; padding: 10px;">
						<article style="background-color: #fff; padding: 10px;" class="round-5">
							<h6 class="nb-top-header" role="Headings and Labels"><a href="/district/news/<?=$news_article[0]['unique_url'];?>"><?=$news_article[0]['title']?></a></h6>
							<!-- <div><?=$news_article[0]['description']?></div> -->
						</article>
					</div>
					
					
					<!-- right pane -->
					<div style="width: 330px; float: right; padding: 10px;">
						<? for($i=1;$i<$nb_limit;$i++) { ?>
							<article style="margin-bottom: 5px;background-color: #fff; padding: 10px;" class="round-5">
								<h6 class="nb-headers"><a href="/district/news/<?=$news_article[$i]['unique_url'];?>"><?=$news_article[$i]['title']?></a></h6>
							</article>
						<? } ?>
					</div>
					
					<div class="text-right clear-both"><a href="/district/news/">More articles</a></div>
				</div>
				
			</li>
			<li id="newsbox_item_vid" class="newsbox-item">
				<div class="newsbox-item-title">Videos</div>
				<div class="newsbox-content-wrap" style="display: none;">
					<!-- <div class="video-section-subtitle">via <a href="http://tv.ccsd.net/" target="_blank">tv.ccsd.net</a></div> -->
					<?
					# build video list array
					foreach($video_list AS $key => $video_item) {
						$news_video[] = $video_item;
						//echo '<div id="student_videos" class="ccsdtv-api" data-label="CCSD News Videos" data-tags=""></div>';
						echo 
						'<div class="nb-video-item-info">
								<a href="#">
									<img width="125" src="/_static/images/transparent.gif" style="background: transparent url(http://tv.ccsd.net/media/'.$video_item['MEDIA_DIR'].'/'.$video_item['SERIAL'].'/'.$video_item['THUMBNAIL'].') center top no-repeat" />
									<span>'.$video_item['TITLE'].'</span>
								</a>
							</div>';
					}
					?>
					
				</div>
			</li>
			<li id="newsbox_item_blog" class="newsbox-item">
				<div class="newsbox-item-title">MyCCSD Blogs</div>
				<div class="newsbox-content-wrap" style="display: none;">
					testing content 3
				</div>
			</li>
		</ul>
	</div>
</div><!-- / news_wrap -->