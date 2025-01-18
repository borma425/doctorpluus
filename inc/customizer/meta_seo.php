<?php

class Meta_SEO {
    public function __construct() {
        add_action( 'customize_register', array( $this, 'register_customize_meta_seo_sections' ) );
    }

    public function register_customize_meta_seo_sections( $wp_customize ) {
        /*
        * Add settings to the main section.
        */
        $this->meta_seo_main_section( $wp_customize );
    }

    /* Sanitize Inputs */
    public function sanitize_custom_text($input) {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }

    /* Main Meta SEO Section */
    private function meta_seo_main_section( $wp_customize ) {
        // Add the main section
        $wp_customize->add_section('meta_seo_main_section', array(
            'title' => 'Meta SEO Settings',
            'priority' => 2,
            'description' => __('Edit meta titles and descriptions for different sections.', 'Borma'),
        ));

        // === Homepage ===
        // Add setting for Homepage meta title
        $wp_customize->add_setting('meta_seo_homepage_title', array(
            'default' => '',
            'sanitize_callback' => array( $this, 'sanitize_custom_text' )
        ));

        // Add control for Homepage meta title
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'meta_seo_homepage_title', array(
            'label' => 'Homepage - Meta Title',
            'section' => 'meta_seo_main_section',
            'settings' => 'meta_seo_homepage_title',
            'type' => 'text'
        )));

        // Add setting for Homepage meta description
        $wp_customize->add_setting('meta_seo_homepage_description', array(
            'default' => '',
            'sanitize_callback' => array( $this, 'sanitize_custom_text' )
        ));

        // Add control for Homepage meta description
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'meta_seo_homepage_description', array(
            'label' => 'Homepage - Meta Description',
            'section' => 'meta_seo_main_section',
            'settings' => 'meta_seo_homepage_description',
            'type' => 'textarea'
        )));

        // === Doctors List ===
        // Add setting for Doctors List meta title
        $wp_customize->add_setting('meta_seo_doctors_list_title', array(
            'default' => '',
            'sanitize_callback' => array( $this, 'sanitize_custom_text' )
        ));

        // Add control for Doctors List meta title
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'meta_seo_doctors_list_title', array(
            'label' => 'Doctors List - Meta Title',
            'section' => 'meta_seo_main_section',
            'settings' => 'meta_seo_doctors_list_title',
            'type' => 'text'
        )));

        // Add setting for Doctors List meta description
        $wp_customize->add_setting('meta_seo_doctors_list_description', array(
            'default' => '',
            'sanitize_callback' => array( $this, 'sanitize_custom_text' )
        ));

        // Add control for Doctors List meta description
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'meta_seo_doctors_list_description', array(
            'label' => 'Doctors List - Meta Description',
            'section' => 'meta_seo_main_section',
            'settings' => 'meta_seo_doctors_list_description',
            'type' => 'textarea'
        )));


    }
}

// Initialize the class