<?php

namespace Drupal\ewp_flexible_address\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Locale\CountryManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
class FlexibleAddressDefaultWidget extends WidgetBase implements ContainerFactoryPluginInterface {

  /**
   * The country manager.
   *
   * @var \Drupal\Core\Locale\CountryManagerInterface
   */
  protected $countryManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(
    $plugin_id,
    $plugin_definition,
    FieldDefinitionInterface $field_definition,
    array $settings,
    array $third_party_settings,
    CountryManagerInterface $country_manager
  ) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);
    $this->countryManager = $country_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['third_party_settings'],
      $container->get('country_manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
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
      '#title' => $this->t('Recipient name'),
      '#default_value' => $items[$delta]->recipient_name ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    // Option 1: addressLine format.
    $element['address_line_1'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Simple address'),
      '#default_value' => $items[$delta]->address_line_1 ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    $element['address_line_2'] = [
      '#type' => 'textfield',
      '#default_value' => $items[$delta]->address_line_2 ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    $element['address_line_3'] = [
      '#type' => 'textfield',
      '#default_value' => $items[$delta]->address_line_3 ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    $element['address_line_4'] = [
      '#type' => 'textfield',
      '#default_value' => $items[$delta]->address_line_4 ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    // Option 2: advanced format.
    $element['building_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Building number'),
      '#default_value' => $items[$delta]->building_number ?? NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting('max_length_short'),
    ];

    $element['building_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Building name'),
      '#default_value' => $items[$delta]->building_name ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    $element['street_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Street name'),
      '#default_value' => $items[$delta]->street_name ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    $element['unit'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Unit'),
      '#default_value' => $items[$delta]->unit ?? NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting('max_length_short'),
    ];

    $element['floor'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Floor'),
      '#default_value' => $items[$delta]->floor ?? NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting('max_length_short'),
    ];

    $element['post_office_box'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Post office box'),
      '#default_value' => $items[$delta]->post_office_box ?? NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting('max_length_short'),
    ];

    $element['delivery_point_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Delivery point code'),
      '#default_value' => $items[$delta]->delivery_point_code ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    // Common
    $element['postal_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Postal code'),
      '#default_value' => $items[$delta]->postal_code ?? NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting('max_length_short'),
    ];

    $element['locality'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Locality'),
      '#default_value' => $items[$delta]->locality ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    $element['region'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Region'),
      '#default_value' => $items[$delta]->region ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting('max_length_long'),
    ];

    $select_options = $this->countryManager->getList();
    asort($select_options);

    $element['country'] = [
      '#type' => 'select',
      '#title' => $this->t('Country'),
      '#options' => $select_options,
      '#empty_value' => '',
      '#default_value' => (
        isset($items[$delta]->country) &&
        isset($select_options[$items[$delta]->country])
      ) ? $items[$delta]->country : NULL,
    ];

    return $element;
  }

}
