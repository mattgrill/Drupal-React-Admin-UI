<?php

namespace Drupal\drupal_admin_ui\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\config_translation\ConfigMapperManagerInterface;
use Drupal\Core\Routing\RoutingEvents;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    $alterRoutes = [
      'user.admin_permissions' => 'Drupal\drupal_admin_ui\Controller\ReactPermissionsPageController::overview'
    ];
    foreach ($alterRoutes as $route_name => $controller) {
      $route = $collection->get($route_name);
      $route->setDefault('_controller', $controller);
    }

  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // Come after field_ui.
    $events[RoutingEvents::ALTER] = ['onAlterRoutes', -500];
    return $events;
  }

}
