<?php

namespace Drupal\drupal_test\Plugin\Block;

/**
 * @file
 * Contains \Drupal\drupal_test\Plugin\Block\QuoteBlock.
 */

use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 *   id = "quote_block",
 *   admin_label = @Translation("Quote block"),
 * )
 */
class QuoteBlock extends BlockBase {

  public function randomQuote(){
    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://zenquotes.io/api/random",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => [],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      return "cURL Error #:" . $err;
    } else {
      $response = json_decode($response);
      $a = $response[0];
      return $a->h;
    }
  }

  public function getCacheMaxAge() {
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $block = [
      '#type' => 'markup',
      '#markup' => $this->randomQuote()
    ];
    return $block;
  }

}
