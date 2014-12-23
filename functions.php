<?php
/**
 * actionsite functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Set up the content width value based on the theme's design.
 *
 * @see actionsite_content_width()
 *
 * @since actionsite 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 474;
}

/**
 * actionsite only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'actionsite_setup' ) ) :
/**
 * actionsite setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since actionsite 1.0
 */
function actionsite_setup() {

	/*
	 * Make actionsite available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on actionsite, use a find and
	 * replace to change 'actionsite' to the name of your theme in all
	 * template files.
	 */

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', actionsite_font_url() ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 160, 160, true );
	add_image_size( 'actionsite-full-width', 740, 275, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'actionsite' ),
		'secondary' => __( 'Secondary menu in left sidebar', 'actionsite' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
/*
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );
*/

}
endif; // actionsite_setup
add_action( 'after_setup_theme', 'actionsite_setup' );

/**
 * Adjust content_width value for image attachment template.
 *
 * @since actionsite 1.0
 *
 * @return void
 */

/*
function actionsite_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'actionsite_content_width' );
*/

/**
 * Register three actionsite widget areas.
 *
 * @since actionsite 1.0
 *
 * @return void
 */
function actionsite_widgets_init() {
	// register widgets here
	require get_template_directory() . '/inc/widgets.php';
	register_widget( 'Actionsite_Who_Widget' );
	register_widget( 'Actionsite_Info_Widget' );
	register_widget( 'Actionsite_Support_Widget' );

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'actionsite' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar.  Will be overridden with petition if you select Default Display in Theme Options.', 'actionsite' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'actionsite' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears in the footer section of the site.', 'actionsite' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'actionsite_widgets_init' );

/**
 * Set default widgets
 */

function actionsite_set_default_widgets() {
	$widgets = get_option('sidebars_widgets');
	$widgets['sidebar-1'] = array();
	$widgets['sidebar-2'] = array(
		0 => 'widget_actionsite_who_widget-1',
		1 => 'widget_actionsite_info_widget-1',
		2 => 'widget_actionsite_support_widget-1',
	);
	update_option('sidebars_widgets', $widgets);

	$widget_who = 'Every day, decisions are made by elected officials, government bodies and corporations that profoundly affect our lives.  <a href="http://iiron.org">IIRON</a> trains people to understand, build, and exercise power through collective action so that powerful decision-makers act in ways that serve our interests, not just the interests of the wealthy and big corporations.

This website is created and maintained by <a href="http://iiron.org">IIRON</a>. ';
	update_option('widget_widget_actionsite_who_widget',array(
		1 => array(
			'body' => $widget_who,
		),
		'_multiwidget' => 1,
	) );

	$widget_info = 'For more background on this issue, please visit the <a href="http://faireconomyillinois.org">Fair Economy Illinois</a>, a statewide alliance that organizes people and money in order to: 

1) limit the power of corporations and private interests in our state; 

2) ensure adequate revenue for the State of Illinois to fulfill its primary functions;

3) protect our environment and natural resources from corporate exploitation. ';
	update_option('widget_widget_actionsite_info_widget',array(
		1 => array(
			'body' => $widget_info,
		),
		'_multiwidget' => 1,
	) );

	$widget_support = 'If you believe our elected officials should put the interests of people before corporate profits, please <a href="https://iiron.ourpowerbase.net/civicrm/contribute/transact?reset=1&id=15"> donate $5, $10 or $25 to IIRON.</a>

Your donation will support IIRON\'s campaigns to ensure corporations pay their fair share in taxes so we can restore Illinois\' fiscal health.';
	update_option('widget_widget_actionsite_support_widget',array(
		1 => array(
			'body' => $widget_support,
		),
		'_multiwidget' => 1,
	) );

}
add_action('after_switch_theme', 'actionsite_set_default_widgets');

// actionsite options values
global $actionsite_options;
$actionsite_options = array(
	'actionnetwork_api' => '',
	'actionnetwork_actionid' => '',
	'default_display' => 1,
	'extra_css' => '',
);
$actionsite_options = get_option( 'actionsite_options', $actionsite_options );

// helper function to get image id from URL
function actionsite_get_image_id( $image_url, $size ) {
 
	global $wpdb;
	$prefix = $wpdb->prefix;
	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE guid='%s';", $image_url ) );
	$image_thumb = wp_get_attachment_image_src( $attachment[0], $size );
	return $image_thumb[0];
}

function actionsite_get_header_image() {
	$header_image = get_theme_mod('actionsite_header_image');
	if ($header_image) { return actionsite_get_image_id( $header_image, 'actionsite-full-width'); }
}

function actionsite_get_header_image_text() {
	return get_theme_mod('actionsite_header_image_text');
}

/**
 * Register Google fonts for actionsite.
 *
 * @since actionsite 1.0
 *
 * @return string
 */
function actionsite_font_url() {
	global $actionsite_options;
	$font_url = '';
	$font_url = add_query_arg( 'family', 'Open+Sans', "//fonts.googleapis.com/css" );
	return $font_url;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since actionsite 1.0
 *
 * @return void
 */
function actionsite_scripts() {
	global $actionsite_options;
	$css_deps = array();
	$js_deps = array( 'jquery' );

	// Add Google fonts.
	$font_url = actionsite_font_url();
	if ($font_url) {
		wp_enqueue_style( 'actionsite-googlefonts', $font_url, array(), null );
		$css_deps[] = 'actionsite-googlefonts';
	}

	// Fontawesome
	wp_enqueue_style( 'actionsite-fontawesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css', array(), '4.1.0' );
	$css_deps[] = 'actionsite-fontawesome';

	// Bootstrap
	wp_enqueue_style( 'actionsite-bootstrap-css', '//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css', array(), '3.1.1' );
	wp_enqueue_script( 'actionsite-bootstrap-js', '//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js', array('jquery'), '3.1.1' );
	$css_deps[] = 'actionsite-bootstrap-css';
	$js_deps[] = 'actionsite-bootstrap-js';

	// ActionNetwork 
	wp_enqueue_style( 'actionnetwork-css', 'https://actionnetwork.org/css/style-embed-whitelabel.css', array(), '3.1.1' );
	$css_deps[] = 'actionnetwork-css';

	// Load our main stylesheet.
	wp_enqueue_style( 'actionsite-style', get_stylesheet_uri(), $css_deps );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'actionsite-ie', get_template_directory_uri() . '/css/ie.css', array( 'actionsite-style' ), '20131205' );
	wp_style_add_data( 'actionsite-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'actionsite-modernizr', get_template_directory_uri() . '/js/modernizr.js', array(), '20140213' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'actionsite-script', get_template_directory_uri() . '/js/wsutil.js', $jsdeps, '20131209' );
}
add_action( 'wp_enqueue_scripts', 'actionsite_scripts' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @since actionsite 1.0
 *
 * @return void
 */
function actionsite_admin_fonts() {
	wp_enqueue_style( 'actionsite-lato', actionsite_font_url(), array(), null );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'actionsite_admin_fonts' );



/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image.
 * 3. Index views.
 * 4. Full-width content layout.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since actionsite 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function actionsite_body_classes( $classes ) {
	global $actionsite_options;

	if ($actionsite_options['bootstrap']) {
		$classes[] = 'bootstrap';
	}

	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( get_header_image() ) {
		$classes[] = 'header-image';
	} else {
		$classes[] = 'masthead-fixed';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( ( ! is_active_sidebar( 'sidebar-1' ) )
		|| is_attachment() ) {
		$classes[] = 'full-width';
	}

	if ( is_active_sidebar( 'sidebar-2' ) ) {
		$classes[] = 'content-widgets';
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$classes[] = 'footer-widgets';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	if ( is_front_page() ) {
		$classes[] = 'front';
	}

	return $classes;
}
add_filter( 'body_class', 'actionsite_body_classes' );

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @since actionsite 1.0
 *
 * @param array $classes A list of existing post class values.
 * @return array The filtered post class list.
 */
function actionsite_post_classes( $classes ) {
	if ( ! post_password_required() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'actionsite_post_classes' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since actionsite 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function actionsite_wp_title( $title, $sep ) {
	global $paged, $page;

	if (actionsite_using_default() && is_front_page()) {
		return actionsite_get_title();
	}

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'actionsite' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'actionsite_wp_title', 10, 2 );

/**
 * Customize link colors
 */

function actionsite_custom_css() {
	global $actionsite_options;
	?>
		<style type="text/css">

a, h1.entry-title:before { color: <?php echo get_theme_mod('actionsite_linkcolor'); ?>; }

a.btn,
.actionsite_embed_widget #can_embed_form input[type="submit"],
.actionsite_embed_widget #can_embed_form .button,
.actionsite_embed_widget #donate_auto_modal input[type="submit"],
.actionsite_embed_widget #donate_auto_modal .button,
.actionsite_embed_widget #can_embed_form #can_thank_you { background-color: <?php echo get_theme_mod('actionsite_linkcolor'); ?>; }

a:hover { color: <?php echo get_theme_mod('actionsite_linkcolor_hover'); ?>; }

.actionsite_embed_widget #can_embed_form input[type="submit"]:hover,
.actionsite_embed_widget #can_embed_form .button:hover,
.actionsite_embed_widget #donate_auto_modal input[type="submit"]:hover,
.actionsite_embed_widget #donate_auto_modal .button:hover { background-color: <?php echo get_theme_mod('actionsite_linkcolor_hover'); ?>; }

<?php echo $actionsite_options['extra_css']; ?>

		</style>
	<?php
}
add_action( 'wp_head', 'actionsite_custom_css' );

function actionsite_using_default() {
	global $actionsite_options;
	return $actionsite_options['default_display'];
}

/**
 * ActionNetwork API Interface
 */

function actionsite_api_call( $endpoint, $postfields = array() ) {
	global $actionsite_options;
	if (!$actionsite_options['actionnetwork_api']) { return; }

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('api-key:'.$actionsite_options['actionnetwork_api']));
	if (count($postfields)) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
	}
	curl_setopt($ch, CURLOPT_URL, 'https://actionnetwork.org/api/v1/'.$endpoint);

	$response = curl_exec($ch);
	curl_close($ch);

	return $response;
}

function actionsite_api_get_petitions() {
	$json = actionsite_api_call('petitions');
	$object = json_decode($json);
	// return print_r($object,1);

	$links = $object->_embedded->{'osdi:petitions'};

	$petitions = array();
	foreach ($links as $l) {
		$name = $l->summary;
		$id = $l->identifiers[0];
		$petitions[] = array('name' => $name, 'id' => str_replace('action_network:','',$id));
	}

	return $petitions;
}

$actionsite_the_petition = array(
	'title' => 'No ActionNetwork petition has been loaded yet',
	'target' => '',
	'petition' => '',
	'action' => '',
	'description' => '',
	'share' => '',
	'status' => 0,
);

function actionsite_api_get_petition() {
	global $actionsite_options, $actionsite_the_petition;
	if ($actionsite_the_petition['status']) { return; }
	if ($actionsite_options['actionnetwork_actionid']) {
		// get the summary, petition language and description
		$json = actionsite_api_call('petitions/'.$actionsite_options['actionnetwork_actionid']);
		$petition = json_decode($json);
		$actionsite_the_petition['title'] = $petition->summary;
		$actionsite_the_petition['target'] = $petition->target[0]->name;
		$actionsite_the_petition['petition'] = $petition->petition_text;
		$actionsite_the_petition['description'] = $petition->description;
		$actionsite_the_petition['url'] = $petition->url;
		$actionsite_the_petition['debug'] = '<pre>'.print_r($petition,1).'</pre>';

		// get the embed code
		$json = actionsite_api_call('petitions/'.$actionsite_options['actionnetwork_actionid'].'/embed');
		$embed = json_decode($json);
		$actionsite_the_petition['action'] = str_replace('widgets/petition','widgets/v2/petition',$embed->embed_no_styles);

		// set status to 1 so we don't 
		$actionsite_the_petition['status'] = 1;
	}
}

function actionsite_get_title() {
	global $actionsite_the_petition;
	actionsite_api_get_petition();
	return $actionsite_the_petition['title'];
}
add_shortcode('actionsite_title','actionsite_get_title');

function actionsite_get_target() {
	global $actionsite_the_petition;
	actionsite_api_get_petition();
	return $actionsite_the_petition['target'];
}
add_shortcode('actionsite_target','actionsite_get_target');

function actionsite_get_petition() {
	global $actionsite_the_petition;
	actionsite_api_get_petition();
	return $actionsite_the_petition['petition'];
}
add_shortcode('actionsite_petition','actionsite_get_petition');

function actionsite_get_action() {
	global $actionsite_the_petition;
	actionsite_api_get_petition();
	return $actionsite_the_petition['action'];
}
add_shortcode('actionsite_action','actionsite_get_action');

function actionsite_get_description() {
	global $actionsite_the_petition;
	actionsite_api_get_petition();
	return $actionsite_the_petition['description'];
}
add_shortcode('actionsite_description','actionsite_get_description');

function actionsite_get_share( $atts, $content ) {
	global $actionsite_the_petition;
	actionsite_api_get_petition();

	list($description_first_sentence,$trash) = preg_split('/[.?!]/', strip_tags( $actionsite_the_petition['description'] ) );

	$atts = shortcode_atts( array(
		'url' => site_url().'/',
		'image' => actionsite_get_header_image(),
		'name' => $actionsite_the_petition['title'],
		'description' => $description_first_sentence,
		'tweet' => $actionsite_the_petition['title'],
		'handle' => '',
	), $atts, 'actionsite_share');

	foreach($atts as $k => $v) {
		$atts[$k.'_encoded'] = urlencode($v);
	}

	extract($atts);

	$content = $content ? $content : 'Help us meet our goal by spreading the word about this petition using the tools below.';

	$redirect_uri_encoded = urlencode($actionsite_the_petition['url']);

	$handle_via = $handle ? '&via='.$handle : '';

	$share = <<<EOHTML

<div class="actionsite_share_widget">

	<p>$content</p>

	<h2>Share This Petition</h2>

	<div class="share_buttons">
		<a href="https://www.facebook.com/dialog/feed?app_id=238823876266270&amp;display=popup&amp;caption=%20&amp;link=$url_encoded%3Fsource%3Dfacebook&amp;redirect_uri=$redirect_uri_encoded&amp;name=$name_encoded&amp;description=$description_encoded&amp;picture=$image_encoded" class="share_button share-facebook left mr15 "><span><strong>Like</strong></span></a>

		<a href="https://twitter.com/intent/tweet?url=$url_encoded%3Fsource%3Dtwitter&text=$tweet_encoded$handle_via" class="share_button share-twitter left mr15 "><span><strong>Tweet</strong></span></a>

		<a href="https://plus.google.com/share?url=$url?source=gplus" class="share_button share-google left "><span><strong>+1</strong></span></a>

	</div>

	<h2><label for="petition-share_link">Direct Link</label><h2>
	<input size="35" name="petition-share_link" value="$url?source=direct_link" class=" " type="text">

</div>

EOHTML;

	return $share;
}
add_shortcode('actionsite_share','actionsite_get_share');

function actionsite_br2nl($html) {
	$output = str_replace('</p>',"\n\n",$html);
	$output = preg_replace('/<br ?\/?>/',"\n",$output);
	$output = str_replace("\n\n\n","\n\n",$output);
	return trim(strip_tags($output));
}

function actionsite_get_email_share( $atts, $content) {
	global $actionsite_the_petition;
	actionsite_api_get_petition();

	extract($atts);

	$subject = $subject ? $subject : 'Sign the petition! '.$actionsite_the_petition['title'];
	if ($content) {
		$content = actionsite_br2nl($content);
		$email_share = <<<EOHTML
<div class="actionsite_share_widget">
	<h2>Email A Friend</h2>
	<div class="tell_a_friend">
		<p><label for="tell-a-friend-subject">Subject:</label>
		<input id="tell-a-friend-subject" type="text" value="$subject" /></p>
		<p><label for="tell-a-friend-body">Body:</label>
		<textarea id="tell-a-friend-body">$content</textarea></p>
	</div>
</div>
EOHTML;
	} else {
		$url = $url ? $url : site_url().'/';
		$background = actionsite_br2nl($actionsite_the_petition['description']);
		$email_share = <<<EOHTML
<div class="actionsite_share_widget">
	<h2>Email A Friend</h2>
	<div class="tell_a_friend">
		<p><label for="tell-a-friend-subject">Subject:</label>
		<input id="tell-a-friend-subject" type="text" value="$subject" /></p>
		<p><label for="tell-a-friend-body">Body:</label>
		<textarea id="tell-a-friend-body">Friend,

I signed a petition telling {$actionsite_the_petition['target']}: “{$actionsite_the_petition['petition']}”

Can you join me and take action? Click here: $url?source=email

Here’s the background:

$background

Can you join me and take action? Click here: $url?source=email

Thanks!</textarea>
	</div>
</div>
EOHTML;
	}

	return $email_share;
}
add_shortcode('actionsite_email_share','actionsite_get_email_share');

/**
 * Administer options
 */

if ( is_admin() ) : // Load only if we are viewing an admin page

function actionsite_register_options() {
	// Register settings and call sanitation functions
	register_setting( 'actionsite_theme_options', 'actionsite_options', 'actionsite_validate_options' );
}
add_action( 'admin_init', 'actionsite_register_options' );

function actionsite_theme_options() {

	// Add theme options page to the addmin menu
	add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', 'actionsite_theme_options_page' );
}
add_action( 'admin_menu', 'actionsite_theme_options' );

// Function to generate options page (which handles API key and selecting 
function actionsite_theme_options_page() {
	global $actionsite_options;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap">

	<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>";
	// This shows the page's name and an icon if one has been provided ?>

	<?php if ( false !== $_REQUEST['updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>

	<form method="post" action="options.php">

	<?php $settings = get_option( 'actionsite_options', $actionsite_options ); ?>
	
	<?php settings_fields( 'actionsite_theme_options' );
	/* This function outputs some hidden fields required by the form,
	including a nonce, a unique number used to ensure the form has been submitted from the admin page
	and not somewhere else, very important for security */ ?>

	<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->

	<tr valign="top"><th scope="row"><label for="actionnetwork_api">ActionNetwork API Key</label></th>
	<td>
	<input id="actionnetwork_api" name="actionsite_options[actionnetwork_api]" type="text" value="<?php  esc_attr_e($settings['actionnetwork_api']); ?>" />
	</td>
	</tr>

	<?php
		/* only select action if ActionNetwork API has been entered, and is valid */
		if ($settings['actionnetwork_api']) :
	?>

	<?php
		$petitions = actionsite_api_get_petitions();
		$actionid = $settings['actionnetwork_actionid'];
		$select = '<select id="actionnetwork_actionid" name="actionsite_options[actionnetwork_actionid]">';
		$select .= '<option value="" '.selected( $actionid, '', false).'>- None -</option>';
		foreach($petitions as $p) {
			$select .= '<option value="'.$p['id'].'" '.selected( $actionid, $p['id'], false).'>'.$p['name'].'</option>';
		}
		$select .= '</select>';
	?>

	<tr valign="top"><th scope="row"><label for="actionnetwork_actionid">ActionNetwork Action</label></th>
	<td>
	<?php echo $select; ?>
	</td>
	</tr>

	<?php
		endif;
	?>


	<tr valign="top"><th scope="row">Default Display</th>
	<td>
	<input type="checkbox" id="default_display" name="actionsite_options[default_display]" value="1" <?php checked( true, $settings['default_display'] ); ?> />
	<label for="default_display">Use Default Display</label>
	<p>If checked, this will override the front page and sidebar: front page will display the petition title ("Summary") and description; sidebar will display the target, petition text, and embedded widget to allow people to sign.  If unchecked, you can use the following shortcodes to build your site however you want:</p>
	<ul><li><strong>[actionsite_title]</strong>: Title ("Summary") of petition</li>
	<li><strong>[actionsite_target]</strong>: Target of petition</li>
	<li><strong>[actionsite_description]</strong>: Description of why the petition is important</li>
	<li><strong>[actionsite_petition]</strong>: The petition language itself (addressed to the target)</li>
	<li><strong>[actionsite_action]</strong>: The embed code that creates the take action form</li>
	<li><strong>[actionsite_share]</strong>: Creates share buttons and direct link</li>
	<li><strong>[actionsite_email_share]</strong>: Creates share-by-email</li></ul>
	<p>The [actionsite_share] shortcode can take the following attributes (i.e., [actionsite_share url="http://me.com"]):</p>
	<ul><li><strong>url</strong>: URL to be shared (defaults to front page of site)</li>
	<li><strong>image</strong>: Image for Facebook sharing (defaults to header image)</li>
	<li><strong>name</strong>: Name for Facebook sharing (defaults to petition title/summary)</li>
	<li><strong>description</strong>: Description for Facebook sharing (defaults to first sentence of description)</li> 
	<li><strong>tweet</strong>: Tweet (defaults to petition title/summary, link will be included automatically)</li>
	<li><strong>handle</strong>: Twitter handle (default blank, will be included at end with "via @handle")</li>
	<li>You can modify the text at the top of the page by putting it in the content of the shortcode: [actionsite_share]Here is some text[/actionsite_share]</li></ul>
	<p>The [actionsite_email_share] shortcode can modify the suggested subject with a subject attribute, and can modify the body by putting it in the content of the shortcode</p>
	</td>
	</tr>

	<tr valign="top"><th scope="row"><label for="extra_css">Custom CSS</label></th>
	<td>
	<textarea id="extra_css" name="actionsite_options[extra_css]" style="width: 100%; height: 100px;"><?php echo esc_attr_e($settings['extra_css']); ?></textarea>
	</td>
	</tr>

	</table>

	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

	</form>

	</div>

	<?php
}

function actionsite_validate_options( $input ) {
	global $actionsite_options;

	$settings = get_option( 'actionsite_options', $actionsite_options );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS
	$input['google_fonts'] = wp_filter_nohtml_kses( $input['google_fonts'] );
	
	// If the checkbox has not been checked, we void it
	if ( ! isset( $input['fontawesome'] ) )
		$input['fontawesome'] = null;
	// We verify if the input is a boolean value
	$input['fontawesome'] = ( $input['fontawesome'] == 1 ? 1 : 0 );
	
	// If the checkbox has not been checked, we void it
	if ( ! isset( $input['bootstrap'] ) )
		$input['bootstrap'] = null;
	// We verify if the input is a boolean value
	$input['bootstrap'] = ( $input['bootstrap'] == 1 ? 1 : 0 );
	
	return $input;
}

function actionsite_customize_register( $wp_customize ) {
	$wp_customize->add_setting( 'actionsite_linkcolor' , array(
		'default'     => '#CC6633',
		'transport'   => 'refresh',
	) );
	$wp_customize->add_setting( 'actionsite_linkcolor_hover' , array(
		'default'     => '#f78f1a',
		'transport'   => 'refresh',
	) );
	$wp_customize->add_setting( 'actionsite_header_image' , array(
		'default'     => '',
		'transport'   => 'refresh',
	) );
	$wp_customize->add_setting( 'actionsite_header_image_text' , array(
		'default'     => '',
		'transport'   => 'refresh',
	) );
	$wp_customize->add_section( 'actionsite_theming_options' , array(
		'title'      => __( 'ActionSite Theming Options', 'actionsite' ),
		'priority'   => 10,
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'actionsite_linkcolor_control',
			array (
				'label' => __( 'Link Color', 'actionsite' ),
				'section' => 'actionsite_theming_options',
				'settings' => 'actionsite_linkcolor',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'actionsite_linkcolor_hover_control',
			array (
				'label' => __( 'Link Hover Color', 'actionsite' ),
				'section' => 'actionsite_theming_options',
				'settings' => 'actionsite_linkcolor_hover',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'actionsite_header_image_control',
			array (
				'label' => __( 'Header Image', 'actionsite' ),
				'section' => 'actionsite_theming_options',
				'settings' => 'actionsite_header_image',
			)
		)
	);
	$wp_customize->add_control(
		'actionsite_header_image_text_control',
		array (
			'label' => __( 'Header Image Text', 'actionsite' ),
			'section' => 'actionsite_theming_options',
			'settings' => 'actionsite_header_image_text',
			'type' => 'text',
		)
	);
}
add_action( 'customize_register', 'actionsite_customize_register' );

endif;  // EndIf is_admin()
