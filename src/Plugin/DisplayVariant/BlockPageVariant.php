<?php

namespace Drupal\drupal_admin_ui\Plugin\DisplayVariant;

use Drupal\block\Plugin\DisplayVariant\BlockPageVariant as CoreVariant;
use Drupal\Core\Block\MainContentBlockPluginInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Render\RenderableInterface;
use Drupal\Core\Render\Element\StatusMessages;

/**
 * Provides a page display converts blocks to settings.
 *
 * @PageDisplayVariant(
 *   id = "drupal_admin_ui_page",
 *   admin_label = @Translation("Page with blocks")
 * )
 */
class BlockPageVariant extends CoreVariant {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = parent::build();
    $attached_blocks = [];
    foreach (Element::children($build) as $region) {
      foreach (Element::children($build[$region]) as $block_id) {
        $block = $build[$region][$block_id];
        /** @var \Drupal\Core\Block\BlockManagerInterface $block_manager */
        $block_manager = \Drupal::service('plugin.manager.block');
        if (!empty($block['#lazy_builder'])) {
          $block = call_user_func_array($block['#lazy_builder'][0], $block['#lazy_builder'][1]);
        }
        $definition = $block_manager->getDefinition($block['#plugin_id']);
        // Do not process main block.
        if (!is_subclass_of($definition['class'], MainContentBlockPluginInterface::class)) {

          if (!empty($block['#pre_render'])) {
            // Build the block by it's preRender functions.
            foreach ($block['#pre_render'] as $callback) {
              $block = call_user_func($callback, $block);
            }
          }
          $block_content = $this->attachedBlockContent($block);
          // @todo Should this be done later in the render process?
          if (!empty($block_content['#type']) && $block_content['#type'] === 'status_messages') {
            $block_content = StatusMessages::renderMessages(NULL);
          }
          $attached_blocks[$region][$block_id] = $block_content;
          unset($build[$region][$block_id]);
        }
      }
    }
    $this->renderRenderables($attached_blocks);
    $this->convertToStrings($attached_blocks);
    $this->removeUnneeded($attached_blocks);
    $build['#attached']['drupalSettings']['drupal_admin_ui']['regions'] = $attached_blocks;

    return $build;
  }

  /**
   * Return the content of block.
   *
   * @param array $built_block
   *   The built block.
   *
   * @return array
   *   Content render array.
   */
  protected function attachedBlockContent(array $built_block) {
    if (!empty($built_block['content'])) {
      return $built_block['content'];
    }
    return [];
  }

  /**
   * Render all renderable elements.
   *
   * @param array $elements
   *   The elements.
   */
  protected function renderRenderables(array &$elements) {
    foreach ($elements as &$element) {
      if (is_array($element)) {
        $this->renderRenderables($element);
      }
      if ($element instanceof RenderableInterface) {
        $element = $element->toRenderable();
      }
    }
  }

  /**
   * Convert elements to strings that can be converted.
   *
   * @param array $elements
   *   The elements.
   */
  private function convertToStrings(array &$elements) {
    foreach ($elements as &$element) {
      if (is_array($element)) {
        $this->convertToStrings($element);
      }
      if (is_object($element) && method_exists($element, 'toString')) {
        $element = $element->toString();
      }
    }
  }

  /**
   * Remove all elements not need for the client.
   *
   * @param array $elements
   *   The elements.
   */
  protected function removeUnneeded(array &$elements) {
    foreach ($elements as &$element) {
      if (is_array($element)) {
        $this->removeUnneeded($element);
      }
    }
    unset($elements['#cache'], $elements['#access']);
  }

}
