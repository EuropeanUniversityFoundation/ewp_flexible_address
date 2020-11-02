<?php

namespace Drupal\ewp_flexible_address\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ewp_flexible_address_default' formatter.
 *
 * @FieldFormatter(
 *   id = "ewp_flexible_address_default",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "ewp_flexible_address"
 *   }
 * )
 */
class FlexibleAddressDefaultFormatter extends FormatterBase {

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
      $recipient_name = ($item->recipient_name) ? $item->recipient_name : NULL ;
      // Structured format fields
      $building_number = ($item->building_number) ? $item->building_number : NULL ;
      $building_name = ($item->building_name) ? $item->building_name : NULL ;
      $street_name = ($item->street_name) ? $item->street_name : NULL ;
      $unit = ($item->unit) ? $item->unit : NULL ;
      $floor = ($item->floor) ? $item->floor : NULL ;
      $post_office_box = ($item->post_office_box) ? $item->post_office_box : NULL ;
      $delivery_point_code = ($item->delivery_point_code) ? $item->delivery_point_code : NULL ;
      // Check if fallback mode is needed
      if ($building_number || $building_name || $street_name || $unit || $floor || $post_office_box || $delivery_point_code) {
        // At least one structured format field is present
        $address_line = NULL;
      } else {
        // Assemble the fallback format
        $address_line = [];
        $address_lines = [
          'address_line_1',
          'address_line_2',
          'address_line_3',
          'address_line_4',
        ];
        foreach ($address_lines as $line) {
          if ($item->$line) {
            $address_line[] .= $item->$line;
          }
        }
      }
      // Common fields
      $postal_code = ($item->postal_code) ? $item->postal_code : NULL ;
      $locality = ($item->locality) ? $item->locality : NULL ;
      $region = ($item->region) ? $item->region : NULL ;
      if ($item->country) {
        // Get the country name
        $countries = \Drupal::service('country_manager')->getList();
        $country = $countries[$item->country];
      } else {
        $country = NULL;
      }

      $elements[$delta] = [
        '#theme' => 'ewp_flexible_address_default',
        '#recipient_name' => $recipient_name,
        '#address_line' => $address_line,
        '#building_number' => $building_number,
        '#building_name' => $building_name,
        '#street_name' => $street_name,
        '#unit' => $unit,
        '#floor' => $floor,
        '#post_office_box' => $post_office_box,
        '#delivery_point_code' => $delivery_point_code,
        '#postal_code' => $postal_code,
        '#locality' => $locality,
        '#region' => $region,
        '#country' => $country,
      ];
    }

    return $elements;
  }

}
