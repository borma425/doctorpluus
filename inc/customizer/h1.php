<?php

class main_edit {
	public function __construct() {
		add_action( 'customize_register', array( $this, 'register_customize_main_edit_sections' ) );
	}
	public function register_customize_main_edit_sections( $wp_customize ) {
        /*
        * Add settings to sections.
        */
        $this->main_edit_callout_section( $wp_customize );
    }

    /* Sanitize Inputs */
    public function sanitize_custom_option($input) {
        return ( $input === "No" ) ? "No" : "Yes";
    }
    public function sanitize_custom_text($input) {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }
    public function sanitize_custom_url($input) {
        return filter_var($input, FILTER_SANITIZE_URL);
    }
    public function sanitize_custom_email($input) {
        return filter_var($input, FILTER_SANITIZE_EMAIL);
    }
    public function sanitize_hex_color( $color ) {
        if ( '' === $color ) {
            return '';
        }

        // 3 or 6 hex digits, or the empty string.
        if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
            return $color;
        }
    }

    /* main_edit Section */
    private function main_edit_callout_section( $wp_customize ) {
		// New panel for "Layout".
        $wp_customize->add_section('basic-main_edit-callout-section', array(
            'title' => 'Main Edit Sections',
            'priority' => 2,
            'description' => __('hero header  section is  displayed on the Blog Hero header.', 'Borma'),
        ));







/* h1 */

$wp_customize->add_setting('basic-main_edit-callout-h1', array(
    'default' => '',
    'sanitize_callback' => array( $this, 'sanitize_custom_text' )
));
$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'basic-main_edit-callout-h1', array(
    'label' => 'h1',
    'section' => 'basic-main_edit-callout-section',
    'settings' => 'basic-main_edit-callout-h1',
    'type' => 'textarea'
)));


/* h1 */

$wp_customize->add_setting('basic-main_edit-callout-h1_subtext', array(
    'default' => '',
    'sanitize_callback' => array( $this, 'sanitize_custom_text' )
));
$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'basic-main_edit-callout-h1_subtext', array(
    'label' => 'sub text',
    'section' => 'basic-main_edit-callout-section',
    'settings' => 'basic-main_edit-callout-h1_subtext',
    'type' => 'text'
)));





$wp_customize->add_setting('basic-main_edit-callout-h1_phone', array(
    'default' => '',
    'sanitize_callback' => array( $this, 'sanitize_custom_text' )
));
$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'basic-main_edit-callout-h1_phone', array(
    'label' => 'phone number',
    'section' => 'basic-main_edit-callout-section',
    'settings' => 'basic-main_edit-callout-h1_phone',
    'type' => 'text'
)));







    }




}