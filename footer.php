<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 */
?>

		</div><!-- #wrapper-main -->

</div><!-- #wrapper -->

	<div class="footer-wrapper">
		<footer id="footer" class="site-footer clearfix container" role="contentinfo">
			<div class="footer-inner row">

			<?php get_sidebar( 'footer' ); ?>

			<div class="site-info">
				<a href="<?php echo esc_url( __( 'http://www.webskillet.com/', 'actionsite' ) ); ?>"><?php printf( __( 'ActionSite Wordpress theme by %s | a union shop, worker-owned cooperative and women-owned business', 'actionsite' ), 'Webskillet' ); ?></a>
			</div><!-- .site-info -->

			</div><!-- /.footer-inner -->
		</footer><!-- #footer -->
	</div><!-- /.footer-wrapper -->

	<?php wp_footer(); ?>
</body>
</html>
