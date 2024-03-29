										<?php if ( !is_home() ) echo '<div id="index-top-shadow"></div>'; ?>
									</div> <!-- end #main-content -->

									<?php if ( is_home() ) { ?>
										<div id="additional-widgets" class="clearfix">
											<?php if ( is_active_sidebar( 'bottom-area-1' ) || is_active_sidebar( 'bottom-area-2' ) || is_active_sidebar( 'bottom-area-3' ) ) { ?>
												<?php if ( is_active_sidebar( 'bottom-area-1' ) && !dynamic_sidebar('bottom-area-1') ) : ?>
												<?php endif; ?>

												<?php if ( is_active_sidebar( 'bottom-area-2' ) && !dynamic_sidebar('bottom-area-2') ) : ?>
												<?php endif; ?>

												<?php if ( is_active_sidebar( 'bottom-area-3' ) && !dynamic_sidebar('bottom-area-3') ) : ?>
												<?php endif; ?>
											<?php } ?>
										</div> <!-- end #additional-widgets -->
									<?php } ?>
								</div> <!-- end #content-bottom-shadow -->
							</div> <!-- end #content-top-shadow -->
						</div> <!-- end #content-shadow -->
					</div> <!-- end #inner-border -->
				</div> <!-- end #content -->

				<?php if ( is_active_sidebar( '728area' ) ) { ?>
					<?php if ( !dynamic_sidebar('728area') ) : ?>
					<?php endif; ?>
				<?php } ?>

			</div> <!-- end .container -->
		</div> <!-- end #content-top-light -->
		<div id="bottom-stitch"></div>
	</div> <!-- end #content-area -->

	<div id="footer">
		<div id="footer-top-shadow" class="clearfix">
			<div class="container">
				<div id="footer-widgets" class="clearfix">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
					<?php endif; ?>
				</div> <!-- end #footer-widgets -->
				<p id="copyright"><?php esc_html_e('Designed by ','Aggregate'); ?> <a href="http://syllogic.in" title="Enabling Sustainable Growth">Syllogic Consultants</a> | <?php esc_html_e('Powered by ','Aggregate'); ?> <a href="http://www.wordpress.org">WordPress</a> | <?php esc_html_e('Fueled with ','Aggregate'); ?> <a href="http://greengeeks.com/going-green/">Renewable Energy</a></p>
			</div> <!-- end .container -->
			
		    <?php if ( !wp_is_mobile() ) { 
		        echo '<div id="csr-wire">CSRWire</div>'; 
		        if(function_exists('ditty_news_ticker')){ditty_news_ticker(173);}
		    } ?>
		</div> <!-- end #footer-top-shadow -->
		<div id="footer-bottom-shadow"></div>
		<div id="footer-bottom">
			<div class="container clearfix">
				<?php
					$menuID = 'bottom-nav';
					$footerNav = '';

					if (function_exists('wp_nav_menu')) $footerNav = wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => '', 'fallback_cb' => '', 'menu_id' => $menuID, 'menu_class' => 'bottom-nav', 'echo' => false, 'depth' => '1' ) );
					if ($footerNav == '') show_page_menu($menuID);
					else echo($footerNav);
				?>
			</div> <!-- end .container -->
		
		</div> <!-- end #footer-bottom -->
	</div> <!-- end #footer -->
	
	<?php get_template_part('includes/scripts');  ?>
	<?php wp_footer(); ?>
<!--<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/classie.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/cbpAnimatedHeader.js"></script>--->
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri() ?>/css/responsive.css" />
</body>
</html>