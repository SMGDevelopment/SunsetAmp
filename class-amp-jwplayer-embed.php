<?php

require_once( AMP__DIR__ . '/includes/embeds/class-amp-gallery-embed.php' );
define("__AMP_IMAGE_CROP_HEIGHT__", 463);
define("__AMP_IMAGE_CROP_WIDTH_", 694);
define("__AMP_CAPTION_HEIGHT__", 210);

class Sunset_AMP_JWPlayer_Embed_Handler extends AMP_Base_Embed_Handler {
	private static $script_slug = 'amp-carousel';
	private static $script_src = 'https://cdn.ampproject.org/v0/amp-carousel-0.1.js';

	public function register_embed() {
    echo "<!-- registering embed -->";
		add_shortcode( 'jwplayer', array( $this, 'shortcode' ) );
		add_shortcode( 'bc_video', array( $this, 'bc_shortcode' ) );
	}

	public function unregister_embed() {
    echo "<!-- un_registering embed -->";
		remove_shortcode( 'bc_video' );
		remove_shortcode( 'jwplayer' );
	}

	public function get_scripts() {
		if ( ! $this->did_convert_elements ) {
			return array();
		}

		return array( self::$script_slug => self::$script_src );
	}

  public function bc_shortcode($atts) {
		$xlate= xlate_brightcove_1138497952_to_jwplayer();
		$jw_video_id= $xlate[$atts['video_id']];
		return $this->shortcode($jw_video_id);
  }

	public function shortcode( $attr ) {
    return $this->render($attr);
	}

	public function render( $id ) {
    $html = <<<___
      <amp-jwplayer
        data-player-id="WULyWvHs"
        data-media-id="$id" layout="responsive" width="35" height="20">
      </amp-jwplayer>
___;
    return $html;
	}

	private function build_gallery_caption($image, $index, $total) {

		$timber =  new TimberImage($image['id']);
		$index = $index + 1;

		return Timber::compile('templates/partial/caption.twig', array(
			'index' => $index,
			'total' => $total,
			'credit' => $timber->credits,
			'headline' => $timber->headline,
			'deck' => $timber->deck
		));
	}

	private function build_gallery_slide($image, $index, $total) {

		$timber = new TimberImage($image['id']);
		$tag = AMP_HTML_Utils::build_tag(
			'amp-img',
			array(
				'src' => $image['url'],
				'width' => $image['width'],
				'height' => $image['height'],
				'layout' => 'responsive',
			)
		) . $this->build_gallery_caption( $image, $index, $total ); 
		return '<div class="slide">'. $tag  . '</div>';
	}
}
