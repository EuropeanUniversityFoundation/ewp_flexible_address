<?php

namespace Drupal\ewp_flexible_address\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ewp_flexible_address_simple' formatter.
 *
 * @FieldFormatter(
 *   id = "ewp_flexible_address_simple",
 *   label = @Translation("Simple (display all)"),
 *   field_types = {
 *     "ewp_flexible_address"
 *   }
 * )
 */
class FlexibleAddressSimpleFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      // Implement default settings.
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return [
      // Implement settings form.
    ] + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $this->viewValue($item)];
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    $output = '';
    $properties = $item->getProperties();

    foreach ($properties as $key => $object) {
      // if the property has a value, print the label as well
      if ($object->getValue()) {
        $output .= $object->getDataDefinition()->getLabel() . ': ';
        $output .= $object->getValue() . '<br />';
      }
    }

    return $output;
  }

}
