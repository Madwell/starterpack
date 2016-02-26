<?php get_header(); ?>

<?php /*START LOOP */ if ( get_posts() ) : while ( have_posts() ) : the_post(); ?>

	<?php the_content(); ?>

<?php /*END LOOP */ endwhile; endif; ?>

<?php get_footer(); ?>