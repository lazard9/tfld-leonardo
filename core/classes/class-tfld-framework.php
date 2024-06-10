<?php

/**
 * 
 * Table of Contents (number is code line):
 * 
 * Include admin scripts
 * Include frontend scripts
 * Include Swiper.js plugin scripts
 * Admin pages - menu page, for CPT courses, under Tools
 * Admin pages - settings and forms
 * Load Course Template - with Swiper.js plugin carousel
 * Load Archive Courses Template - with Ajax load more button
 * Register CPT Courses
 * Register CPT Professors
 * Register Custom Taxonomies for CPT Courses with additional functionalities for tax Level
 * Tax Level has only 4 terms, custom metabox with input type radio (only one option can be selected)
 * Taxonomies Level, Subject, Topics in draft have autosave set to term Any
 * Register Custom Taxonomies for CPT Professors and autopopulate
 * Register Shortcode to display Swiper.js slider in Course Template
 * Metabox - Select Editor
 * Save Editor to Post Meta
 * Metabox - Add Custom Fields - Courses
 * Save Course Details to custom DB table
 * Woo GDPR Complience Checkbox for the Comments/Reviews
 * 
 * @package TFLD Simple Features
 *  
 */

namespace TFLD\core;

use TFLD\core\Abstracts\TFLD_Singleton;
use TFLD\core\Traits\Include_Files;

final class TFLD_Framework extends TFLD_Singleton
{
    use Include_Files;

    /**
     * Protected class constructor to prevent direct object creation
     *
     * This is meant to be overridden in the classes which implement
     * this trait. This is ideal for doing stuff that you only want to
     * do once, such as hooking into actions and filters, etc.
     */
    protected function __construct()
    {

        self::include_once(TFLD_FRAMEWORK_DIR . '/core/classes/frontend/class-tfld-public.php');

        Frontend\TFLD_Public::get_instance();
    }
}
