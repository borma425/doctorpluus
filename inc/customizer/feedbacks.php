<?php

class Feedbacks_Customizer {
    public function __construct() {
        add_action( 'customize_register', array( $this, 'register_customize_feedbacks_sections' ) );
    }

    public function register_customize_feedbacks_sections( $wp_customize ) {
        // New panel for "Feedbacks".
        $wp_customize->add_section('basic-feedbacks-section', array(
            'title' => 'Feedbacks Section',
            'priority' => 3,
            'description' => __('The Feedbacks section is displayed on the homepage.', 'Borma'),
        ));



        // Repeater for Feedbacks
        $wp_customize->add_setting('basic-feedbacks-count', array(
            'default' => '',
            'sanitize_callback' => array( $this, 'sanitize_custom_text' )
        ));
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'basic-feedbacks-count', array(
            'label' => 'Number of Feedbacks',
            'section' => 'basic-feedbacks-section',
            'settings' => 'basic-feedbacks-count',
            'type' => 'number',
            'description' => 'Enter the number of feedbacks you want to add.',
        )));

        // Loop to add controls for each feedback
        $feedback_count = get_theme_mod('basic-feedbacks-count', 1);
        for ($i = 1; $i <= $feedback_count; $i++) {
            // Feedback Avatar
            $wp_customize->add_setting("basic-feedback-avatar-$i", array(
                'default' => '',
                'sanitize_callback' => array( $this, 'sanitize_custom_url' )
            ));
            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "basic-feedback-avatar-$i", array(
                'label' => "Feedback $i Avatar",
                'section' => 'basic-feedbacks-section',
                'settings' => "basic-feedback-avatar-$i",
            )));

            // Feedback Title
            $wp_customize->add_setting("basic-feedback-title-$i", array(
                'default' => '',
                'sanitize_callback' => array( $this, 'sanitize_custom_text' )
            ));
            $wp_customize->add_control(new WP_Customize_Control($wp_customize, "basic-feedback-title-$i", array(
                'label' => "Feedback $i Title",
                'section' => 'basic-feedbacks-section',
                'settings' => "basic-feedback-title-$i",
                'type' => 'text'
            )));

            // Feedback Description
            $wp_customize->add_setting("basic-feedback-desc-$i", array(
                'default' => '',
                'sanitize_callback' => array( $this, 'sanitize_custom_text' )
            ));
            $wp_customize->add_control(new WP_Customize_Control($wp_customize, "basic-feedback-desc-$i", array(
                'label' => "Feedback $i Description",
                'section' => 'basic-feedbacks-section',
                'settings' => "basic-feedback-desc-$i",
                'type' => 'textarea'
            )));
        }
    }

    /* Sanitize Inputs */
    public function sanitize_custom_text($input) {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }
    public function sanitize_custom_url($input) {
        return filter_var($input, FILTER_SANITIZE_URL);
    }
}

