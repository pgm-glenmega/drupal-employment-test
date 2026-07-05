<?php

declare(strict_types=1);

namespace Drupal\employment_test_custom\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns a simple Hello World page.
 */
final class HelloWorldController extends ControllerBase {

  /**
   * Builds the Hello World page.
   */
  public function content(): array {
    return [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['hello-world-page'],
      ],
      'heading' => [
        '#type' => 'html_tag',
        '#tag' => 'h2',
        '#value' => $this->t('Hello World from a custom Drupal controller.'),
      ],
      'intro' => [
        '#type' => 'html_tag',
        '#tag' => 'p',
        '#value' => $this->t('This page is rendered by a custom module, route and controller created for the employment test project.'),
      ],
    ];
  }

}
