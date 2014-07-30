<?php get_header(); ?>

<div id="main-content" class="clearfix">
	<div id="left-area">
		<?php get_template_part('includes/breadcrumbs'); ?>
		<div id="entries">
			<?php 
				if ( is_active_sidebar( '468_top_area' ) ) {
					if ( !dynamic_sidebar('468_top_area') ) : 
					endif; 
				} 
					global $paged;
					$i = 0;
					if (have_posts()) : while (have_posts()) : the_post();		
						$i++;
						$et_is_latest_post = ( $paged == 0 && ( is_home() && $i <= 2 ) ) || !is_home();
					?>
						<div class="post entry clearfix<?php if ( $et_is_latest_post ) echo ' latest'; ?>">
							<?php
								$thumb = '';
								$width = $et_is_latest_post ? 130 : 67;
								$height = $et_is_latest_post ? 130 : 67;
								$classtext = 'post-thumb';
								$titletext = get_the_title();
								$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Entry');
								$thumb = $thumbnail["thumb"];
							    if($thumb <> '' && get_option('aggregate_thumbnails_index') == 'on') { ?>
								<div class="thumb">
									<a href="<?php the_permalink(); ?>">
										<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
										<span class="overlay"></span>
									</a>
								</div> 	<!-- end .post-thumbnail -->
							<?php } ?>
							<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php get_template_part('includes/postinfo'); 
							if (get_option('aggregate_blog_style') == 'on') the_content(''); else { 
									$et_excerpt_length = $et_is_latest_post && is_home() ? 215 : 80;
									if ( !is_home() ) $et_excerpt_length = 140;
								?>
								<p><?php truncate_post($et_excerpt_length); ?></p>
							<?php }; ?>
							<a href="<?php the_permalink(); ?>" class="more"><span><?php esc_html_e('Read More','Aggregate'); ?></span></a>
						</div> 	<!-- end .post-->
				<?php endwhile;
						if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
						else { 
							get_template_part('includes/navigation','entry'); 
						} 
					else : 
					 get_template_part('includes/no-results','entry'); 
				endif;
			if ( is_active_sidebar( '468_bottom_area' ) ) { 
				 if ( !dynamic_sidebar('468_bottom_area') ) : 
				 endif; 
			} ?>
		</div> <!-- end #entries -->
	</div> <!-- end #left-area -->
	<?php get_sidebar(); ?>

<?php get_footer(); ?>