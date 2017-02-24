<?php

/**
 * @file
 * Contains \Drupal\poll\PollViewBuilder.
 */

namespace Drupal\poll;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityViewBuilder;

/**
 * Render controller for polls.
 */
class PollViewBuilder extends EntityViewBuilder {

  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $entity, $view_mode = 'full', $langcode = NULL) {
    $entity = $this->entityManager->getTranslationFromContext($entity, $langcode);

    // Ajax request might send the view mode as a GET argument, use that
    // instead.
    if (\Drupal::request()->query->has('view_mode')) {
      $view_mode = \Drupal::request()->query->get('view_mode');
    }

    $output['#poll'] = $entity;
    $output['poll'] = array(
      '#lazy_builder' => [
        'poll.post_render_cache:renderViewForm',
        [
          'id' => $entity->id(),
          'view_mode' => $view_mode,
          'langcode' => $entity->language()->getId(),
        ],
      ],
      '#create_placeholder' => TRUE,
      '#cache' => [
        'tags' => $entity->getCacheTags(),
      ],
    );

    return $output;

  }

}
