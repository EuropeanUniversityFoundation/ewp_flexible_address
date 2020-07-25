<?php

namespace Drupal\ewp_flexible_address\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ewp_flexible_address_default' widget.
 *
 * @FieldWidget(
 *   id = "ewp_flexible_address_default",
 *   module = "ewp_flexible_address",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "ewp_flexible_address"
 *   }
 * )
 */
class FlexibleAddressDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      //
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    //

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    //

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = $element + [
      '#type' => 'details',
    ];

    $element['recipient_name'] = [
      '#type' => 'textfield',
      '#title' => t('Recipient name'),
      '#default_value' => isset($items[$delta]->recipient_name) ? $items[$delta]->recipient_name : NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    // Option 1: addressLine format
    $element['address_line_1'] = [
      '#type' => 'textfield',
      '#title' => t('Simple address'),
      '#default_value' => isset($items[$delta]->address_line_1) ? $items[$delta]->address_line_1 : NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    $element['address_line_2'] = [
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->address_line_2) ? $items[$delta]->address_line_2 : NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    $element['address_line_3'] = [
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->address_line_3) ? $items[$delta]->address_line_3 : NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    $element['address_line_4'] = [
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->address_line_4) ? $items[$delta]->address_line_4 : NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    // Option 2: advanced format
    $element['building_number'] = [
      '#type' => 'textfield',
      '#title' => t('Building number'),
      '#default_value' => isset($items[$delta]->building_number) ? $items[$delta]->building_number : NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting('max_length_short'),
    ];

    $element['building_name'] = [
      '#type' => 'textfield',
      '#title' => t('Building name'),
      '#default_value' => isset($items[$delta]->building_name) ? $items[$delta]->building_name : NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    $element['street_name'] = [
      '#type' => 'textfield',
      '#title' => t('Street name'),
      '#default_value' => isset($items[$delta]->street_name) ? $items[$delta]->street_name : NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    $element['unit'] = [
      '#type' => 'textfield',
      '#title' => t('Unit'),
      '#default_value' => isset($items[$delta]->unit) ? $items[$delta]->unit : NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting('max_length_short'),
    ];

    $element['floor'] = [
      '#type' => 'textfield',
      '#title' => t('Floor'),
      '#default_value' => isset($items[$delta]->floor) ? $items[$delta]->floor : NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting('max_length_short'),
    ];

    $element['post_office_box'] = [
      '#type' => 'textfield',
      '#title' => t('Post office box'),
      '#default_value' => isset($items[$delta]->post_office_box) ? $items[$delta]->post_office_box : NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting('max_length_short'),
    ];

    $element['delivery_point_code'] = [
      '#type' => 'textfield',
      '#title' => t('Delivery point code'),
      '#default_value' => isset($items[$delta]->delivery_point_code) ? $items[$delta]->delivery_point_code : NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    // Common
    $element['postal_code'] = [
      '#type' => 'textfield',
      '#title' => t('Postal code'),
      '#default_value' => isset($items[$delta]->postal_code) ? $items[$delta]->postal_code : NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting('max_length_short'),
    ];

    $element['locality'] = [
      '#type' => 'textfield',
      '#title' => t('Locality'),
      '#default_value' => isset($items[$delta]->locality) ? $items[$delta]->locality : NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    $element['region'] = [
      '#type' => 'textfield',
      '#title' => t('Region'),
      '#default_value' => isset($items[$delta]->region) ? $items[$delta]->region : NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    // see Country module
    $select_options = \Drupal::service('country_manager')->getList();
    asort($select_options);
    $element['country'] = [
      '#type' => 'select',
      '#title' => t('Country'),
      '#options' => $select_options,
      '#empty_value' => '',
      '#default_value' => (isset($items[$delta]->country) && isset($select_options[$items[$delta]->country])) ? $items[$delta]->country : NULL,
    ];

    return $element;
  }

}
