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

class AmpSite {

	function __construct() {
		add_action('amp_meta', array($this, 'add_meta'));
		add_filter('amp_post_template_analytics', array($this, 'add_analytics'));
		add_filter('amp_gallery_image_params', array($this, 'set_gallery_slide_params'), 10, 1);
	}

	function add_meta($amp) {

		console_dump($amp);
	}

	function add_analytics($analytics) {

		$ga = $analytics ['amp-gtm-googleanalytics'];
		$triggers = $ga['config_data']['triggers'];
		$triggers['ampCarouselChange'] = array(
			'on' => 'amp-carousel-change',
			'request' => 'pageview'
		);
		$ga['config_data']['triggers'] = $triggers;
		$analytics['amp-gtm-googleanalytics'] = $ga;
		console_dump($analytics);
		return $analytics;
	}

	function set_gallery_slide_params($image) {

		$resize_width = 800;
		$url_key = 'url';
		$crop_url = $image[$url_key];
		$image[$url_key] = Timber::compile_string('{{url | resize ( width ) }}',
			array ( 'url'  => $crop_url, 'width' => $resize_width) );
		$image['height'] = $image['height'] * ( $image['width']  / $resize_width );
		$image['width'] = $resize_width;
		return $image;
	}
}

new AmpSite();
