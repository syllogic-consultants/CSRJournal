<div id="sidebar">
	<?php
		  if( is_post_type_archive( 'fund_project' ) || is_singular( 'fund_project' )  ){
	?>
			<div class="fmp-logo">
				<img class="single-thumb" alt="Why India Needs A CSR Index" src="<?php echo  site_url('/wp-content/uploads/2014/06/logo-fund_my_project2-140x170.png'); ?>" />
				<span class="overlay"></span>
				<p>The CSR Journal's ready reckoner of impactful social works undertaken by individuals and organisations who are looking for funding under CSR guidelines. If you’re a corporate or a philanthropist looking to fund a project, this section has all you need to know about it.</p>
			</div>
	<?php		
		}
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : 
		endif; 
	?>
</div> <!-- end #sidebar -->