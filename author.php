<?php

get_header();


 ?>

<div id="main-content" class="clearfix">

<?php

    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    // echo "<pre>", print_r($curauth),"</pre>";
	$cur_title = get_cimyFieldValue($curauth->ID, CSR_TITLE); ?>

		<div id="left-area">
		     <div id="entries">
					<h1 class="title"><?php echo $curauth->display_name;  ?></h2>
						<p><i><?php echo  $cur_title; ?></i></p>
							<?php 
							$photourl= get_cimyFieldValue($curauth->ID, "PROFILEPHOTO");
							$thumb_url = cimy_get_thumb_path($photourl);
							$gravatar_url = gravatar_url($curauth->ID, 256);
						
            					$thumb = '';
            					$width = 200;
            					$height = 200;
            					$classtext = 'single-thumb';
            					$titletext = get_the_title();
            					$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Entry');
            					$thumb = $thumbnail["thumb"];
            				?>

            			
            				<?php
							echo '						<div class="thumb_user">';
							if ( $photourl!=null && $gravatar_url==null) {?>
										<img  src="<?php echo $thumb_url; ?>" width="256" height="auto"/>
										<span class="overlay"></span>
								  
							  <?php } else { 
								if($gravatar_url==null)	echo get_avatar( $curauth->ID, 256 );
								else echo '<img  src="'.$gravatar_url.'" width="256" height="auto"/>';
							            echo '<span class="overlay"></span>';
							  } 
							  echo "</div>";
							  echo  "<p class='user_desc' >".$curauth-> description . "</p>";
							    
							?>
		               

				</div> <!-- end #entries -->
			</div> <!-- #left-area -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>