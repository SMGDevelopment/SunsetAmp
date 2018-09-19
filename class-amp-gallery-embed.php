<?php

require_once( AMP__DIR__ . '/includes/embeds/class-amp-gallery-embed.php' );
define("__AMP_IMAGE_CROP_HEIGHT__", 463);
define("__AMP_IMAGE_CROP_WIDTH_", 694);
define("__AMP_CAPTION_HEIGHT__", 210);

class Sunset_AMP_Gallery_Embed_Handler extends AMP_Gallery_Embed_Handler {
	private static $script_slug = 'amp-carousel';
	private static $script_src = 'https://cdn.ampproject.org/v0/amp-carousel-0.1.js';
	private static $carousel_height = 980;

	public function register_embed() {
		add_shortcode( 'gallery', array( $this, 'shortcode' ) );
	}

	public function unregister_embed() {
		remove_shortcode( 'gallery' );
	}

	public function get_scripts() {
		if ( ! $this->did_convert_elements ) {
			return array();
		}

		return array( self::$script_slug => self::$script_src );
	}

	public function shortcode( $attr ) {
		$post = get_post();

		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) ) {
				$attr['orderby'] = 'post__in';
			}
			$attr['include'] = $attr['ids'];
		}

		$atts = shortcode_atts( array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post ? $post->ID : 0,
			'include'    => '',
			'exclude'    => '',
			'size'       => array( $this->args['width'], $this->args['height'] ),
		), $attr, 'gallery' );

		$id = intval( $atts['id'] );

		if ( ! empty( $atts['include'] ) ) {
			$attachments = get_posts( array(
				'include' => $atts['include'],
				'post_status' => 'inherit',
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
				'order' => $atts['order'],
				'orderby' => $atts['orderby'],
				'fields' => 'ids',
			) );
		} elseif ( ! empty( $atts['exclude'] ) ) {
			$attachments = get_children( array(
				'post_parent' => $id,
				'exclude' => $atts['exclude'],
				'post_status' => 'inherit',
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
				'order' => $atts['order'],
				'orderby' => $atts['orderby'],
				'fields' => 'ids',
			) );
		} else {
			$attachments = get_children( array(
				'post_parent' => $id,
				'post_status' => 'inherit',
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
				'order' => $atts['order'],
				'orderby' => $atts['orderby'],
				'fields' => 'ids',
			) );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		$urls = array();
		foreach ( $attachments as $attachment_id ) {
			list( $url, $width, $height ) = wp_get_attachment_image_src( $attachment_id, $atts['size'], true );

			if ( ! $url ) {
				continue;
			}

			$urls[] = apply_filters('amp_gallery_image_params', array(
				'id' => $attachment_id,
				'url' => $url,
				'width' => $width,
				'height' => $height,
				'args' => $this->args,
			),$attachment_id);
		}
		return $this->render( array(
			'images' => $urls,
		) );
	}

	public function render( $args ) {
		$this->did_convert_elements = true;

		$args = wp_parse_args( $args, array(
			'images' => false,
		) );

		if ( empty( $args['images'] ) ) {
			return '';
		}
		$images = array();
		$captions = array();

		$height = __AMP_IMAGE_CROP_HEIGHT__ + (__AMP_CAPTION_HEIGHT__ * 2);

		$total = count($args['images']);

		$index = 0;
		foreach ( $args['images'] as $key => $image ) {
			$slide = $this->build_gallery_slide($image, $index, $total);
			$images[$key] = apply_filters('amp_gallery_images', $slide, $image);
			$index++;
		};

		$attributes = array(
			'height' => $height,
			'width' => __AMP_IMAGE_CROP_WIDTH_, 
			'layout' => 'responsive',
			'type' => 'slides',
			'controls' => '0',
			'on' => 'slideChange:AMP.setState({selectedSlide: event.index})',
			'class'  => 'carousel2',
		);
		$carousel_attributes = array();
		foreach($attributes as $key => $value) {
			$carousel_attributes[] = sprintf('%s="%s" ', $key, $value);
		}

		return '<amp-carousel [slide]="selectedSlide" id="gallery-images"' .  implode(' ', $carousel_attributes) .'">' .
				implode( PHP_EOL, $images ) .
			'</amp-carousel>'
				;
	}

	private function build_gallery_caption($image, $index, $total) {

		$timber =  new TimberImage($image['id']);
		$index = $index + 1;

		return '<figcaption class="caption"><span class=slide-info><span class=counter>' . $index . ' / ' . $total . '</span><span class=credit>' . $timber->credits . '</span></span><h2>' . $timber->headline . '</h2>' . 
			AMP_HTML_Utils::build_tag('p', array(
				'class' => 'scroll-box'
			), $timber->deck ) . '</figcaption>';
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
