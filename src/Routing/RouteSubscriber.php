<?php

namespace Drupal\drupal_admin_ui\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\Core\Routing\RoutingEvents;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Routes the this module should take over that don't have callback routes.
    $take_over_routes = $this->getTakeOverRoutes();
    $call_back_routes = [];
    // Find all additional routes that this module should take over by checking
    // the '_admin_related_route' route option.
    foreach ($collection->getIterator() as $route_key => $route) {
      if ($related_route_name = $route->getOption('_admin_related_route')) {
        $related_route = $collection->get($related_route_name);
        // Take over this route.
        $take_over_routes[] = $related_route_name;
        // Store the callback route.
        $call_back_routes[$related_route_name] = $route_key;
        // Keep all the same requirements as the related route.
        // The React callbacks should have the same permissions as the related
        // route.
        $route->setRequirements($related_route->getRequirements());
        // The format for the React callback is always json.
        // @todo should callbacks be REST resources?
        $route->setRequirement('_format', 'json');
      }
    }
    foreach ($take_over_routes as $route_name) {
      $route = $collection->get($route_name);
      $route->setDefault('_controller', 'Drupal\drupal_admin_ui\Controller\DefaultController::getAppRoute');
      $route->setOption('_drupal_admin_ui.route', TRUE);
      if (isset($call_back_routes[$route_name])) {
        // We have callback for this route.
        // This will be returned in drupalSettings.
        // @see \Drupal\drupal_admin_ui\Controller\DefaultController::getAppRoute().
        $route->setOption('_drupal_admin_ui.callback', $call_back_routes[$route_name]);
      }
      // Add a json version of each route we take over to return blocks.
      $collection->add("$route_name.json", $this->createJsonRoute($route));
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

  /**
   * Create a duplicate route using json format.
   *
   * @param \Symfony\Component\Routing\Route $route
   *   The original route.
   *
   * @return \Symfony\Component\Routing\Route
   *   The json route. It will be identical to the original route except for the
   *   controller and the format.
   */
  protected function createJsonRoute(Route $route) {
    // Create a json route for each admin route.
    $json_route = new Route(
      $route->getPath(),
      $route->getDefaults(),
      $route->getRequirements(),
      $route->getOptions()
    );
    $json_route->setDefault('_controller', 'Drupal\drupal_admin_ui\Controller\DefaultController::getBlocks');
    $json_route->setRequirement('_format', 'json');
    return $json_route;
  }

  /**
   * The names of the routes to take over.
   *
   * This only returns routes that don't have an associated callback route
   * declared in drupal_admin_ui.routing.yml.
   *
   * @todo Move these to routing.yml.
   *
   * @return string[]
   *   The route names.
   */
  protected function getTakeOverRoutes() {
    $take_over_routes = [
      'entity.user.collection',
    ];
    return $take_over_routes;
  }

}
