<?php
/* Theme Options page: */

$main_tab = array(
  "name" => "main_options",
  "title" => __("Theme Options"),
  'sections' => array(
    'header' => array(
      'name' => 'main',
      'title' => __( '' ),
      'description' => __( '')
    ),
  ),
);
register_theme_option_tab($main_tab);

$mainoptions = array(
  "site_logo" => array(
    "tab" => "main_options",
    "name" => "site_logo",
    "title" => "Site Logo",
    "description" => __( "Upload logo to be used in header" ),
    "section" => "main",
    "id" => "site_logo",
    "type" => "image"
  ),
  "home_page_slider_image1" => array(
    "tab" => "main_options",
    "name" => "home_page_slider_image1",
    "title" => "Slider Image 1",
    "description" => __( "Upload logo to be used in header", "example" ),
    "section" => "main",
    "id" => "slider_image_1",
    "type" => "image"
  ),
  "home_page_slider_image2" => array(
    "tab" => "main_options",
    "name" => "home_page_slider_image2",
    "title" => "Slider Image 2",
    "description" => __( "Upload logo to be used in header", "example" ),
    "section" => "main",
    "id" => "slider_image_2",
    "type" => "image"
  ),
  "home_page_slider_image3" => array(
    "tab" => "main_options",
    "name" => "home_page_slider_image3",
    "title" => "Slider Image 3",
    "description" => __( "Upload logo to be used in header", "example" ),
    "section" => "main",
    "id" => "slider_image_3",
    "type" => "image"
  ),
  "office_location" => array(
    "tab" => "main_options",
    "name" => "office_location",
    "title" => "Office Location",
    "description" => __( "Enter office location which will be used for displaying on Google Map for site." ),
    "section" => "main",
    "id" => "office_location",
    "type" => "text"
  )
);
register_theme_options($mainoptions);