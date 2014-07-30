<?php class GalleryQuoteWidget extends WP_Widget
{
    function GalleryQuoteWidget(){
		$widget_ops = array( 'description' => 'Displays Gallery slider and quote below' );
		$control_ops = array( 'width' => 400, 'height' => 300 );
		parent::WP_Widget( false, $name='CSR Gallery-Quote Widget', $widget_ops, $control_ops );
    }

	/* Displays the Widget in the front-end */
    function widget( $args, $instance ){
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? 'Gallery' : esc_html( $instance['title'] ) );
		//$imagePath = empty( $instance['imagePath'] ) ? '' : esc_attr( $instance['imagePath'] );
		//$aboutText = empty( $instance['aboutText'] ) ? '' : $instance['aboutText'];
		$blog_category = empty($instance['blog_category']) ? '' : (int) $instance['blog_category'];
		
		echo $before_widget;
		$galleries = get_post_galleries_images( 338 ); // get the url of the image  
		
		//if ( $title )
		echo $before_title . $title . $after_title;
			?>
		
		<div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
				<?php
					foreach( $galleries[0] as $gallery_image ){
						$get_thumb_id = pn_get_attachment_id_from_url($gallery_image); // get the image attachment id from the image url
						$attachment = get_post($get_thumb_id);
						$atr = array(
								'title'	=> $attachment->post_excerpt,
								'class'	=> "nivo-slider-img",
								'alt'   => $attachment->post_title
							);
						echo '<a rel="lightbox[nivo-slider]" href="'.wp_get_attachment_url( $get_thumb_id ).'">';
					    echo wp_get_attachment_image( $get_thumb_id, 'et-portfolio-leader-speak-thumb' , false, $atr); // define the size of the image  
						echo '</a>';
					}  ?> 
					
            </div> 
        </div>
        
	<?php
		echo $after_widget;
	}

	/*Saves the settings. */
    function update( $new_instance, $old_instance ){
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		//$instance['imagePath'] = esc_url( $new_instance['imagePath'] );
		//$instance['aboutText'] = current_user_can('unfiltered_html') ? $new_instance['aboutText'] : stripslashes( wp_filter_post_kses( addslashes($new_instance['aboutText']) ) );
		$instance['blog_category'] = (int) $new_instance['blog_category'];
		return $instance;
	}

	/*Creates the form for the widget in the back-end. */
    function form( $instance ){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title'=>'About Me', 'imagePath'=>'', 'aboutText'=>'' ) );

		$title = esc_attr( $instance['title'] );
		//$imagePath = esc_url( $instance['imagePath'] );
		//$aboutText = esc_textarea( $instance['aboutText'] );
		$blog_category = (int) $instance['blog_category'];
		
		# Title
		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
		# Image
		//echo '<p><label for="' . $this->get_field_id('imagePath') . '">' . 'Image:' . '</label><textarea cols="20" rows="2" class="widefat" id="' . $this->get_field_id('imagePath') . '" name="' . $this->get_field_name('imagePath') . '" >'. $imagePath .'</textarea></p>';
		# Category ?>
		<?php
			$cats_array = get_categories('hide_empty=0');
		?>
		<p>
			<label for="<?php echo $this->get_field_id('blog_category'); ?>">Category</label>
			<select name="<?php echo $this->get_field_name('blog_category'); ?>" id="<?php echo $this->get_field_id('blog_category'); ?>" class="widefat">
				<?php foreach( $cats_array as $category ) { ?>
					<option value="<?php echo esc_attr( $category->cat_ID ); ?>"<?php selected( $instance['blog_category'], $category->cat_ID ); ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>
		<?php
	}

}// end AboutMeWidget class

function GalleryQuoteWidgetInit() {
	register_widget('GalleryQuoteWidget');
}

add_action('widgets_init', 'GalleryQuoteWidgetInit'); ?>