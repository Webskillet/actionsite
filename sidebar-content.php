<?php
/**
 * The Content Sidebar
 *
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>
<div id="content-widget-area" class="content-widget-area widget-area clearfix" role="complementary">
	<?php dynamic_sidebar( 'sidebar-2' ); ?>
</div><!-- #content-sidebar -->
