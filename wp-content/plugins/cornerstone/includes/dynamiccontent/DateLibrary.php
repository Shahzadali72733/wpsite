<?php

//use Themeco\Cornerstone\Partials\range as csRange;


namespace Themeco\Cornerstone\DynamicContent;

const DATE_GROUP = 'date';

add_action( 'cs_dynamic_content_register', function() {
  DateLibrary::register();
});

class DateLibrary {
  const DAYS = [
    'Sunday',
    'Monday',
    'Tuesday',
    'Wednesday',
    'Thursday',
    'Friday',
    'Saturday'
  ];

  const MONTHS = [
    'January', 'February', 'March',
    'April', 'May', 'June',
    'July', 'August', 'September',
    'October', 'November', 'December',
  ];

  static public function register() {
    // Templater
    add_filter( 'cs_dynamic_content_' . DATE_GROUP, [ DateLibrary::class, 'supplyField' ], 10, 4 );

    // Setup
    add_action( 'cs_dynamic_content_setup', [ DateLibrary::class, 'setup' ] );
  }

  static public function setup() {
    // Register group
    cornerstone_dynamic_content_register_group([
      'name'  => DATE_GROUP,
      'label' => __( 'Date', CS_LOCALIZE ),
    ]);

    $controlFormat = [
      'key' => 'format',
      'type' => 'text',
      'label' => __( 'Format', CS_LOCALIZE ),
    ];

    // Days of Week
    cornerstone_dynamic_content_register_field([
      'name'  => 'days_of_week',
      'group' => DATE_GROUP,
      'type'  => 'mixed',
      'label' => __( 'Days of Week', CS_LOCALIZE ),
      'controls' => [ $controlFormat ]
    ]);

    // Months of Year
    cornerstone_dynamic_content_register_field([
      'name'  => 'months_of_year',
      'group' => DATE_GROUP,
      'type'  => 'mixed',
      'label' => __( 'Months of Year', CS_LOCALIZE ),
      'controls' => [ $controlFormat ]
    ]);

  }

  // Main templater
  static public function supplyField($result, $field, $args = []) {

    // Find which type
    switch ( $field ) {
      case 'days_of_week':
        $format = cs_get_array_value($args, 'format', 'l');
        $result = static::formatLoop(static::DAYS, $format);
        break;

      case 'months_of_year':
        $format = cs_get_array_value($args, 'format', 'F');
        $result = static::formatLoop(static::MONTHS, $format);
        break;
    }

    return $result;
  }

  /**
   * Loop dates valid for strtotime
   */
  static private function formatLoop($dates, $format = "M") {
    $out = [];
    foreach ($dates as $dateString) {
      // Add using format
      $out[] = __(
        date($format, strtotime($dateString))
      );
    }

    return $out;
  }
}
