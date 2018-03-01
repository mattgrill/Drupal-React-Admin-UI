<?php

namespace Drupal\drupal_admin_ui\EventSubscriber;

use Drupal\Core\Render\PageDisplayVariantSelectionEvent;
use Drupal\Core\Render\RenderEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Selects the Drupal Admin UI block variant.
 *
 * @see \Drupal\drupal_admin_ui\Plugin\DisplayVariant\BlockPageVariant
 */
class BlockPageDisplayVariantSubscriber implements EventSubscriberInterface {

  /**
   * Selects the block page display variant.
   *
   * @param \Drupal\Core\Render\PageDisplayVariantSelectionEvent $event
   *   The event to process.
   */
  public function onSelectPageDisplayVariant(PageDisplayVariantSelectionEvent $event) {
    if ($event->getRouteMatch()->getRouteObject()->getOption('_admin_route')) {
      $event->setPluginId('drupal_admin_ui_page');
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[RenderEvents::SELECT_PAGE_DISPLAY_VARIANT][] = ['onSelectPageDisplayVariant', -1000];
    return $events;
  }

}
