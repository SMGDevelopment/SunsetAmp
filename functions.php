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

		$slot = $ads['network_id'] . '/' . $ads['site_name'] . '/' . $ads['zone'];

		$output = preg_replace('/type="adsense"/', 'type="doubleclick"', $output);
		$output = preg_replace('/data-ad-client="[^"]?"/', '', $output);
		$output = preg_replace('/data-ad-slot="[^"]?"/', 'data-slot="' . $slot . '"', $output);
		return $output;
	}

	function add_to_context($context) {

		$context['post'] = new TimberPost;
		$context['ad_info'] = init_ad_context($context['post']); 
		return $context;
	}
}

global $sunset_amp_site;
$sunset_amp_site = new AmpSite();
