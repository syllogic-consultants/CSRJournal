<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die (esc_html__('Please do not load this page directly. Thanks!','Aggregate'));

	if ( post_password_required() ) { ?>

<p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.','Aggregate') ?></p>
<?php
		return;
	}
?>
<!-- You can start editing here. -->

<!-- removed all comments as requested by Nidhi....to re-introduce comments just copy origial comments.php from theme folder --> 