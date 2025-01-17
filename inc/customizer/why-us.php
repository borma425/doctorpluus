<?php

class why_us {
    public function __construct() {
        add_action( 'customize_register', array( $this, 'register_customize_why_us_sections' ) );
    }

    public function register_customize_why_us_sections( $wp_customize ) {
        /*
         * Add settings to sections.
         */
        $this->why_us_callout_section( $wp_customize );
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

    /* why_us Section */
    private function why_us_callout_section( $wp_customize ) {
        // New panel for "Layout".
        $wp_customize->add_section('basic-why_us-callout-section', array(
            'title' => 'Why Us Section',
            'priority' => 2,
            'description' => __('The Why Us section is displayed on the homepage.', 'Borma'),
        ));

        // Main Title
        $wp_customize->add_setting('basic-why_us-main-title', array(
            'default' => '',
            'sanitize_callback' => array( $this, 'sanitize_custom_text' )
        ));
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'basic-why_us-main-title', array(
            'label' => 'Main Title',
            'section' => 'basic-why_us-callout-section',
            'settings' => 'basic-why_us-main-title',
            'type' => 'text'
        )));

        // Repeater for Sections
        $wp_customize->add_setting('basic-why_us-sections', array(
            'default' => '',
            'sanitize_callback' => array( $this, 'sanitize_custom_text' )
        ));
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'basic-why_us-sections', array(
            'label' => 'Number of Sections',
            'section' => 'basic-why_us-callout-section',
            'settings' => 'basic-why_us-sections',
            'type' => 'number',
            'description' => 'Enter the number of sections you want to add.',
        )));

        // Loop to add controls for each section
        $section_count = get_theme_mod('basic-why_us-sections', 1);
        for ($i = 1; $i <= $section_count; $i++) {
            // Section Title
            $wp_customize->add_setting("basic-why_us-section-title-$i", array(
                'default' => '',
                'sanitize_callback' => array( $this, 'sanitize_custom_text' )
            ));
            $wp_customize->add_control(new WP_Customize_Control($wp_customize, "basic-why_us-section-title-$i", array(
                'label' => "Section $i Title",
                'section' => 'basic-why_us-callout-section',
                'settings' => "basic-why_us-section-title-$i",
                'type' => 'text'
            )));

            // Section Image Icon
            $wp_customize->add_setting("basic-why_us-section-icon-$i", array(
                'default' => '',
                'sanitize_callback' => array( $this, 'sanitize_custom_url' )
            ));
            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "basic-why_us-section-icon-$i", array(
                'label' => "Section $i Icon",
                'section' => 'basic-why_us-callout-section',
                'settings' => "basic-why_us-section-icon-$i",
            )));

            // Section Description
            $wp_customize->add_setting("basic-why_us-section-desc-$i", array(
                'default' => '',
                'sanitize_callback' => array( $this, 'sanitize_custom_text' )
            ));
            $wp_customize->add_control(new WP_Customize_Control($wp_customize, "basic-why_us-section-desc-$i", array(
                'label' => "Section $i Description",
                'section' => 'basic-why_us-callout-section',
                'settings' => "basic-why_us-section-desc-$i",
                'type' => 'textarea'
            )));
        }
    }
}

