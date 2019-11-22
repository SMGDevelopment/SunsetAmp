<?php


class AMPFORWP_Slideshow_Sanitizer extends AMP_Base_Sanitizer {
  public function get_scripts() {

    return array( 
      'amp-list' => 'https://cdn.ampproject.org/v0/amp-list-0.1.js',
      'amp-carousel' => 'https://cdn.ampproject.org/v0/amp-carousel-0.1.js' );
  }

  public function sanitize() {
    $body = $this->get_body_node();
    $slideshow = AMP_DOM_Utils::create_node( $this->dom, 'amp-carousel', array(
      'id' => 'gallery-images',
      'width' => 694,
      'height' => 883,
      'layout' => 'responsive',
      'type' => 'slides',
      'on' => 'slideChange:AMP.setState({selectedSlide: event.index})',
      'class' => 'carousel2',
    ) );

    $classname = 'wp-block-cgb-block-block-galleria';
    $finder = new DomXPath($this->dom);
    $nodes = $finder->query("//*[contains(@class, '$classname')]");

    $slideContent = [];
    if($nodes->length > 0) {
      $slideClass = 'wp-block-cgb-block-inner-galleria';
      $slides = $finder->query("//*[contains(@class, '$slideClass')]");
      $nodes = array();
      foreach($slides as $node) {
        $nodes[] = $node;
      }
      $attributes = array_map(array($this, "getAttributesBySlide"), $nodes);

      $slideNodes = array_map(array($this, "getSlideFromAttribute"), $attributes);
      
      $frag = $this->dom->createDocumentFragment();

      $frag->appendXml(join(" ", $slideNodes));

      $domNode = $this->dom->getElementsByTagName( 'div' )->item(0);

      $slideshow->appendChild($frag->cloneNode( true ));

      return $domNode->parentNode->replaceChild($slideshow, $domNode);
      
    }

  }

  private function getSlideFromAttribute($slide) {
    return '<div class="slide">' . AMP_HTML_Utils::build_tag(
      'amp-img',
      array(
        'src' => $slide['image'],
        'width' => 694,
        'height' => 463,
        'layout' => 'responsive',
      )
    ) . Timber::compile('templates/partial/caption.twig', $slide) . '</div>';
  }

  private function getAttributesBySlide($slide) {
    $attributes = array(
      "headline" => "//h2",
      'index' => "//span[@class=\"slide-count\"]",
      "total" => "//span[@class=\"total-slides\"]",
      "credit" => "//span[@class=\"credit\"]",
      "image" => "//div[contains(@class, 'lazy-image')]/@data-src",
      "deck" => "//div[contains(@class, 'caption')]"
    );
    $docFrag = new DOMDocument();
    $node = $docFrag->importNode($slide, true);
    $docFrag->appendChild($node);
    $finder = new DomXPath($docFrag);
    
    foreach($attributes as $key=>$selector){
      $el = $finder->query($selector);

      if($key == 'deck') {
        $slideContent[$key] = $el->item(0)->C14N();
      }else{
        $slideContent[$key] = $el->item(0)->nodeValue;
      }
    }

    return $slideContent;
  }
}