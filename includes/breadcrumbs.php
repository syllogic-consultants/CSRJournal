<div id="breadcrumbs">
	<?php if(function_exists('bcn_display')) { bcn_display(); }
		  else {
		  	global $post;
		  	?>
		  	
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','Aggregate') ?></a> <span class="raquo">&raquo;</span>

				<?php if( is_tag() ) { ?>
					<?php esc_html_e('Posts Tagged ','Aggregate') ?><span class="raquo">&quot;</span><?php single_tag_title(); echo('&quot;'); ?>
				<?php } elseif (is_day()) { ?>
					<?php esc_html_e('Posts made in','Aggregate') ?> <?php the_time('F jS, Y'); ?>
				<?php } elseif (is_month()) { ?>
					<?php esc_html_e('Posts made in','Aggregate') ?> <?php the_time('F, Y'); ?>
				<?php } elseif (is_year()) { ?>
					<?php esc_html_e('Posts made in','Aggregate') ?> <?php the_time('Y'); ?>
				<?php } elseif (is_search()) { ?>
					<?php esc_html_e('Search results for','Aggregate') ?> <?php the_search_query() ?>
				<?php } elseif (is_single()) {
						switch ( get_post_type($post) ){
						 case 'fund_project': 
							$category = get_the_terms($post->ID, 'csr_fund_my_projects_categories');
							$first_term = reset($category);
						  	$catlink = get_term_link( $first_term );
						  	echo ('<a href="'.esc_url($catlink).'">'.esc_html($first_term->name).'</a> '.'<span class="raquo">&raquo;</span> '.get_the_title());
						  	break;
						  default:
						  	$category = get_the_category();
							//echo $category;
						  	$catlink = get_category_link( $category[0]->cat_ID );
						  	echo ('<a href="'.esc_url($catlink).'">'.esc_html($category[0]->cat_name).'</a> '.'<span class="raquo">&raquo;</span> '.get_the_title());
						  	break;
						}
					} elseif (is_category()) { ?>
					<?php single_cat_title(); ?>
				<?php } elseif (is_author()) { ?>
				<?php
					global $wp_query;
					$curauth = $wp_query->get_queried_object();
					esc_html_e('Posts by ','Aggregate'); echo ' ',$curauth->nickname;
				?>
				<?php } elseif (is_page()) { ?>
					<?php wp_title(''); ?>
				<?php }; ?>
	<?php }; ?>
</div> <!-- end #breadcrumbs -->