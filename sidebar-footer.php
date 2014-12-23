<?php
/**
 * The Footer Sidebar
 *
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>

<div id="supplementary">
	<div id="footer-widget-area" class="footer-widget-area widget-area clearfix" role="complementary">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</div><!-- #footer-sidebar -->
</div><!-- #supplementary -->
