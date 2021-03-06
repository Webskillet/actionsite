<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header();

// sidebar comes first, because it includes the action 
get_sidebar(); ?>

<div id="main" class="main-content col-sm-8 col-sm-pull-4">

	<div id="primary" class="content-area clearfix">
		<div id="content" class="site-content" role="main">

		<?php
			if ( actionsite_using_default() && is_front_page() ) :

				get_template_part( 'content-petition' );

			elseif ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content' );

				endwhile;

			endif;
		?>

		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main -->

<?php
get_footer();
