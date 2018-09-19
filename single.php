<?php amp_header(); ?>
<?php amp_title(); ?>
<?php amp_featured_image();?>
<?php amp_content(); ?>
<?php amp_post_pagination();?>
<?php amp_post_navigation();?>
<?php global $sunset_amp_site; Timber::render('templates/related.twig', $sunset_amp_site->context); ?>
<?php amp_footer()?>
