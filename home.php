<?php get_header(); ?>

<?php if ( is_home() && get_option('aggregate_featured') == 'on' ) get_template_part('includes/featured','home'); ?>

<?php if ( is_active_sidebar( 'homepage-recentfrom-area-1' ) || is_active_sidebar( 'homepage-recentfrom-area-2' ) || is_active_sidebar( 'homepage-recentfrom-area-3' ) ) { ?>
	<?php if ( is_active_sidebar( 'homepage-recentfrom-area-1' ) && !dynamic_sidebar('homepage-recentfrom-area-1') ) : ?>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'homepage-recentfrom-area-2' ) && !dynamic_sidebar('homepage-recentfrom-area-2') ) : ?>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'homepage-recentfrom-area-3' ) && !dynamic_sidebar('homepage-recentfrom-area-3') ) : ?>
	<?php endif; ?>

	<div class="clear"></div>
<?php } ?> 
	<div id="home-quote" >
		<?php 
				$args = array(
								'post_type' => 'post',
								'cat' => '46',
								'posts_per_page' => 1,
								);
			$myposts = query_posts( $args ); 
			if (have_posts()):
				the_post();
				$content = get_the_content();
				$trim_content = wp_trim_words( $content, 240, '...<a href="'. get_permalink() .'"> Read More</a>' );
				?>
				<p class="dashicons-admin-plugins">
					<?php echo $trim_content; ?>
				</p>
				<p class="right-align"><strong><?php the_title(); ?></strong></p>
			<?php
			endif;
			 wp_reset_query();
		?>
        	
	</div>

<div id="main-content" class="clearfix home-main">
	<div id="left-area">
		<h4 class="main-title"><?php esc_html_e('In Other News','Aggregate'); ?></h4>
		<div id="entries">
			<?php get_template_part('includes/entry','home'); ?>
			
		</div> <!-- end #entries -->
	</div> <!-- end #left-area -->

	<?php if ( is_active_sidebar( 'homepage-sidebar' ) ) { ?>
		<div id="sidebar">
			<?php if ( !dynamic_sidebar('homepage-sidebar') ) : ?>
			<?php endif; ?>
		</div> <!-- #sidebar -->
	<?php } else { ?>
		<?php get_sidebar(); ?>
	<?php } ?>
<?php get_footer(); ?>