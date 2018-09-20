<?php global $sunset_amp_site; ?>
<?php amp_header(); ?>
<div class="article-info intro">
<?php amp_title(); ?>
</div>
<?php amp_content(); ?>
<?php Timber::render('templates/related.twig', $sunset_amp_site->context); ?>
<?php amp_footer()?>
