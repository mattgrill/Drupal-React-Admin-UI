<?php
  namespace Drupal\drupal_admin_ui\Controller;
  use Drupal\Core\Controller\ControllerBase;
  /**
   * Controller for the react dblog.
   */
  class ReactPermissionsPageController extends ControllerBase {
    /**
     * Renders the react dblog.
     *
     * @return array
     *   The render array.
     */
    public function overview() {
      $build = [
        '#attached' => [
          'library' => [
            'drupal_admin_ui/permissions',
          ],
          'drupalSettings' => [
            'drupal_admin_ui' => [
              'url' => \Drupal::service('path.current')->getPath(),
            ],
          ],
        ],
        '#markup' => '<div id="root" />'
      ];
      return $build;
    }
  }
