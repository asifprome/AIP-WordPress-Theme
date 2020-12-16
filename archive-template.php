<?php
/**
* Template Name: Archive Template
*
* @package    AIP
* @copyright  Copyright (c) 2020, Asif Imtious Prome
* @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
*/

get_template_part( 'header' );
?>
				<header>
					<h1 class="archives__heading"><?php single_post_title(); ?></h1>
				</header>

				<?php

				$args = array(
					'post_type'      => 'post',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
				);

				$aip_posts = new WP_Query( $args );

				if ( $aip_posts->have_posts() ) :

					echo '<ul class="archives__list">';

					while ( $aip_posts->have_posts() ) :
						$aip_posts->the_post();

						echo '<li><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a><span>' . esc_attr( get_the_time( 'F j, Y' ) ) . '</span></li>';

					endwhile;

					echo '</ul>';

					wp_reset_postdata();

				else :
						echo '<p>' . esc_html__( 'Sorry, no posts matched your criteria.', 'aip' ) . '</p>';
				endif;
				?>
				</div><!-- .content-area -->
		</div><!-- .site-content -->
			<?php include 'footer.php' ?>
	</body>
</html>
