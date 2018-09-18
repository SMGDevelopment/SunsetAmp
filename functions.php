<?php
// Loading the Components
//Search
add_amp_theme_support('AMP-search');
//Logo
add_amp_theme_support('AMP-logo');
//Social Icons
add_amp_theme_support('AMP-social-icons');
//Menu
add_amp_theme_support('AMP-menu');
//Call Now
add_amp_theme_support('AMP-call-now');
//Sidebar
add_amp_theme_support('AMP-sidebar');
// Featured Image
add_amp_theme_support('AMP-featured-image');
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

class AmpSite {

	function __construct() {
		add_action('amp_header_top', array($this, 'header_top'));
		add_filter('amp_post_template_analytics', array($this, 'add_analytics'));
		add_filter('amp_gallery_image_params', array($this, 'set_gallery_slide_params'), 10, 1);
		add_filter('amp_content_embed_handlers', array($this, 'set_content_embed_handlers'));
		add_filter('amp_post_template_data', array($this, 'set_template_data'));
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
			?><a href="/"><svg xmlns="http://www.w3.org/2000/svg" width="124" height="32" viewBox="0 0 1055 293" xml:space="preserve" fill="#f37123">
              <title>Sunset</title>
              <path d="M1042.597,67.37l-86.656,3.295V33.191c0-4.144-3.354-7.032-7.452-6.418l-37.577,5.633  c-4.099,0.615-7.452,4.508-7.452,8.651v31.604l-37.675,1.433c-3.296,0.125-5.994,2.928-5.994,6.227v7.498  c0,3.299,2.7,5.998,5.998,5.998h37.671v80.34c-14.606,24.239-40.252,47.063-63.265,47.063c-17.827,0-29.167-8.093-32.103-26.095  c29.557,0.413,74.945-16.816,74.945-52.234c0-31.737-31.301-42.692-58.01-42.692c-38.413,0-76.422,34.371-74.688,79.355  c-5.189,0.548-10.39,1.101-15.479,1.646c-4.281-15.009-15.873-29.64-34.419-40.654c-15.082-8.959-19.3-11.673-19.3-11.673  s24.68-30.375,3.641-35.747c-22.028-5.625-60.743,25.532-56.271,47.073c1.57,7.575,5.808,13.854,12.429,18.943  c-12.19,15.212-26.718,31.409-37.983,38.142c-8.41,5.025-10.051,0.16-10.313-4.886c0,0-0.01-48.379-0.01-51.632  c0-7.293,1.419-40.443-32.659-40.443c-26.336,0-50.039,14.154-63.72,37.635l-0.243-32.17c-0.032-4.144-3.423-7.103-7.531-6.574  l-37.535,4.817c-4.11,0.528-7.473,4.351-7.473,8.495v57.445c-1.279,25.455-14.913,48.559-30.284,48.559  c-15.063,0-14.053-24.967-14.053-24.967v-85.705c0-4.145-3.38-7.234-7.507-6.867l-37.471,3.333  c-4.127,0.367-7.504,4.058-7.504,8.203v53.563c0,26.938-14.232,52.44-30.382,52.44c-15.063,0-14.054-24.967-14.054-24.967v-85.705  c0-4.145-3.377-7.234-7.507-6.867l-37.47,3.333c-4.128,0.367-7.506,4.058-7.506,8.203v65.799h-20.63  c-9.618-29.743-44.744-47.299-81.143-60.702c-46.521-17.121-95.103-27.445-95.103-47.77c0-11.536,14.444-14.643,24.475-14.643  c41.492,0,79.782,10.762,120.995,15.563c35.852,4.175,46.611-0.391,55.21-37.001c0.688-2.927-1.444-4.28-3.556-4.757  C126.389,1.132,23.363,20.188,23.363,82.203c0,62.904,93.254,75.968,136.42,98.696c-31.739,0.21-152.737,4.021-152.737,49.209  c0,37.754,66.306,46.404,94.151,46.404c47.182,0,131.037-21.787,130.483-81.505l-0.011-1.093h18.064c0,0,0.009,13.076,0.009,16.083  c0,7.294-1.418,40.443,32.659,40.443c34.188,0,52.009-16.422,64.253-39.368c-0.052,8.995,0.042,39.368,32.664,39.368  c34.093,0,51.91-16.33,64.151-39.176v32.771c0,4.146,3.375,7.205,7.498,6.803l38.613-3.771c4.124-0.403,7.476-4.124,7.442-8.27  l-0.287-37.543c0.96-46.185,14.299-66.762,29.367-66.762c15.232,0,14.053,22.708,14.053,22.708s0,69.167,0,70.249  c0,13.997,7.477,25.398,27.233,22.282c21.543-3.399,56.863-45.204,87.294-82.749c8.838,4.655,31.664,19.55,31.764,19.616  c-0.856,0.126-5.098,0.848-5.956,1.063c-19.479,4.039-50.855,15.604-50.855,36.851c0,18.676,25.595,24.895,40.051,24.895  c26.225,0,50.314-11.232,61.258-33.179c3.506-6.229,5.405-12.924,5.732-19.771c0.008-0.054,0.033-0.779,0.041-1.09  c5.119-0.563,10.313-1.14,15.448-1.712c9.72,36.167,37.883,55.751,71.947,55.751c33.252,0,60.442-20.811,79.342-46.777v41.406  c0,4.146,3.369,7.15,7.486,6.681l37.509-4.273c4.118-0.47,7.486-4.244,7.486-8.388V93.815h83.651c3.299,0,6.299-2.682,6.668-5.96  l1.659-14.753C1048.289,69.823,1045.893,67.244,1042.597,67.37z M107.094,244.026c-15.927,0-56.041-3.66-56.041-19.922  c0-23.469,87.579-25.943,109.606-25.812l16.122,0.103c4.006,3.318,6.49,7.762,6.49,12.264  C183.271,238.115,135.3,244.026,107.094,244.026z M658.814,221.161c0-15.847,25.849-19.562,37.785-21.396  c0.58-0.063,1.173-0.128,1.777-0.193c2.865,4.137,4.61,8.826,4.61,13.917c0,2.08-0.321,3.982-0.901,5.716  c-1.943,4.492-5.506,8.255-9.855,10.796c-4.832,2.531-10.571,3.699-15.627,3.699C669.137,233.7,658.814,230.523,658.814,221.161z   M805.437,165.48c0-13.985,2.748-49.331,20.92-49.331c9.8,0,12.564,11.765,12.564,20.199c0,20.413-11.98,41.708-32.521,43.265  C805.719,174.94,805.437,170.204,805.437,165.48z"></path>
            </svg></a><?php
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

		$url_key = 'url';
		$max_height = $image['args']['height'];
		$crop_url = $image[$url_key];

		$r_h = $max_height;
		$r_w = $r_h / ( $image['width'] / $image['height'] );

		$image[$url_key] = Timber::compile_string('{{url | resize ( width, height ) }}',
			array ( 'url'  => $crop_url, 'width' => null, 'height' => $r_h ));

		$image['width'] = $r_w;
		$image['height'] = $r_h;

		return $image;
	}
}

new AmpSite();
