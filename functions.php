<?php
/*--------------
  Functions that are specific to Explorable-Child as implemented for TGPI
----------------*/
/* Disable WordPress Admin Bar for all users but admins. */
add_filter('show_admin_bar', '__return_false');

include(STYLESHEETPATH . '/includes/widgets/widget-gallery-quote.php');
// MODIFY EDITOR: Enable font size & font family selects in the editor
add_filter( 'mce_buttons_2', 'wpex_mce_buttons' );
if ( ! function_exists( 'wpex_mce_buttons' ) ) {
	function wpex_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'fontselect' ); // Add Font Select
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		return $buttons;
	}
}
// Customize mce editor font sizes
add_filter( 'tiny_mce_before_init', 'wpex_mce_text_sizes' );
if ( ! function_exists( 'wpex_mce_text_sizes' ) ) {
	function wpex_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
		return $initArray;
	}
}
// Add custom Fonts to the Fonts list
add_filter( 'tiny_mce_before_init', 'wpex_mce_google_fonts_array' );
if ( ! function_exists( 'wpex_mce_google_fonts_array' ) ) {
	function wpex_mce_google_fonts_array( $initArray ) {
	    $initArray['font_formats'] = 'Lato=Lato;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';
            return $initArray;
	}
}

// Add additional Styles for the visual editor? 
add_editor_style( 'custom-editor-style.css' );

/* function to quickly access the root domain and verify if localhosted*/
function csr_get_domain_name(){
	$domain_name =  preg_replace('/^www\./','',$_SERVER['SERVER_NAME']);
	return $domain_name; 
}

/*add WP 3.8 dashicons for use in css*/
function csrJournal_theme_scripts() {
	wp_enqueue_style( 'themename-style', get_stylesheet_uri(), array( 'dashicons' ), '1.0' );
	wp_enqueue_style( 'nivo-slider-style', get_stylesheet_directory_uri().'/css/nivo-slider.css', array( 'nivo-theme-style' ), '1.0' );
	//wp_enqueue_style( 'nivo-theme-style', get_stylesheet_directory_uri().'/css/bar/bar.css', array(), '1.0' );
	//wp_enqueue_style( 'nivo-theme-style', get_stylesheet_directory_uri().'/css/dark/dark.css', array(), '1.0' );
	//wp_enqueue_style( 'nivo-theme-style', get_stylesheet_directory_uri().'/css/light/light.css', array(), '1.0' );
	wp_enqueue_style( 'nivo-theme-style', get_stylesheet_directory_uri().'/css/default/default.css', array(), '1.0' );

}
add_action( 'wp_enqueue_scripts', 'csrJournal_theme_scripts' );

//enqueue topbar js
function csr_javascript() {
	if ( !wp_is_mobile() )  wp_enqueue_script( 'topbarjs', get_stylesheet_directory_uri().'/js/topbar.js', array('jquery'), null, true );
	 wp_enqueue_script( 'nivo-silder', get_stylesheet_directory_uri().'/js/jquery.nivo.slider.js', array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'csr_javascript' );

//add slider initialisation to footer
function nivo_home_widget_slider(){ 
    $layout = get_theme_mod( 'featured_content_layout' );
     ?>
	<script type="text/javascript">
    jQuery( window ).load( function() {
        jQuery('#slider').nivoSlider();
    });
    </script>
	<?php 
} 
//if(is_front_page()){
add_action('wp_footer', 'nivo_home_widget_slider');
//}
/**
* Utility function to check if a gravatar exists for a given email or id
* @param int|string|object $id_or_email A user ID, email address, or comment object
* @return bool if the gravatar exists or not
*/
 
function gravatar_url($id_or_email, $size) {
	if ($size==null) $size= 96;
	//id or email code borrowed from wp-includes/pluggable.php
	$email = '';
	if ( is_numeric($id_or_email) ) {
	$id = (int) $id_or_email;
	$user = get_userdata($id);
	if ( $user )
	$email = $user->user_email;
	} elseif ( is_object($id_or_email) ) {
	// No avatar for pingbacks or trackbacks
	$allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
	if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) )
	return false;
	 
	if ( !empty($id_or_email->user_id) ) {
	$id = (int) $id_or_email->user_id;
	$user = get_userdata($id);
	if ( $user)
	$email = $user->user_email;
	} elseif ( !empty($id_or_email->comment_author_email) ) {
	$email = $id_or_email->comment_author_email;
	}
	} else {
	$email = $id_or_email;
	}
	 
	$hashkey = md5(strtolower(trim($email)));
	$uri = 'http://www.gravatar.com/avatar/' . $hashkey . '?d=404';
	 
	$data = wp_cache_get($hashkey);
	if (false === $data) {
	$response = wp_remote_head($uri);
	if( is_wp_error($response) ) {
	$data = 'not200';
	} else {
	$data = $response['response']['code'];
	}
	wp_cache_set($hashkey, $data, $group = '', $expire = 60*5);
	 
	}
	//print_r($response);
	if ($data == '200'){
		return 'http://www.gravatar.com/avatar/' . $hashkey . '?s='.$size;
	} else {
		return null;
	}
}

function get_avatar_url($get_avatar){
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
}




/* Short code for editorial team */

function csrUserName_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'ID' => '1',
		'email' => '',
	), $atts ) );
	$user = null;
	if($email != '') $user = get_user_by('email',$email);
	if(is_null($user)) $user = get_user_by('id',$ID);
	if(is_null($user)) return "No User found";
	return "{$user->first_name} {$user->last_name}";
}
add_shortcode( 'csrUserName', 'csrUserName_shortcode' );

// [syUserBio ID="id" email="" ]
function csrUserBio_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'ID' => '1',
		'email' => '',
	), $atts ) );
	$user = null;
	if($email != '') $user = get_user_by('email',$email);
	if(is_null($user)) $user = get_user_by('id',$ID);
	if(is_null($user)) return "No User found";
	return "<p>{$user->description}</p>";
}
add_shortcode( 'csrUserBio', 'csrUserBio_shortcode' );

// [syUserinfo ID="id"] for editorial page
function csrUserinfo_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'ID' => '1',
		'email' => '',
	), $atts ) );
	$user = null;
	if($email != '') $user = get_user_by('email',$email);
	if(is_null($user)) $user = get_user_by('id', $ID);
	if(is_null($user)) return "No User found";
	$photourl= get_cimyFieldValue( $user->id, "PROFILEPHOTO");
	$title = get_cimyFieldValue($user->id, "CSR_TITLE");
	return "<div class='left-area-user'><h4>{$user->first_name} {$user->last_name}</h4><h6>$title</h6><p></p> <img class='et-waypoint et_pb_image et_pb_animation_left et-animated' src=' $photourl' /><p></p><p>{$user->description}</p></div>";
}
add_shortcode( 'csrUserinfo', 'csrUserinfo_shortcode' );

function et_load_gmap_scripts(){
	 $queried_post_type = get_query_var('post_type');
    //we need Google Maps Api for the Project single template
    if ( is_single() && 'fund_project' ==  $queried_post_type ) {
        wp_enqueue_script( 'google-maps-api', 'https://maps.googleapis.com/maps/api/js?sensor=false', array( 'jquery' ), '' , false );
        wp_enqueue_script( 'google-maps3', get_stylesheet_directory_uri() . '/js/gmap3.js', array( 'jquery','google-maps-api' ), '' , false );
    }
	
}
add_action( 'wp_enqueue_scripts', 'et_load_gmap_scripts' );

function pn_get_attachment_id_from_url( $attachment_url = '' ) {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id;
}
/*
//set the default category of the custom post
function mfields_set_default_object_terms( $post_id, $post ) {
    if ( 'publish' === $post->post_status ) { 
        $defaults = array( 
            'csr_fund_my_projects_categories' => array( 30 ), //set the taxonomy and tag ID    
            );
        $taxonomies = get_object_taxonomies( $post->post_type ); // check the object of term ( tags or category )
        foreach ( (array) $taxonomies as $taxonomy ) {
            $terms = wp_get_post_terms( $post_id, $taxonomy );
            if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
                wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy ); //if term is not set declare the default term
            }
        }
    }
}
add_action( 'save_post', 'mfields_set_default_object_terms', 100, 2 );  
*/
?>