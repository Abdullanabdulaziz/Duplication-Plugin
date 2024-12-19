<?php
/*
Plugin Name: Duplicate Page for Elementor
Plugin URI: http://wordpress.org/plugins/duplicate-page/
Description: A lightweight plugin that allows you to duplicate Elementor pages with a single click. Perfect for creating templates and maintaining design consistency across your website.
Version: 1.0
Author: Your Name
License: GPL2
Text Domain: duplicate-page
*/

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Custom autoloader
spl_autoload_register(function ($class) {
    // Check if the class is from our plugin namespace
    if (strpos($class, 'DuplicatePage\\') === 0) {
        // Remove namespace prefix
        $class_file = str_replace('DuplicatePage\\', '', $class);
        // Convert namespace separators to directory separators
        $class_file = str_replace('\\', DIRECTORY_SEPARATOR, $class_file);
        // Build the full path
        $file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $class_file . '.php';
        // Include the file if it exists
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

// Initialize the plugin
add_action('plugins_loaded', function() {
    new \DuplicatePage\PluginLoader();
});
