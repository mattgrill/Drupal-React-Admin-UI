<?php

namespace Drupal\drupal_admin_ui\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller for the react Permissions page..
 */
class PermissionsController extends ControllerBase {

  /**
   * Permissions info.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The render array.
   */
  public function get() {
    // @todo Actually get permissions.
    return new JsonResponse([
      'this' => 'that',
    ]);
  }

}
