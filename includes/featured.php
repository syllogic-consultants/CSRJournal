<?php
	$responsive = 'on' != get_option('aggregate_responsive_layout') ? false : true;
	$featured_auto_class = '';
	if ( 'on' == get_option('aggregate_slider_auto') ) $featured_auto_class .= ' et_slider_auto et_slider_speed_' . get_option('aggregate_slider_autospeed');
?>
<div id="featured" class="<?php if ( $responsive ) echo esc_attr( 'flexslider' . $featured_auto_class ); else echo 'et_cycle'; ?>">
	<a id="left-arrow" href="#"><?php esc_html_e('Previous','Aggregate'); ?></a>
	<a id="right-arrow" href="#"><?php esc_html_e('Next','Aggregate'); ?></a>

<?php if ( $responsive ) { ?>
	<ul class="slides">
<?php } else { ?>
	<div id="slides">
<?php } ?>
		<?php
		$arr = array();
		$i=0;

		$featured_cat = get_option('aggregate_feat_cat');
		$featured_num = (int) get_option('aggregate_featured_num');
			
		if (get_option('aggregate_use_pages') == 'false'){
			$featured_page_args = array(
				'post_type' => 'post',
				'orderby' => 'date',
				'order' => 'DESC',
				'posts_per_page' => (int) $featured_num,
				'cat' => get_catId($featured_cat)
			);
		 query_posts($featured_page_args);
		}else {
			global $pages_number;
			if (get_option('aggregate_feat_pages') <> '') $featured_num = count(get_option('aggregate_feat_pages'));
			else $featured_num = $pages_number;

			$featured_page_args = array(
				'post_type' => 'page',
				'orderby' => 'date',
				'order' => 'DESC',
				'posts_per_page' => (int) $featured_num,
			);

			if ( is_array( et_get_option( 'aggregate_feat_pages', '', 'page' ) ) )
				$featured_page_args['post__in'] = (array) array_map( 'intval', et_get_option( 'aggregate_feat_pages', '', 'page' ) );

			query_posts( $featured_page_args );
		}
		?>
		<?php if (have_posts()) : while (have_posts()) : the_post();
		global $post; 
		//echo get_the_ID().'<br/>';
		?>
		<?php 
		$totalpostcount =0;
		if ( $responsive ) { ?>
			<li class="slide">
		<?php } else { ?>
			<div class="slide">
		<?php } ?>
				<?php
			//	echo get_the_ID();
				$width = $responsive ? 960 : 958;
				$height = 340;
				$small_width = 95;
				$small_height = 54;
				$postID = get_the_ID();
				$titletext = get_the_title();

				$thumbnail = get_thumbnail($width,$height,'',$titletext,$titletext,false,'Featured');

				$arr[$i]['thumbnail'] = get_thumbnail($small_width,$small_height,'',$titletext,$titletext,false,'Small');
				$imageSrc = wp_get_attachment_image_src(get_post_thumbnail_id($postID), 'et-featured-slider-small-thumb',true);
				//print_r($imageSrc);
				$arr[$i]['url'] = $imageSrc[0];
				$arr[$i]['titletext'] = $titletext;

				$arr[$i]['post_id'] = $postID;

				$thumb = $thumbnail["thumb"];
				print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, ''); ?>
				<div class="featured-top-shadow"></div>
				<div class="featured-bottom-shadow"></div>
				<div class="featured-description">
					<div class="feat_desc">
						<h2 class="featured-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo get_the_excerpt(); ?></p>
					</div>
					<a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e('Read More', 'Aggregate'); ?></a>
				</div> <!-- end .description -->
		<?php if ( $responsive ) { ?>
			</li> <!-- end .slide -->
		<?php } else { ?>
			</div> <!-- end .slide -->
		<?php } ?>
		<?php $i++; endwhile; 
		endif; 
		$featured_project_num = 0;
		if ($featured_num > $i)  $featured_project_num = $featured_num - $i;
		//echo $featured_project_num;
		wp_reset_query(); 
		// let's get the fund my project slides
		
		$featured_page_args = array(
				'post_type' => 'fund_project',
				'orderby' => 'date',
				'order' => 'DESC',
				'posts_per_page' => -1,
				'csr_fund_my_projects_categories' => 'lead-projects'
			);
		 $fmp_query = new WP_Query($featured_page_args);
		 //if( $fmp_query->have_posts() ) echo 'got projects';
      	
    	if( $fmp_query->have_posts() ) : while ($fmp_query->have_posts()) : $fmp_query->the_post(); 
      	
			if ( $responsive ) {
		//	echo  get_the_ID();
			?>
				<li class="slide">
			<?php } else { ?>
				<div class="slide">
			<?php } ?>
					<?php
				//	echo get_the_ID();
					$width = $responsive ? 960 : 958;
					$height = 340;
					$small_width = 95;
					$small_height = 54;
					$postID = get_the_ID();
					$titletext = get_the_title();
					$imageSrc = wp_get_attachment_image_src(get_post_thumbnail_id($postID), 'et-featured-slider-small-thumb',true);
					$arr[$i]['url'] = $imageSrc[0];
					$arr[$i]['titletext'] = $titletext;

					$arr[$i]['post_id'] = $postID;
				
					$imageSrc = wp_get_attachment_image_src(get_post_thumbnail_id($postID), 'et-featured-slider-large-thumb',true);
					
					//$thumbnail = get_thumbnail($width,$height,'',$titletext,$titletext,false,'Featured');
					//echo $titletext;
					//$thumb = $thumbnail["thumb"];
					//print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, ''); ?>
					<img width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="<?php echo $titletext; ?>" src="<?php echo $imageSrc[0]; ?>">
					<div class="featured-top-shadow"></div>
					<div class="featured-bottom-shadow"></div>
					<div class="featured-description">
						<div class="feat_desc">
							<!-- p class="meta-info"><?php esc_html_e('By','Aggregate'); ?> <?php the_author_posts_link(); ?></p -->
							<h2 class="featured-title"><a href="<?php the_permalink(); ?>"><?php echo $titletext; ?></a></h2>
							<p><?php echo get_the_excerpt(); ?></p>
						</div>
						<a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e('Read More', 'Aggregate'); ?></a>
					</div> <!-- end .description -->
			<?php if ( $responsive ) { ?>
				</li> <!-- end .slide -->
			<?php } else { ?>
				</div> <!-- end .slide -->
			<?php } ?>
			<?php $i++; endwhile; 
			$totalpostcount=$i;
    	endif;
    	wp_reset_query();
 if ( $responsive ) { ?>
	</ul> <!-- end .slides -->
<?php } else { ?>
	</div> <!-- end #slides -->
<?php }
 ?>
</div> <!-- end #featured -->

<div id="controllers" class="clearfix">
	<ul>	
		<?php
		if($totalpostcount > 0){
			for ($i = 0; $i < $totalpostcount; $i++) { 		
			// echo get_the_ID();
			//echo "<pre>",print_r($arr[$i]['post_id']),"</pre>"; 
		?>
				<li>
					<div class="controller">
						<a href="#"<?php if ( $i == 0 ) echo ' class="active"'; ?>>
							<img width="<?php echo $small_width; ?>" height="<?php echo $small_height; ?>" alt="<?php echo $arr[$i]["titletext"]; ?>" src="<?php echo $arr[$i]["url"]; ?>">
							<span class="overlay"></span>
						</a>
					</div>
				</li>
			<?php } 
		}?>
	</ul>
	<div id="active_item"></div>
</div> <!-- end #controllers -->