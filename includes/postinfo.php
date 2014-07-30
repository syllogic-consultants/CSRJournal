<?php 
if(!is_front_page()){
if (!is_single() && get_option('aggregate_postinfo1') ) { 
?>
	<p class="meta-info">
	<?php
	
	if (in_array('author', get_option('aggregate_postinfo1'))) {
	esc_html_e('By ','Aggregate'); 
	the_author_posts_link(); 
	} ; ?> </p>
	
<?php } elseif (is_single() && get_option('aggregate_postinfo2') ) { 
		global $post;
?>
	<div class="post-meta">
		<div class="post-meta-separator">
			<p class="meta-info">
				<?php	
					if (in_array('author', get_option('aggregate_postinfo2'))) {
						global $post;
						$author_id=$post->post_author;
						$photourl= get_cimyFieldValue( $author_id, "PROFILEPHOTO"); 
						$gravatar_url = gravatar_url($author_id, 100);
						$description = get_the_author_meta('description', $author_id);
						$trimmed_description = wp_trim_words( $description, 180, '<a href="'. get_author_posts_url( $author_id) .'"> Read More</a>' ); 
		
						echo '<div class="user-info">';
					if( $trimmed_description != '' &&  ($photourl != '' || $gravatar_url != '') ){ echo '<span class="user-name">'; }
						esc_html_e('By ','Aggregate');
						the_author_posts_link(); 
					if( $trimmed_description != '' &&  ($photourl != '' || $gravatar_url != '') ){ echo '</span>'; }
			
					}  ; ?>
		
				<?php
					if (in_array('categories', get_option('aggregate_postinfo2'))) { 
						esc_html_e(' in ','Aggregate');
						switch ( get_post_type($post) ){
							case 'fund_project': 
								echo get_the_term_list( $post->ID, 'csr_fund_my_projects_categories', '', ', ', '' ); 
								break;
							default:
								the_category(', ');
								break;
						}
					}; 
		
					if( $trimmed_description != '' &&  ($photourl != '' || $gravatar_url != '') ){
				?>
		
					<div class="user-bio-image">
						<img  src="<?php if( $gravatar_url == '') echo  $photourl;  else  echo  $gravatar_url;  ?>"  />
					</div>
					<div class="user-bio"><p><?php if( $trimmed_description != '') echo  $trimmed_description;?></p></div>
					</p> 
				<?php
					}else{
						echo '</p>';
				} ?>
			</div>
		</div>	<!-- end .post-meta-separator -->
	</div> <!-- end .post-meta -->
<?php }
}; 
?>