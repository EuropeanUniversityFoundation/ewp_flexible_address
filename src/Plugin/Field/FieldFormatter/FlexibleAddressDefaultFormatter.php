<?php

namespace Drupal\ewp_flexible_address\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Locale\CountryManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\ewp_flexible_address\Plugin\Field\FieldType\FlexibleAddressItem;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
class FlexibleAddressDefaultFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

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
    $label,
    $view_mode,
    array $third_party_settings,
    CountryManagerInterface $country_manager
  ) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
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
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('country_manager')
    );
  }

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
      // Determine which address format to display.
      if (
        isset($item->building_number) ||
        isset($item->building_name) ||
        isset($item->street_name) ||
        isset($item->unit) ||
        isset($item->floor) ||
        isset($item->post_office_box) ||
        isset($item->delivery_point_code)
      ) {
        // At least one structured format field is present.
        $address_line = NULL;
      } else {
        // Assemble the fallback format.
        $address_line = [];
        $address_lines = [
          FlexibleAddressItem::ADDRESS_LINE_1,
          FlexibleAddressItem::ADDRESS_LINE_2,
          FlexibleAddressItem::ADDRESS_LINE_3,
          FlexibleAddressItem::ADDRESS_LINE_4,
        ];
        foreach ($address_lines as $line) {
          if ($item->$line) {
            $address_line[] .= $item->$line;
          }
        }
      }

      $country_list = $this->countryManager->getList();
      $country = ($item->country) ? $country_list[$item->country] : NULL;

      $elements[$delta] = [
        '#theme' => 'ewp_flexible_address_default',
        '#recipient_name' => $item->recipient_name ?? NULL,
        '#address_line' => $address_line,
        '#building_number' => $item->building_number ?? NULL,
        '#building_name' => $item->building_name ?? NULL,
        '#street_name' => $item->street_name ?? NULL,
        '#unit' => $item->unit ?? NULL,
        '#floor' => $item->floor ?? NULL,
        '#post_office_box' => $item->post_office_box ?? NULL,
        '#delivery_point_code' => $item->delivery_point_code ?? NULL,
        '#postal_code' => $item->postal_code ?? NULL,
        '#locality' => $item->locality ?? NULL,
        '#region' => $item->region ?? NULL,
        '#country' => $country,
      ];
    }

    return $elements;
  }

}
