<?php

// =============================================================================
// VIEWS/PARTIALS/SEARCH.PHP
// -----------------------------------------------------------------------------
// Search partial.
// =============================================================================

$search_id   = ( isset( $search_id )   ) ? $search_id   : '';
$classes     = ( isset( $classes )     ) ? $classes     : [];
$custom_atts = ( isset( $custom_atts ) ) ? $custom_atts : null;
$search_display_last_query = !empty($search_display_last_query);

// Prepare Attr Values
// -------------------

$data   = cs_prepare_json_att( [ 'search' => true ] );
$action = esc_url( home_url( '/' ) );


// Prepare Atts
// ------------

$atts = array(
  'class'         => array_merge( [ 'x-search' ], $classes ),
  'data-x-search' => $data,
  'action'        => $action,
  'method'        => 'get'
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}

$atts = cs_apply_effect( $atts, $_view_data );

$atts_search_label = array(
  'class' => 'visually-hidden',
  'for'   => 's-' . $search_id
);

$atts_search_submit = array(
  'class'                => 'x-search-btn x-search-btn-submit',
  'type'                 => 'button',
  'data-x-search-submit' => '',
  'tabindex'             => 0
);

// Search input value
$value = apply_filters(
  "cs_search_query_input_value",
  $search_display_last_query
    ? get_search_query()
    : ''
);

$atts_search_input = array(
  'id'       => 's-' . $search_id,
  'class'    => 'x-search-input',
  'type'     => 'search',
  'name'     => 's',
  'value'    => $value,
  'tabindex' => 0
);

if ( ! empty( $search_placeholder ) ) {
  $atts_search_input['placeholder'] = $search_placeholder;
}

$atts_search_clear = array(
  'class'               => 'x-search-btn x-search-btn-clear',
  'type'                => 'button',
  'data-x-search-clear' => '',
  'tabindex'            => 0
);


// Prepare Button Content
// ----------------------

$text_submit = '<span class="visually-hidden">' . __( 'Submit', 'cornerstone' ) . '</span>';
$text_clear  = '<span class="visually-hidden">' . __( 'Clear', 'cornerstone' ) . '</span>';

$svg_submit = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-1 -1 25 25"><circle fill="none" stroke-width="' . $search_submit_stroke_width . '" stroke-linecap="square" stroke-miterlimit="10" cx="10" cy="10" r="9" stroke-linejoin="miter"/><line fill="none" stroke-width="' . $search_submit_stroke_width . '" stroke-linecap="square" stroke-miterlimit="10" x1="22" y1="22" x2="16.4" y2="16.4" stroke-linejoin="miter"/></svg>'; // viewBox 0 0 24 24
$svg_clear  = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-1 -1 25 25"><line fill="none" stroke-width="' . $search_clear_stroke_width . '" stroke-linecap="square" stroke-miterlimit="10" x1="19" y1="5" x2="5" y2="19" stroke-linejoin="miter"/><line fill="none" stroke-width="' . $search_clear_stroke_width . '" stroke-linecap="square" stroke-miterlimit="10" x1="19" y1="19" x2="5" y2="5" stroke-linejoin="miter"/></svg>'; // viewBox 0 0 24 24

$input = '<input ' . cs_atts($atts_search_input) . '/>';

// Output
// ------

echo cs_tag( 'form', $atts, $custom_atts, [
  cs_tag('label', $atts_search_label, __( 'Search', 'cornerstone' )),
  $input,
  cs_tag('button', $atts_search_submit, $text_submit . $svg_submit),
  cs_tag('button', $atts_search_clear, $text_clear . $svg_clear),
]);
