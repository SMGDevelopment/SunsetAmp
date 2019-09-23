<?php amp_header(); ?>
<div class="article-info intro">
<?php amp_title(); ?>

<?php global $sunset_amp_site;
if($sunset_amp_site->context['layout']->slug !== 'gallery') {
  amp_featured_image();
}?>
</div>
<?php amp_content(); ?>
<?php amp_footer()?>
