<?php
namespace Drupal\drupal_test\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides route responses for the Drupal_test module.
 */
class TestController extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function myPage() {
    return [
      '#markup' => [
        '#type' => 'textfield',
        '#type' => 'button'
      ],
    ];
  }

}
