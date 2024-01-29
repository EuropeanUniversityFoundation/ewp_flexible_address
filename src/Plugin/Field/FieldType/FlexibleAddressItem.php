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
 *   description = @Translation("Stores a collection of sub-fields describing an address.",
 *   default_widget = "ewp_flexible_address_default",
 *   default_formatter = "ewp_flexible_address_default"
 * )
 */
class FlexibleAddressItem extends FieldItemBase {

  const MAX_LONG = 'max_length_long';
  const MAX_SHORT = 'max_length_short';

  const RECIPIENT_NAME = 'recipient_name';
  const LABEL_RECIPIENT_NAME = 'Recipient name';

  const ADDRESS_LINE_1 = 'address_line_1';
  const LABEL_ADDRESS_LINE_1 = 'Address line 1';

  const ADDRESS_LINE_2 = 'address_line_2';
  const LABEL_ADDRESS_LINE_2 = 'Address line 2';

  const ADDRESS_LINE_3 = 'address_line_3';
  const LABEL_ADDRESS_LINE_3 = 'Address line 3';

  const ADDRESS_LINE_4 = 'address_line_4';
  const LABEL_ADDRESS_LINE_4 = 'Address line 4';

  const BUILDING_NUMBER = 'building_number';
  const LABEL_BUILDING_NUMBER = 'Building number';

  const BUILDING_NAME = 'building_name';
  const LABEL_BUILDING_NAME = 'Building name';

  const STREET_NAME = 'street_name';
  const LABEL_STREET_NAME = 'Street name';

  const UNIT = 'unit';
  const LABEL_UNIT = 'Unit';

  const FLOOR = 'floor';
  const LABEL_FLOOR = 'Floor';

  const POST_OFFICE_BOX = 'post_office_box';
  const LABEL_POST_OFFICE_BOX = 'Post office box';

  const DELIVERY_POINT_CODE = 'delivery_point_code';
  const LABEL_DELIVERY_POINT_CODE = 'Delivery point code';

  const POSTAL_CODE = 'postal_code';
  const LABEL_POSTAL_CODE = 'Postal code';

  const LOCALITY = 'locality';
  const LABEL_LOCALITY = 'Locality';

  const REGION = 'region';
  const LABEL_REGION = 'Region';

  const COUNTRY = 'country';
  const LABEL_COUNTRY = 'Country';


  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return [
      self::MAX_LONG => 255,
      self::MAX_SHORT => 16,
    ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Common.
    $properties[self::RECIPIENT_NAME] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_RECIPIENT_NAME))
      ->setRequired(TRUE);

    // Option 1: addressLine format.
    $properties[self::ADDRESS_LINE_1] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_ADDRESS_LINE_1));

    $properties[self::ADDRESS_LINE_2] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_ADDRESS_LINE_2));

    $properties[self::ADDRESS_LINE_3] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_ADDRESS_LINE_3));

    $properties[self::ADDRESS_LINE_4] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_ADDRESS_LINE_4));

    // Option 2: advanced format.
    $properties[self::BUILDING_NUMBER] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_BUILDING_NUMBER));

    $properties[self::BUILDING_NAME] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_BUILDING_NAME));

    $properties[self::STREET_NAME] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_STREET_NAME));

    $properties[self::UNIT] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_UNIT));

    $properties[self::FLOOR] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_FLOOR));

    $properties[self::POST_OFFICE_BOX] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_POST_OFFICE_BOX));

    $properties[self::DELIVERY_POINT_CODE] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_DELIVERY_POINT_CODE));

    // Common.
    $properties[self::POSTAL_CODE] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_POSTAL_CODE));

    $properties[self::LOCALITY] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_LOCALITY));

    $properties[self::REGION] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_REGION));

    $properties[self::COUNTRY] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_COUNTRY))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        self::RECIPIENT_NAME => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_LONG),
        ],
        // Option 1: addressLine format.
        self::ADDRESS_LINE_1 => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_LONG),
        ],
        self::ADDRESS_LINE_2 => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_LONG),
        ],
        self::ADDRESS_LINE_3 => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_LONG),
        ],
        self::ADDRESS_LINE_4 => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_LONG),
        ],
        // Option 2: advanced format.
        self::BUILDING_NUMBER => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_SHORT),
        ],
        self::BUILDING_NAME => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_LONG),
        ],
        self::STREET_NAME => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_LONG),
        ],
        self::UNIT => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_SHORT),
        ],
        self::FLOOR => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_SHORT),
        ],
        self::POST_OFFICE_BOX => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_SHORT),
        ],
        self::DELIVERY_POINT_CODE => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_LONG),
        ],
        // Common.
        self::POSTAL_CODE => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_SHORT),
        ],
        self::LOCALITY => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_LONG),
        ],
        self::REGION => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting(self::MAX_LONG),
        ],
        self::COUNTRY => [
          'type' => 'varchar',
          'length' => 2, // ISO 3166-1 alpha-2 country code.
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
    $constraint_manager = \Drupal::typedDataManager()
      ->getValidationConstraintManager();

    $field_definition = $this->getFieldDefinition();
    $field_label = $field_definition->getLabel();

    $constraints[] = $constraint_manager->create('ComplexData', [
      self::RECIPIENT_NAME => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_LONG),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_RECIPIENT_NAME,
              '@max' => (int) $field_definition->getSetting(self::MAX_LONG),
            ]),
        ],
      ],
      self::ADDRESS_LINE_1 => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_LONG),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_ADDRESS_LINE_1,
              '@max' => (int) $field_definition->getSetting(self::MAX_LONG),
            ]),
        ],
      ],
      self::ADDRESS_LINE_2 => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_LONG),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_ADDRESS_LINE_2,
              '@max' => (int) $field_definition->getSetting(self::MAX_LONG),
            ]),
        ],
      ],
      self::ADDRESS_LINE_3 => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_LONG),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_ADDRESS_LINE_3,
              '@max' => (int) $field_definition->getSetting(self::MAX_LONG),
            ]),
        ],
      ],
      self::ADDRESS_LINE_4 => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_LONG),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_ADDRESS_LINE_4,
              '@max' => (int) $field_definition->getSetting(self::MAX_LONG),
            ]),
        ],
      ],
      self::BUILDING_NUMBER => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_SHORT),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_BUILDING_NUMBER,
              '@max' => (int) $field_definition->getSetting(self::MAX_SHORT),
            ]),
        ],
      ],
      self::BUILDING_NAME => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_LONG),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_BUILDING_NAME,
              '@max' => (int) $field_definition->getSetting(self::MAX_LONG),
            ]),
        ],
      ],
      self::STREET_NAME => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_LONG),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_STREET_NAME,
              '@max' => (int) $field_definition->getSetting(self::MAX_LONG),
            ]),
        ],
      ],
      self::UNIT => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_SHORT),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_UNIT,
              '@max' => (int) $field_definition->getSetting(self::MAX_SHORT),
            ]),
        ],
      ],
      self::FLOOR => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_SHORT),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_FLOOR,
              '@max' => (int) $field_definition->getSetting(self::MAX_SHORT),
            ]),
        ],
      ],
      self::POST_OFFICE_BOX => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_SHORT),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_POST_OFFICE_BOX,
              '@max' => (int) $field_definition->getSetting(self::MAX_SHORT),
            ]),
        ],
      ],
      self::DELIVERY_POINT_CODE => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_LONG),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_DELIVERY_POINT_CODE,
              '@max' => (int) $field_definition->getSetting(self::MAX_LONG),
            ]),
        ],
      ],
      self::POSTAL_CODE => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_SHORT),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_POSTAL_CODE,
              '@max' => (int) $field_definition->getSetting(self::MAX_SHORT),
            ]),
        ],
      ],
      self::LOCALITY => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_LONG),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_LOCALITY,
              '@max' => (int) $field_definition->getSetting(self::MAX_LONG),
            ]),
        ],
      ],
      self::REGION => [
        'Length' => [
          'max' => (int) $field_definition->getSetting(self::MAX_LONG),
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_REGION,
              '@max' => (int) $field_definition->getSetting(self::MAX_LONG),
            ]),
        ],
      ],
      self::COUNTRY => [
        'Regex' => [
          'pattern' => "/^[A-Z]{2}$/",
          'message' => $this->t('%field_label: %prop must match the @format.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_COUNTRY,
              '@format' => 'ISO 3166-1 alpha-2 format',
            ]),
        ],
      ],
    ]);

    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $elements = [];

    $text = 'The maximum length for @length fields in characters.';

    $elements[self::MAX_LONG] = [
      '#type' => 'number',
      '#title' => t('Maximum length for long fields'),
      '#default_value' => $this->getSetting(self::MAX_LONG),
      '#required' => TRUE,
      '#description' => $this->t($text, ['@length' => 'long']),
      '#min' => 1,
      '#disabled' => $has_data,
    ];

    $elements[self::MAX_SHORT] = [
      '#type' => 'number',
      '#title' => t('Maximum length for short fields'),
      '#default_value' => $this->getSetting(self::MAX_SHORT),
      '#required' => TRUE,
      '#description' => $this->t($text, ['@length' => 'short']),
      '#min' => 1,
      '#disabled' => $has_data,
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    // Limit this check to the country code field.
    $value = $this->get(self::COUNTRY)->getValue();
    return $value === NULL || $value === '';
  }

}
