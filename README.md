# EWP Flexible Address

Drupal implementation of the EWP Flexible Address Type.

See the **Erasmus Without Paper** specification for more information:

  - [EWP Address Data Types](https://github.com/erasmus-without-paper/ewp-specs-types-address/tree/v1.0.1)

## Installation

Include the repository in your project's `composer.json` file:

    "repositories": [
        ...
        {
            "type": "vcs",
            "url": "https://github.com/EuropeanUniversityFoundation/ewp_flexible_address"
        }
    ],

Then you can require the package as usual:

    composer require euf/ewp_flexible_address

Finally, install the module:

    drush en ewp_flexible_address

## Usage

The **Flexible Address** field type becomes available in the Field UI so it can be added to any fieldable entity like any other field type.
