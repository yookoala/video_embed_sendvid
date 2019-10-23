<?php

namespace Drupal\video_embed_sendvid\Plugin\video_embed_field\Provider;

use Drupal\video_embed_field\ProviderPluginBase;

/**
 * @VideoEmbedProvider(
 *   id = "sendvid",
 *   title = @Translation("Sendvid")
 * )
 */
class Sendvid extends ProviderPluginBase {

  /**
   * {@inheritdoc}
   */
  public function renderEmbedCode($width, $height, $autoplay) {
    // @todo, consider using the JavaScript version, however iframes are less
    // impact to page load and also don't grant JS access to your website to
    // Facebook.
    // <iframe width="560" height="315" src="//sendvid.com/embed/nys3cjb2" frameborder="0" allowfullscreen></iframe>
    return [
      '#type' => 'html_tag',
      '#tag' => 'iframe',
      '#attributes' => [
        'width' => $width,
        'height' => $height,
        'frameborder' => '0',
        'allowfullscreen' => 'allowfullscreen',
        'src' => sprintf('https://sendvid.com/embed/%s', $this->getVideoId()),
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getRemoteThumbnailUrl() {
    // TODO: Anyway to cache this? Any need?
    $contents = file_get_contents(sprintf('https://sendvid.com/%s', $this->getVideoId()));
    $document = new \DOMDocument;
    $document->loadHTML($contents);
    $xpath = new \DOMXPath($document);
    $result = $xpath->query('//meta[@property=\'og:image\']');
    if ($result->count() > 0) {
      return $result->item(0)->getAttribute('content');
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public static function getIdFromInput($input) {
    preg_match('/^(http|https)?:\/\/(www\.)?sendvid.com\/(embed\/|)(?<id>[a-z0-9]+)$/', $input, $matches);
    return isset($matches['id']) ? $matches['id'] : FALSE;
  }

}
