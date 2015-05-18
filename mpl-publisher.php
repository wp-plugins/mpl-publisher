<?php
/**
 * Plugin Name: MPL - Publisher
 * Plugin URI: https://ferranfigueredo.com/mpl-publisher
 * Description: MPL - Publisher is a WordPress plugin to help you publish your WordPress posts as an elegant eBooks. Choose your format: PDF, ePub, Mobi... etc.
 * Version: 1.2.0
 * Author: Ferran Figueredo
 * Author URI: https://ferranfigueredo.com
 * License: MIT
 */

require 'vendor/autoload.php';

$controller = new \MPL\Publisher\PublisherController(__DIR__);

add_action('init', function ()
{
	load_plugin_textdomain('publisher', false, basename(dirname(__FILE__)) . '/languages');
});

add_action('admin_menu', function () use ($controller)
{
    add_management_page('MPL - Publisher', 'Publisher', 'manage_options', 'publisher', function () use ($controller)
    {
        return $controller->getIndex();
    });
});

add_action('admin_post_publish_ebook', function () use ($controller)
{
	return $controller->postIndex();
});

add_action('admin_enqueue_scripts', function ()
{
	wp_enqueue_script('jquery-ui-sortable');

	wp_enqueue_script('mpl-publisher', plugin_dir_url(__FILE__) . 'assets/mpl-publisher.js');
});