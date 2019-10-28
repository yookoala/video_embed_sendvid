<?php

namespace Drupal\Tests\video_embed_sendvid\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\video_embed_sendvid\Plugin\video_embed_field\Provider\Sendvid;

/**
 * Test that URL parsing for the provider is functioning.
 *
 * @group video_embed_facebook
 */
class ProviderUrlParseTest extends UnitTestCase {

  /**
   * @dataProvider urlsWithExpectedIds
   *
   * Test URL parsing works as expected.
   */
  public function testUrlParsing($url, $expected) {
    $this->assertEquals($expected, Sendvid::getIdFromInput($url));
  }

  /**
   * A data provider for URL parsing test cases.
   *
   * @return array
   *   An array of test cases.
   */
  public function urlsWithExpectedIds() {
    return [
      [
        'http://sendvid.com/nys3cjb2',
        'nys3cjb2',
      ],
      [
        'https://sendvid.com/nys3cjb2',
        'nys3cjb2',
      ],
      [
        'http://sendvid.com/embed/nys3cjb2',
        'nys3cjb2',
      ],
      [
        'https://sendvid.com/help/about',
        FALSE,
      ],
    ];
  }
}
