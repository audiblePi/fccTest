<?php
/*
Plugin Name: Register Helper Example
Plugin URI: http://www.paidmembershipspro.com/wp/pmpro-customizations/
Description: Register Helper Initialization Example
Version: .1
Author: Stranger Studios
Author URI: http://www.strangerstudios.com
*/
//we have to put everything in a function called on init, so we are sure Register Helper is loaded
// function my_pmprorh_init()
// {
//     //don't break if Register Helper is not loaded
//     if(!function_exists("pmprorh_add_registration_field"))
//     {
//         return false;
//     }

//     //define the fields
//     $fields = array();
//     $fields[] = new PMProRH_Field(
//         "company",              // input name, will also be used as meta key
//         "text",                 // type of field
//         array(
//             "size"=>40,         // input size
//             "class"=>"company", // custom class
//             "profile"=>true,    // show in user profile
//             "required"=>true    // make this field required
//         ));
//     $fields[] = new PMProRH_Field(
//         "referral",                     // input name, will also be used as meta key
//         "text",                         // type of field
//         array(
//             "label"=>"Referral Code",   // custom field label
//             "profile"=>"admins"         // only show in profile for admins
//         ));
//     $fields[] = new PMProRH_Field(
//         "gender",                   // input name, will also be used as meta key
//         "select",                   // type of field
//         array(
//             "options"=>array(       // <option> elements for select field
//                     "" => "",       // blank option - cannot be selected if this field is required
//                 "male"=>"Male",     // <option value="male">Male</option>
//                 "female"=>"Female"  // <option value="female">Female</option>
//         )));

//     //add the fields into a new checkout_boxes are of the checkout page
//     foreach($fields as $field)
//         pmprorh_add_registration_field(
//             "checkout_boxes", // location on checkout page
//             $field            // PMProRH_Field object
//         );

//     //that's it. see the PMPro Register Helper readme for more information and examples.
// }
// add_action("init", "my_pmprorh_init");