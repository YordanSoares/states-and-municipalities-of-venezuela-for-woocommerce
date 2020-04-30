<?php

/**
 * VENEZUELAN STATES
 * List of 24 States of Venezuela
 */


if ( ! function_exists('smvw_venezuelan_states' )) {
  
  function smvw_venezuelan_states($states) {
    $states['VE'] = array(
      'AM' => 'Amazonas',
      'AN' => 'Anzoátegui',
      'AP' => 'Apure',
      'AR' => 'Aragua',
      'BA' => 'Barinas',
      'BO' => 'Bolívar',
      'CA' => 'Carabobo',
      'CO' => 'Cojedes',
      'DE' => 'Delta Amacuro',
      'DC' => 'Distrito Capital',
      'FA' => 'Falcón',
      'GU' => 'Guárico',
      'LA' => 'Lara',
      'LG' => 'La Guaira',
      'ME' => 'Mérida',
      'MI' => 'Miranda',
      'MO' => 'Monagas',
      'NE' => 'Nueva Esparta',
      'PO' => 'Portuguesa',
      'SU' => 'Sucre',
      'TA' => 'Táchira',
      'TR' => 'Trujillo',
      'YA' => 'Yaracuy',
      'ZU' => 'Zulia',
    );

  return $states;
  }

}