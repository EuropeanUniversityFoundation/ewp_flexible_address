<?php

namespace Drupal\ewp_flexible_address\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Locale\CountryManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ewp_flexible_address\Plugin\Field\FieldType\FlexibleAddressItem;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'ewp_flexible_address_default' widget.
 */
#[FieldWidget(
  id: 'ewp_flexible_address_default',
  label: new TranslatableMarkup('Default'),
  field_types: ['ewp_flexible_address'],
)]
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
    CountryManagerInterface $country_manager,
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

    $element[FlexibleAddressItem::RECIPIENT_NAME] = [
      '#type' => 'textfield',
      '#title' => $this->t('@label', [
        '@label' => FlexibleAddressItem::LABEL_RECIPIENT_NAME,
      ]),
      '#default_value' => $items[$delta]->recipient_name ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_LONG),
    ];

    // Option 1: addressLine format.
    $element[FlexibleAddressItem::ADDRESS_LINE_1] = [
      '#type' => 'textfield',
      '#title' => $this->t('@label', [
        '@label' => FlexibleAddressItem::LABEL_ADDRESS_LINE_1,
      ]),
      '#default_value' => $items[$delta]->address_line_1 ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_LONG),
    ];

    $element[FlexibleAddressItem::ADDRESS_LINE_2] = [
      '#type' => 'textfield',
      '#default_value' => $items[$delta]->address_line_2 ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_LONG),
    ];

    $element[FlexibleAddressItem::ADDRESS_LINE_3] = [
      '#type' => 'textfield',
      '#default_value' => $items[$delta]->address_line_3 ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_LONG),
    ];

    $element[FlexibleAddressItem::ADDRESS_LINE_4] = [
      '#type' => 'textfield',
      '#default_value' => $items[$delta]->address_line_4 ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_LONG),
    ];

    // Option 2: advanced format.
    $element[FlexibleAddressItem::BUILDING_NUMBER] = [
      '#type' => 'textfield',
      '#title' => $this->t('@label', [
        '@label' => FlexibleAddressItem::LABEL_BUILDING_NUMBER,
      ]),
      '#default_value' => $items[$delta]->building_number ?? NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_SHORT),
    ];

    $element[FlexibleAddressItem::BUILDING_NAME] = [
      '#type' => 'textfield',
      '#title' => $this->t('@label', [
        '@label' => FlexibleAddressItem::LABEL_BUILDING_NAME,
      ]),
      '#default_value' => $items[$delta]->building_name ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_LONG),
    ];

    $element[FlexibleAddressItem::STREET_NAME] = [
      '#type' => 'textfield',
      '#title' => $this->t('@label', [
        '@label' => FlexibleAddressItem::LABEL_STREET_NAME,
      ]),
      '#default_value' => $items[$delta]->street_name ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_LONG),
    ];

    $element[FlexibleAddressItem::UNIT] = [
      '#type' => 'textfield',
      '#title' => $this->t('@label', [
        '@label' => FlexibleAddressItem::LABEL_UNIT,
      ]),
      '#default_value' => $items[$delta]->unit ?? NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_SHORT),
    ];

    $element[FlexibleAddressItem::FLOOR] = [
      '#type' => 'textfield',
      '#title' => $this->t('@label', [
        '@label' => FlexibleAddressItem::LABEL_FLOOR,
      ]),
      '#default_value' => $items[$delta]->floor ?? NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_SHORT),
    ];

    $element[FlexibleAddressItem::POST_OFFICE_BOX] = [
      '#type' => 'textfield',
      '#title' => $this->t('@label', [
        '@label' => FlexibleAddressItem::LABEL_POST_OFFICE_BOX,
      ]),
      '#default_value' => $items[$delta]->post_office_box ?? NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_SHORT),
    ];

    $element[FlexibleAddressItem::DELIVERY_POINT_CODE] = [
      '#type' => 'textfield',
      '#title' => $this->t('@label', [
        '@label' => FlexibleAddressItem::LABEL_DELIVERY_POINT_CODE,
      ]),
      '#default_value' => $items[$delta]->delivery_point_code ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_LONG),
    ];

    // Common.
    $element[FlexibleAddressItem::POSTAL_CODE] = [
      '#type' => 'textfield',
      '#title' => $this->t('@label', [
        '@label' => FlexibleAddressItem::LABEL_POSTAL_CODE,
      ]),
      '#default_value' => $items[$delta]->postal_code ?? NULL,
      '#size' => 16,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_SHORT),
    ];

    $element[FlexibleAddressItem::LOCALITY] = [
      '#type' => 'textfield',
      '#title' => $this->t('@label', [
        '@label' => FlexibleAddressItem::LABEL_LOCALITY,
      ]),
      '#default_value' => $items[$delta]->locality ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_LONG),
    ];

    $element[FlexibleAddressItem::REGION] = [
      '#type' => 'textfield',
      '#title' => $this->t('@label', [
        '@label' => FlexibleAddressItem::LABEL_REGION,
      ]),
      '#default_value' => $items[$delta]->region ?? NULL,
      '#size' => 60,
      '#maxlength' => $this->getFieldSetting(FlexibleAddressItem::MAX_LONG),
    ];

    $select_options = $this->countryManager->getList();
    asort($select_options);

    $element[FlexibleAddressItem::COUNTRY] = [
      '#type' => 'select',
      '#title' => $this->t('@label', [
        '@label' => FlexibleAddressItem::LABEL_COUNTRY,
      ]),
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
