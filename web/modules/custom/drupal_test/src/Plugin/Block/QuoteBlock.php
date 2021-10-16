<?php

namespace Drupal\drupal_test\Plugin\Block;

/**
 * @file
 * Contains \Drupal\drupal_test\Plugin\Block\QuoteBlock.
 */

use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
use GuzzleHttp\Client;

/**
 * This block is for random quote.
 *
 * @Block(
 *   id = "quote_block",
 *   admin_label = @Translation("Quote block"),
 * )
 */
class QuoteBlock extends BlockBase {

  /**
   * Makes a request to quote api.
   *
   * @return mixed
   *   The quote.
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function randomQuote() {
    $client = new Client();
    $response = $client->get('https://zenquotes.io/api/random');
    $decoded_response = json_decode($response->getBody());
    $data = $decoded_response[0];
    return $data->h;
  }

  /**
   * {@inheritDoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

  /**
   * {@inheritDoc}
   */
  public function build() {
    return [
      '#type' => 'markup',
      '#markup' => $this->randomQuote()
    ];
  }

}
