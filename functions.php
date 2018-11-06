<?php
// Loading the Components
//Search
add_amp_theme_support('AMP-search');
//Logo
add_amp_theme_support('AMP-logo');
//Social Icons
//add_amp_theme_support('AMP-social-icons');
//Menu
add_amp_theme_support('AMP-menu');
//Call Now
add_amp_theme_support('AMP-call-now');
//Sidebar
add_amp_theme_support('AMP-sidebar');
// Featured Image
//Author box
add_amp_theme_support('AMP-author-box');
//Loop
add_amp_theme_support('AMP-loop');
// Categories and Tags list
add_amp_theme_support('AMP-categories-tags');
// Comments
add_amp_theme_support('AMP-comments');
//Post Navigation
add_amp_theme_support('AMP-post-navigation');
// Related Posts
add_amp_theme_support('AMP-related-posts');
// Post Pagination
add_amp_theme_support('AMP-post-pagination');

amp_font('https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600|Source+Sans+Pro:400,700');
require_once(dirname(__FILE__) . '/class-amp-gallery-embed.php');
define("__GALLLERY_CROP__", "nl_landscape");
define("__URL_KEY__", "url");

class AmpSite extends TimberSite {

	public $context;
	function __construct() {
		parent::__construct();
		add_action('amp_header_top', array($this, 'header_top'));
		add_filter('amp_post_template_analytics', array($this, 'add_analytics'));
		add_filter('amp_gallery_image_params', array($this, 'set_gallery_slide_params'), 10, 1);
		add_filter('amp_content_embed_handlers', array($this, 'set_content_embed_handlers'));
		add_filter('amp_post_template_data', array($this, 'set_template_data'));
		add_filter('ampforwp_modify_ads', array($this, 'modify_ads'), 10, 1);
		add_filter('timber_context', array($this, 'add_to_context'));
		add_action('ampforwp_above_the_title', array( $this, 'above_title') );
		add_action('ampforwp_before_post_content', array( $this, 'before_content') );
		add_action('amp_before_footer', array($this, 'before_footer') );
		add_action('ampforwp_global_after_footer', array( $this, 'after_footer') );
		add_action('amp_post_template_head', array($this, 'post_head'));
		add_filter('amp_post_template_metadata', array($this, 'metadata'), 30, 1);

		$this->context = Timber::get_context();
	}

	function set_template_data($data) {
		$data['amp_component_scripts']['amp-ad'] = "https://cdn.ampproject.org/v0/amp-ad-0.1.js";
		$data['amp_component_scripts']['amp-sticky-ad'] = "https://cdn.ampproject.org/v0/amp-sticky-ad-1.0.js";
		return $data;
	}

	function set_content_embed_handlers($handlers) {

		$needle = 'AMP_Gallery_Embed_Handler';
		$galleryHandler = 'Sunset_AMP_Gallery_Embed_Handler';
		unset($handlers[ $needle ]);
		$handlers[$galleryHandler] = array();
		return $handlers;
	}

	function header_top() {
		include('header_top.php');
	}

	function add_analytics($analytics) {

		$ga = $analytics ['amp-gtm-googleanalytics'];
		$triggers = $ga['config_data']['triggers'];
		$triggers['ampCarouselChange'] = array(
			'on' => 'amp-carousel-change',
			'selector' => '#gallery-images',
			'request' => 'pageview'
		);
		$ga['config_data']['triggers'] = $triggers;
		$analytics['amp-gtm-googleanalytics'] = $ga;
		return $analytics;
	}

	function set_gallery_slide_params($image) {

		$timber = new TimberImage($image[__URL_KEY__]);
		$w = __AMP_IMAGE_CROP_WIDTH_;
		$h = __AMP_IMAGE_CROP_HEIGHT__;


		$crop_url = $timber->src(__GALLLERY_CROP__);

		$image[__URL_KEY__] = Timber::compile_string(
			'{{url | resize ( width, height ) }}',
			array (
				'url'  => $crop_url,
				'width' => $w,
				'height' => $h,
			)
		);
		$image['width'] = $w;
		$image['height'] = $h;
		return $image;
	}

	function modify_ads($output) {
		$ads = $this->context['ad_info'];

		$slot = $ads['slot'];

		$output = preg_replace('/type="adsense"/', 'type="doubleclick"', $output);
		$output = preg_replace('/data-ad-client="[^"]?"/', '', $output);
		$output = preg_replace('/data-ad-slot="[^"]?"/', 'data-slot="' . $slot . '"', $output);
		return $output;
	}

	function add_to_context($context) {

		$post = new TimberPost();
		$context['post'] = $post;
		$ads = init_ad_context($context['post']);
		$context['ad_info'] = $ads;

		$context = $this->add_breadcrumb($context, $post);

		return $context;
	}

	function above_title() {
		Timber::render('templates/partial/post-above-title.twig', $this->context);
	}

	function before_content() {
		Timber::render('templates/partial/post-before-content.twig', $this->context);
	}

	function before_footer($template) {
		Timber::render('templates/related.twig', $this->context);
	}

	function after_footer() {
		Timber::render('templates/partial/sticky-ad.twig', $this->context);
	}

	function post_head() {
		Timber::render('templates/partial/post-head.twig', $this->context);
	}

	function add_breadcrumb($context, $post) {
		$terms = $post->terms('category');
		foreach($terms as $term) {
			$parent = new TimberTerm($term->parent);
			if($parent->name == null)
				continue;

			$context['parent_category'] = $parent;
			$context['child_category'] = $term;
			break;
		}
		return $context;
	}

	function metadata($metadata, $post = null) {

		$post = new TimberPost($post);
		if('cp_recipe' != $post->post_type)
			return $metadata;

		$metadata['@type'] = 'Recipe';
		$metadata['author'] = $this->get_recipe_author( $post );

		$r = $post->_recipe_settings;
		if(array_key_exists('cook_time', $r) && $r['cook_time'])
			$metadata['cookTime'] = 'PT' . $r['cook_time'] . 'M';

		if(array_key_exists('prep_time', $r) && $r['prep_time'])
			$metadata['prepTime'] = 'PT' . $r['prep_time'] . 'M';

		$time = ($r['cook_time'] + $r['prep_time']);
		$time = $time ? $time : 1;

		$metadata['totalTime'] = 'PT' . $time . 'M';

		$metadata['description'] = strip_tags($r['excerpt']);
		$metadata['recipeIngredient'] = $this->get_recipe_ingredients($post);
		$metadata['recipeInstructions'] = $this->get_recipe_instructions($post);
		$metadata['nutrition'] = $this->get_nutrition($post);
		$metadata['name'] = $post->name;
		if($post->thumbnail)
			$metadata['image'] = array( $post->thumbnail->src );

		return $metadata;
	}

	function get_recipe_ingredients($post) {

		$recipe = $post->_recipe_settings;
		$ingredients = array_map(function($i) {
			return trim($i['name']);
		}, array_values($recipe['ingredients']));

		return $ingredients;
	}
	function get_recipe_instructions($post) {

		$recipe = $post->_recipe_settings;
		$f = array_filter($recipe['directions'], function($a) {
			return array_key_exists('content', $a);
		});
		$instructions = array_map(function($i) {
			return array(
				'@type' => 'HowToStep',
				'text' => trim(strip_tags($i['content']))
			);
		}, array_values($f));

		return $instructions;
	}

	function get_recipe_author($post) {

		return $post->author; 
	}

	function get_nutrition($post) {
		$r = $post->_recipe_settings;
		$nutrition = $r['nutrition'];
		return array('@type' => 'NutritionInformation', 'calories' => $nutrition['calories']);
	}
}

global $sunset_amp_site;
$sunset_amp_site = new AmpSite();
