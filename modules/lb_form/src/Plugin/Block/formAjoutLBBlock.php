<?php
/**
 * @file
 * Contains \Drupal\lb_form\Plugin\Block\formAjoutLBBlock.
 */
namespace Drupal\lb_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
/**
 * Provides a 'ajoutLB' block.
 *
 * @Block(
 *   id = "form_livreblanc",
 *   admin_label = @Translation("add white book Block")
 * )
 */
class formAjoutLBBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function build() {
   $entity = \Drupal::entityTypeManager()->getStorage('node')->create(array(
      'type' => 'white_books',
    ));

  $formWhiteBook = \Drupal::service('entity.form_builder')->getForm($entity);

    return array(
      '#theme' => 'formAjoutLBBlock',
      '#form' => $formWhiteBook,
    );
  }
}
