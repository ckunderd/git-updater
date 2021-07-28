<?php
/**
 * Git Updater
 *
 * @author   Andy Fragen
 * @license  MIT
 * @link     https://github.com/afragen/git-updater
 * @package  git-updater
 */

/**
 * Plugin Name:       Git Updater
 * Plugin URI:        https://git-updater.com
 * Description:       A plugin to automatically update GitHub hosted plugins, themes, and language packs. Additional API plugins available for Bitbucket, GitLab, Gitea, and Gist.
 * Version:           10.4.2.1
 * Author:            Andy Fragen
 * License:           MIT
 * Domain Path:       /languages
 * Text Domain:       git-updater
 * Network:           true
 * GitHub Plugin URI: https://github.com/afragen/git-updater
 * GitHub Languages:  https://github.com/afragen/git-updater-translations
 * Requires at least: 5.2
 * Requires PHP:      5.6
 */

namespace Fragen\Git_Updater;

use Fragen\Git_Updater\API\Zipfile_API;

/*
 * Exit if called directly.
 * PHP version check and exit.
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Load the Composer autoloader.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

// Check for composer autoloader.
if ( ! class_exists( 'Fragen\Git_Updater\Bootstrap' ) ) {
	require_once __DIR__ . '/src/Git_Updater/Bootstrap.php';
	( new Bootstrap( __FILE__ ) )->deactivate_die();
}

register_activation_hook( __FILE__, [ new Bootstrap( __FILE__ ), 'rename_on_activation' ] );

( new Zipfile_API() )->load_hooks();

add_action(
	'plugins_loaded',
	function() {
		( new GU_Freemius() )->init();
		( new Bootstrap( __FILE__ ) )->run();
	}
);
