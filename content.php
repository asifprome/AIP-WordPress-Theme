<?php
/**
* @package    AIP
* @copyright  Copyright (c) 2020, Asif Imtious Prome
* @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

?>

<article <?php post_class(); ?>>

	<?php aip_thumbnail( 'aip-blog' ); ?>

	<header class="entry-header">

		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content( esc_html__( 'Continue reading &rarr;', 'aip' ) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'aip' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
