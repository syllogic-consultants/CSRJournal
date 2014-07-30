<?php
get_header();
/*
Template Name: Author Page
*/
 ?>
<div id="main-content" class="clearfix">
<?php
	$args = array( 'orderby' => 'display_name', 'order' => 'ASC', 'who' => 'authors' );
	$users = get_users( $args );
	$roles = array(0=>'editor',1=>'author',2=>'contributor');
	//echo "<pre>", print_r($authors),"</pre>";
	//die;
    for($cnt=0;$cnt<count($roles);$cnt++){	
		for ( $i = 0; $i < count( $users ); ++$i ) {
			$curauth = $users[$i];
			if( $curauth->roles[0] == $roles[$cnt]){
				$curautharray[] = $curauth;
	        } 
        }
    }
	for ( $h = 0; $h < count( $curautharray ); ++$h ) {
    // echo "<pre>", print_r($curauth),"</pre>";
		$auth = $curautharray[$h];
		$content =wp_trim_words(  $auth-> description, 100, '<a href="'.  get_author_posts_url( $auth->ID) .'"> Read More</a>' );
		$cur_title = get_cimyFieldValue($auth->ID, CSR_TITLE); ?>
		 <div id="left-area-user" style="margin-left:15px;">
		     <div id="entries" style="padding:5px 0px;">
				<!--	<h1 class="title"><?php #echo $auth->display_name;  ?></h2> -->
					<h1 class="title"><a href="<?php echo  get_author_posts_url( $auth->ID) ?>"><?php echo $auth->display_name;  ?></a></h2>
						<p><i><?php echo  $cur_title; ?></i></p>
            				<?php
							echo '						<div class="thumb_user_grid">';
							if ( $photourl!=null && $gravatar_url==null) {?>
										<img  src="<?php echo $thumb_url; ?>" width="256" height="auto"/>
										<span class="overlay"></span>
								  
							  <?php } else { 
								if($gravatar_url==null)	echo get_avatar( $auth->ID, 256 );
								else echo '<img  src="'.$gravatar_url.'" width="256" height="auto"/>';
							            echo '<span class="overlay"></span>';
							  } 
							  echo "</div>";
							  echo  "<p class='user_desc' >".$content . "</p>";
  							  ?>
			 </div> <!-- end #entries -->
		</div> <!-- end #entries -->
<?php 
 }
  ?>
<?php get_footer(); ?>