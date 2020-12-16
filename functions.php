<?php
/**
* @package    AIP
* @copyright  Copyright (c) 2020, Asif Imtious Prome
* @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
*/

if ( ! function_exists( 'aip_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function aip_setup() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary Menu', 'aip' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add image size for blog posts, 640px wide (and unlimited height).
		add_image_size( 'aip-blog', 640 );

	}
endif;
add_action( 'after_setup_theme', 'aip_setup' );

/**
 * Registers an editor stylesheet for the theme.
 */
add_editor_style( 'editor-style.css' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function aip_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'aip_content_width', 640 );
}
add_action( 'after_setup_theme', 'aip_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function aip_scripts() {
	wp_enqueue_style( 'aip-style', get_stylesheet_uri(), array(), '1.0.2' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'aip_scripts' );

if ( ! function_exists( 'aip_thumbnail' ) ) :
	/**
	 * Output the thumbnail if it exists.
	 *
	 * @param string $size Thunbnail size to output.
	 */
	function aip_thumbnail( $size = '' ) {

		if ( has_post_thumbnail() ) {
			?>
			<div class="post-thumbnail">

				<?php if ( ! is_single() ) : ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_post_thumbnail( $size ); ?>
					</a>
				<?php else : ?>
					<?php the_post_thumbnail( $size ); ?>
				<?php endif; ?>

			</div><!-- .post-thumbnail -->
			<?php
		}

	}
endif;


/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function aip_pingback_header() {

	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}

}
add_action( 'wp_head', 'aip_pingback_header' );

if ( ! function_exists( 'aip_the_posts_navigation' ) ) :
	/**
	 * Displays the navigation to next/previous set of posts, when applicable.
	 */
	function aip_the_posts_navigation() {
		$args = array(
			'prev_text'          => esc_html__( '&larr; Older Posts', 'aip' ),
			'next_text'          => esc_html__( 'Newer Posts &rarr;', 'aip' ),
			'screen_reader_text' => esc_html__( 'Posts Navigation', 'aip' ),
		);
		the_posts_navigation( $args );
	}
endif;

$tags_list = get_the_tag_list( '', esc_html__( ', ', 'aip' ) );


/**
 * Display the admin notice.
 */
function aip_admin_notice() {
	global $current_user;
	$user_id = $current_user->ID;

	if ( class_exists( 'Olympus_Google_Fonts' ) ) {
		return;
	}
	/* Check that the user hasn't already clicked to ignore the message */
	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}
	if ( ! get_user_meta( $user_id, 'aip_ignore_notice' ) ) {
		?>

		<div class="notice notice-info">
			<p>
				<?php
				printf(
					/* translators: 1: twitter link */
					esc_html__( 'Thanks for using AIP theme. You may follow me at %1$s', 'aip' ),
					'<a href="http://twitter.com/asifprome" target="_blank" rel="noopener noreferrer">@asifprome</a>'
				);
				?>
				<span style="float:right">
					<a href="?aip_ignore_notice=0"><?php esc_html_e( 'Dismiss', 'aip' ); ?></a>
				</span>
			</p>
		</div>

		<?php
	}
}
add_action( 'admin_notices', 'aip_admin_notice' );
/**
 * Dismiss the admin notice.
 */
function aip_dismiss_admin_notice() {
	global $current_user;
	$user_id = $current_user->ID;
	/* If user clicks to ignore the notice, add that to their user meta */
	if ( isset( $_GET['aip_ignore_notice'] ) && '0' === $_GET['aip_ignore_notice'] ) {
		add_user_meta( $user_id, 'aip_ignore_notice', 'true', true );
	}
}
add_action( 'admin_init', 'aip_dismiss_admin_notice' );

/**
 * Newer/Older Posts.
 */
function aip_the_posts_navigation() {
	the_posts_navigation(
		array(
			'prev_text' => esc_html__( '&larr; Older posts', 'aip' ),
			'next_text' => esc_html__( 'Newer posts &rarr;', 'aip' ),
		)
	);
}
