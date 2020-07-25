<?php

namespace Drupal\ewp_flexible_address\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'ewp_flexible_address' field type.
 *
 * @FieldType(
 *   id = "ewp_flexible_address",
 *   label = @Translation("Flexible address"),
 *   description = @Translation("EWP Flexible address type"),
 *   category = @Translation("EWP Contact"),
 *   default_widget = "ewp_flexible_address_default",
 *   default_formatter = "ewp_flexible_address_default"
 * )
 */
class FlexibleAddressItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return [
      'max_length_long' => 255,
      'max_length_short' => 16,
    ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Common
    $properties['recipient_name'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Recipient name'))
      ->setRequired(TRUE);

    // Option 1: addressLine format
    $properties['address_line_1'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Address line 1'))
      ->setRequired(TRUE);

    $properties['address_line_2'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Address line 2'))
      ->setRequired(TRUE);

    $properties['address_line_3'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Address line 3'))
      ->setRequired(TRUE);

    $properties['address_line_4'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Address line 4'))
      ->setRequired(TRUE);

    // Option 2: advanced format
    $properties['building_number'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Building number'))
      ->setRequired(TRUE);

    $properties['building_name'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Building name'))
      ->setRequired(TRUE);

    $properties['street_name'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Street name'))
      ->setRequired(TRUE);

    $properties['unit'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Unit'))
      ->setRequired(TRUE);

    $properties['floor'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Floor'))
      ->setRequired(TRUE);

    $properties['post_office_box'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Post office box'))
      ->setRequired(TRUE);

    $properties['delivery_point_code'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Delivery point code'))
      ->setRequired(TRUE);

    // Common
    $properties['postal_code'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Postal code'))
      ->setRequired(TRUE);

    $properties['locality'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Locality'))
      ->setRequired(TRUE);

    $properties['region'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Region'))
      ->setRequired(TRUE);

    $properties['country'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Country'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        'recipient_name' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_long'),
        ],
        // Option 1: addressLine format
        'address_line_1' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_long'),
        ],
        'address_line_2' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_long'),
        ],
        'address_line_3' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_long'),
        ],
        'address_line_4' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_long'),
        ],
        // Option 2: advanced format
        'building_number' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_short'),
        ],
        'building_name' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_long'),
        ],
        'street_name' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_long'),
        ],
        'unit' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_short'),
        ],
        'floor' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_short'),
        ],
        'post_office_box' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_short'),
        ],
        'delivery_point_code' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_long'),
        ],
        // Common
        'postal_code' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_short'),
        ],
        'locality' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_long'),
        ],
        'region' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length_long'),
        ],
        'country' => [
          'type' => 'varchar',
          'length' => 2, // double digit country code
        ],
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraints = parent::getConstraints();

    // if ($max_length = $this->getSetting('max_length')) {
    //   $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    //   $constraints[] = $constraint_manager->create('ComplexData', [
    //     'value' => [
    //       'Length' => [
    //         'max' => $max_length,
    //         'maxMessage' => t('%name: may not be longer than @max characters.', [
    //           '%name' => $this->getFieldDefinition()->getLabel(),
    //           '@max' => $max_length
    //         ]),
    //       ],
    //     ],
    //   ]);
    // }

    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $elements = [];

    $elements['max_length_long'] = [
      '#type' => 'number',
      '#title' => t('Maximum length for long fields'),
      '#default_value' => $this->getSetting('max_length_long'),
      '#required' => TRUE,
      '#description' => t('The maximum length for long fields in characters.'),
      '#min' => 1,
      '#disabled' => $has_data,
    ];

    $elements['max_length_short'] = [
      '#type' => 'number',
      '#title' => t('Maximum length for short fields'),
      '#default_value' => $this->getSetting('max_length_short'),
      '#required' => TRUE,
      '#description' => t('The maximum length for short fields in characters.'),
      '#min' => 1,
      '#disabled' => $has_data,
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    // Limit this check to the country code field
    $value = $this->get('country')->getValue();
    return $value === NULL || $value === '';
  }

}
