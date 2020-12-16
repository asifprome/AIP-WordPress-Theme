<?php
/**
* @package    AIP
* @copyright  Copyright (c) 2020, Asif Imtious Prome
* @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
*/

get_template_part( 'header' );

				if ( have_posts() ) :

					while ( have_posts() ) :

						the_post();

						get_template_part( 'content' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile;

				else :

					get_template_part( 'content', 'none' );

				endif;
				?>

				</div><!-- .content-area -->
		</div><!-- .site-content -->
		<?php include 'footer.php' ?>