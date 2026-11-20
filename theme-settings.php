<?php

/**
 * @file
 * Theme settings form for the VSM theme.
 *
 * Adds VSM's own settings to the Bootstrap 5 base theme's settings form.
 */

use Drupal\Core\Form\FormStateInterface;

foreach (glob(__DIR__ . '/includes/*.theme') as $file) {
  require_once $file;
}

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function vsm_form_system_theme_settings_alter(array &$form, FormStateInterface $form_state): void {
  $form['vsm_style'] = [
    '#type' => 'details',
    '#title' => t('Style'),
    '#open' => TRUE,
    '#weight' => -20,
  ];
  $form['vsm_style']['bootswatch'] = [
    '#type' => 'select',
    '#title' => t('Bootswatch theme'),
    '#options' => array_map('t', vsm_bootswatch_options()),
    '#default_value' => vsm_bootswatch(),
    '#description' => t('Restyle the site with one of the free themes from <a href=":url" target="_blank" rel="noopener">Bootswatch</a>. Each one keeps VSM\'s own styles. Most Bootswatch themes also load their web font from Google Fonts.', [
      ':url' => 'https://bootswatch.com/',
    ]),
  ];
  if (count(vsm_bootswatch_options()) < 2) {
    $form['vsm_style']['bootswatch']['#description'] = t('No Bootswatch builds were found. Run <code>npm run build:bootswatch</code> in the theme folder to create them.');
  }
  $form['vsm_style']['font'] = [
    '#type' => 'select',
    '#title' => t('Font'),
    '#options' => array_map(fn(array $option) => t($option[0]), vsm_font_options()),
    '#default_value' => (string) theme_get_setting('font', 'vsm'),
    '#description' => t('Used for body text and headings. "Theme default" keeps the selected Bootswatch theme\'s font (Inter for Zephyr). Web fonts are loaded from Google Fonts; preview them at <a href=":url" target="_blank" rel="noopener">fonts.google.com</a>.', [
      ':url' => 'https://fonts.google.com/',
    ]),
  ];

  // The base theme's "Navbar options" section holds the navbar colours.
  $navbar = isset($form['nav_details']) ? 'nav_details' : 'vsm_style';
  $form[$navbar]['navbar_alignment'] = [
    '#type' => 'select',
    '#title' => t('Navbar menu alignment'),
    '#options' => array_map(fn(array $option) => t($option[0]), vsm_navbar_alignment_options()),
    '#default_value' => theme_get_setting('navbar_alignment', 'vsm') ?? 'right',
    '#description' => t('Position of the menus in the top navbar on wide screens (992px and up). On smaller screens they collapse behind the toggle button.'),
  ];

  $form['vsm_tables'] = [
    '#type' => 'details',
    '#title' => t('Tables'),
    '#open' => TRUE,
    '#weight' => -19,
  ];
  $form['vsm_tables']['table_striped'] = [
    '#type' => 'checkbox',
    '#title' => t('Striped tables'),
    '#default_value' => vsm_table_striped(),
    '#description' => t('Shade every other row of tables, including Views tables, using the colours of the selected Bootswatch theme.'),
  ];
  $form['vsm_tables']['table_row_padding'] = [
    '#type' => 'select',
    '#title' => t('Row padding'),
    '#options' => array_map(fn(array $option) => t($option[0]), vsm_table_row_padding_options()),
    '#default_value' => (string) theme_get_setting('table_row_padding', 'vsm'),
    '#description' => t('Space above and below the content of each table row. "Theme default" keeps the padding of the selected Bootswatch theme.'),
  ];

  $form['#submit'][] = 'vsm_theme_settings_submit';
}

/**
 * Form submit handler: rebuilds library definitions so the change applies.
 */
function vsm_theme_settings_submit(array &$form, FormStateInterface $form_state): void {
  \Drupal::service('library.discovery')->clear();
}
