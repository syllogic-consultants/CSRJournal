<?php get_header();
$projectID=get_the_ID();

if ( have_posts() ) {
	$project_lat = get_post_meta( $projectID, '_et_listing_lat', true );
	$project_lng = get_post_meta( $projectID, '_et_listing_lng', true );
	if ( '' == $project_lat && '' == $project_lng ){
		$project_lat=12.980418292307993;
		$project_lng=80.25978098281712;
	}
	$marker_id = $projectID;
}?>
<script type="text/javascript">
 (function($){
    var map;
	var centre = new google.maps.LatLng(21.204847387161795, 79.1172028578171);
	var MY_MAPTYPE_ID = 'Outline';

	function initialize() {
	  var featureOpts = [
		{stylers: [
			{ hue: '#00278A' },
			{ visibility: 'simplified' },
			{ gamma: 0.5 },
			{ weight: 0.9 }
		  ]
		},
		{elementType: 'labels',
		  stylers: [
			{ visibility: 'off' }
		  ]
		},
		{featureType: 'water',
		  stylers: [
			{ color: '#00278A' }
		  ]
		}
	  ];

	  var mapOptions = {
		zoom: 3,
		center: centre,
		mapTypeControlOptions: {
		  mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
		},
		mapTypeId: MY_MAPTYPE_ID,
    	disableDefaultUI: true
	  };
	  
	  map = new google.maps.Map(document.getElementById('mapLocation'),
		  mapOptions);

	  var styledMapOptions = {
		name: 'Outline'
	  };

	  var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);

	  map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
	  sy_add_marker(map, <?php printf( ' %1$d, %2$s, %3$s',$marker_id, $project_lat, $project_lng); ?>);
	}

	function sy_add_marker( map,marker_order, marker_lat, marker_lng){
		var marker_id = 'sy_marker_' + marker_order;
		var image = {
			url: "<?php echo get_stylesheet_directory_uri(); ?>/images/suitcase-white.png",
			// This marker is 20 pixels wide by 32 pixels tall.
			size: new google.maps.Size(20,18),
			// The origin for this image is 0,0.
			origin: new google.maps.Point(0,0),
			// The anchor for this image is the base of the flagpole at 0,32.
			//anchor: new google.maps.Point(0, 32)
		  };
		var myLatLng = new google.maps.LatLng(marker_lat, marker_lng);
		var marker = new google.maps.Marker({
			id : marker_id,
			position: myLatLng,
			map: map,
			icon: image
		});

	}
	google.maps.event.addDomListener(window, 'load', initialize);
})(jQuery)
	</script>

<div id="main-content" class="clearfix fund-my-project">
	<div id="left-area">
		<?php get_template_part('includes/breadcrumbs','single'); ?>
		<div id="entries">
	<?php if ( is_active_sidebar( '468_top_area' ) ) { ?>
		<?php if ( !dynamic_sidebar('468_top_area') ) : ?>
		<?php endif; ?>
	<?php } ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post();
		$location = get_post_meta($projectID, "_et_listing_custom_address", true );
		$description = get_post_meta($projectID, "_et_listing_description", true );
		$projectName = get_post_meta($projectID, "csr_fund_projects_details_contact_name", true );
	?>
		
		<div class="entry post clearfix">
			<?php if (get_option('aggregate_integration_single_top') <> '' && get_option('aggregate_integrate_singletop_enable') == 'on') echo(get_option('aggregate_integration_single_top')); ?>

			<h1 class="title"><?php the_title(); ?></h1>
			<?php get_template_part('includes/postinfo','single'); ?>

			<?php if (get_option('aggregate_thumbnails') == 'on') { ?>
				<?php
					$thumb = '';
					$width = 200;
					$height = 200;
					$classtext = 'single-medium';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Entry');
					$thumb = $thumbnail["thumb"];
				?>

				<?php if($thumb <> '') { ?>
					<div class="thumb">
						<div id="mapLocation" class="gmap3"></div>
						<?php //print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
						<?php echo get_the_post_thumbnail($projectID, 'thumbnail-fmp'); ?>
						<!--span class="overlay"></span-->
						
						<div class="location_decription">
							<p><?php echo $description ?>, <?php echo $location ?></p>
						</div>
					</div> 	<!-- end .thumb -->
				<?php } ?> 
			<?php } ?>
            <div class="fund-content">
            <h4> Project by: <?php echo $projectName; ?></h4>
			<?php the_content(); ?>
			</div> <!-- end fund-content -->
			<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Aggregate').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php edit_post_link(esc_html__('Edit this page','Aggregate')); ?>
		</div> <!-- end .entry -->

		<?php if (get_option('aggregate_integration_single_bottom') <> '' && get_option('aggregate_integrate_singlebottom_enable') == 'on') echo(get_option('aggregate_integration_single_bottom')); ?>

		<?php if (get_option('aggregate_468_enable') == 'on') { ?>
				  <?php if(get_option('aggregate_468_adsense') <> '') echo(get_option('aggregate_468_adsense'));
				else { ?>
				   <a href="<?php echo esc_url(get_option('aggregate_468_url')); ?>"><img src="<?php echo esc_url(get_option('aggregate_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
		   <?php } ?>
		<?php } ?>

		<?php if (get_option('aggregate_show_postcomments') == 'on') comments_template('', true); ?>
	<?php endwhile; // end of the loop. ?>

	<?php if ( is_active_sidebar( '468_bottom_area' ) ) { ?>
		<?php if ( !dynamic_sidebar('468_bottom_area') ) : ?>
		<?php endif; ?>
	<?php } ?>
</div> <!-- end #entries -->
	</div> <!-- end #left-area -->
	<?php get_sidebar(); ?>
<?php get_footer(); ?>