<?php
/**
 * The Sidebar containing the main widget area
 *
 */
?>
<div id="secondary" class="clearfix col-sm-4 col-sm-push-8">

	<?php if ( actionsite_using_default() ) : ?>

<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
	<aside id="text-6" class="widget widget_text">
		<h1 class="widget-title">To: <?php echo actionsite_get_target(); ?></h1>
		<div class="textwidget"><?php echo actionsite_get_petition(); ?></div>
	</aside>
	<aside id="text-2" class="widget widget_text">
			<div class="actionsite_embed_widget">
				<?php echo actionsite_get_action(); ?>
			</div>
	</aside>
</div>

	<?php elseif ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- #primary-sidebar -->
	<?php endif; ?>
</div><!-- #secondary -->
