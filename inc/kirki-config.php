<?php

// Early exit if Kirki doesn’t exist.
if ( ! class_exists( 'Kirki' ) ) {
    return;
}

function get_hours_options() {
	$hours = array(
		'01:00 am' => '01:00 am',
		'02:00 am' => '02:00 am',
		'03:00 am' => '03:00 am',
		'04:00 am' => '04:00 am',
		'05:00 am' => '05:00 am',
		'06:00 am' => '06:00 am',
		'07:00 am' => '07:00 am',
		'08:00 am' => '08:00 am',
		'09:00 am' => '09:00 am',
		'10:00 am' => '10:00 am',
		'11:00 am' => '11:00 am',
		'12:00 pm' => '12:00 pm',
		'01:00 pm' => '01:00 pm',
		'02:00 pm' => '02:00 pm',
		'03:00 pm' => '03:00 pm',
		'04:00 pm' => '04:00 pm',
		'05:00 pm' => '05:00 pm',
		'06:00 pm' => '06:00 pm',
		'07:00 pm' => '07:00 pm',
		'08:00 pm' => '08:00 pm',
		'09:00 pm' => '09:00 pm',
		'10:00 pm' => '10:00 pm',
		'11:00 pm' => '11:00 pm',
		'12:00 am' => '12:00 am',
	);
	return $hours;
}

function get_contact_forms() {
	$contactForms = array();
	$posts = get_posts(array(
        'post_type'     => 'wpcf7_contact_form',
        'numberposts'   => -1
	));
	if( $posts ){
		foreach($posts as $key){
			$contactForms[$key->ID] = $key->post_title;
		}
	}else{
		$contactForms['0'] = esc_html__('No Contact Form found', 'lei');
	}
	return $contactForms;
}

function get_all_pages() {
	$pages = [];
	foreach(get_pages() as $page) {
		$pages[get_the_permalink( $page->ID )] = $page->post_title;
	}
	return $pages;
}

add_shortcode( 'iframe' , 'mycustom_shortcode_iframe' );
function mycustom_shortcode_iframe($args, $content) {
    $keys = array("src", "width", "height", "scrolling", "marginwidth", "marginheight", "frameborder");
    $arguments = mycustom_extract_shortcode_arguments($args, $keys);
    return '<iframe ' . $arguments . '></iframe>';
}

function mycustom_extract_shortcode_arguments($args, $keys) {
    $result = "";
    foreach ($keys as $key) {
        if (isset($args[$key])) {
            $result .= $key . '="' . $args[$key] . '" ';
        }
    }
    return $result;
}

Kirki::add_config( 'li_theme_config', array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'theme_mod',
) );

Kirki::add_panel( 'contact_settings_panel', array(
    'priority'    => 10,
    'title'       => esc_html__( 'Contact Settings', 'kirki' ),
    'description' => esc_html__( 'Contact information and social links', 'kirki' ),
) );

Kirki::add_section( 'contact_section', array(
    'title'          => esc_html__( 'Contact Info', 'kirki' ),
    'description'    => esc_html__( 'Contact info settings', 'kirki' ),
    'panel'          => 'contact_settings_panel',
    'priority'       => 160,
) );

Kirki::add_field( 'li_theme_config', [
	'type'     => 'editor',
	'settings' => 'phone_numbers',
	'label'    => esc_html__( 'Phone Numbers', 'kirki' ),
	'description' => esc_html__( 'Phone numbers', 'kirki' ),
	'section'  => 'contact_section',
	'default'  => esc_html__( 'Call us: 056-2747372 - English Speaker 056-5337262 - Arabic Speaker', 'kirki' ),
	'priority' => 10,
] );

Kirki::add_field( 'li_theme_config', [
	'type'     => 'text',
	'settings' => 'emails',
	'label'    => esc_html__( 'Emails', 'kirki' ),
	'description' => esc_html__( 'If multiple, seperate with comma', 'kirki' ),
	'section'  => 'contact_section',
	'default'  => esc_html__( 'info@example.com', 'kirki' ),
	'priority' => 10,
] );

Kirki::add_field( 'li_theme_config', [
	'type'     => 'textarea',
	'settings' => 'address',
	'label'    => esc_html__( 'Address', 'kirki' ),
	'section'  => 'contact_section',
	'default'  => esc_html__( 'Please enter your address', 'kirki' ),
	'priority' => 10,
] );

Kirki::add_field( 'li_theme_config', [
	'type'     => 'textarea',
	'settings' => 'working_hours',
	'label'    => esc_html__( 'Working Hours', 'kirki' ),
	'section'  => 'contact_section',
	'default'  => esc_html__( 'Please enter working hours', 'kirki' ),
	'priority' => 10,
] );


Kirki::add_field( 'li_theme_config', [
	'type'        => 'editor',
	'settings'    => 'extra_info',
	'label'       => esc_html__( 'Extra Contact Info', 'kirki' ),
	'description' => esc_html__( 'Type other contact and hospital working hour related info here', 'kirki' ),
	'section'     => 'contact_section',
	'default'     => '',
] );


Kirki::add_field( 'li_theme_config', [
	'type'        => 'code',
	'settings'    => 'map',
	'label'       => esc_html__( 'Embed Map', 'kirki' ),
	'description' => esc_html__( 'Place google map snippet here.', 'kirki' ),
	'section'     => 'contact_section',
	'default'     => '',
	'choices'     => [
		'language' => 'html',
	],
] );


Kirki::add_field( 'li_theme_config', [
	'type'        => 'select',
	'settings'    => 'contact_form',
	'label'       => esc_html__( 'Contact Form', 'kirki' ),
	'section'     => 'contact_section',
	'default'     => '',
	'placeholder' => esc_html__( 'Select an option...', 'kirki' ),
	'priority'    => 10,
	'multiple'    => 0,
	'choices'     => get_contact_forms(),
] );


// Kirki::add_field( 'li_theme_config', [
// 	'type'        => 'select',
// 	'settings'    => 'appointment_form',
// 	'label'       => esc_html__( 'Appointment Link', 'kirki' ),
// 	'section'     => 'contact_section',
// 	'default'     => '',
// 	'placeholder' => esc_html__( 'Select appointment page', 'kirki' ),
// 	'priority'    => 10,
// 	'multiple'    => 0,
// 	'choices'     => get_all_pages(),
// ] );



// social network section
Kirki::add_section( 'social_section', array(
    'title'          => esc_html__( 'Social Links', 'kirki' ),
    'description'    => esc_html__( 'Social link settings', 'kirki' ),
    'panel'          => 'contact_settings_panel',
    'priority'       => 160,
) );

Kirki::add_field( 'li_theme_config', [
	'type'     => 'link',
	'settings' => 'facebook',
	'label'    => __( 'Facebook', 'kirki' ),
	'section'  => 'social_section',
	'default'  => 'https://facebook.com/',
	'priority' => 10,
] );

Kirki::add_field( 'li_theme_config', [
	'type'     => 'link',
	'settings' => 'twitter',
	'label'    => __( 'Twitter', 'kirki' ),
	'section'  => 'social_section',
	'default'  => 'https://twitter.com/',
	'priority' => 10,
] );

Kirki::add_field( 'li_theme_config', [
	'type'     => 'link',
	'settings' => 'linkedin',
	'label'    => __( 'Linkedin', 'kirki' ),
	'section'  => 'social_section',
	'default'  => 'https://linkedin.com/',
	'priority' => 10,
] );

Kirki::add_field( 'li_theme_config', [
	'type'     => 'link',
	'settings' => 'instagram',
	'label'    => __( 'Instagram', 'kirki' ),
	'section'  => 'social_section',
	'default'  => 'https://instagram.com/',
	'priority' => 10,
] );

Kirki::add_field( 'li_theme_config', [
	'type'     => 'link',
	'settings' => 'pinterest',
	'label'    => __( 'Pinterest', 'kirki' ),
	'section'  => 'social_section',
	'default'  => 'https://pinterest.com/',
	'priority' => 10,
] );


?>
