<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.presstigers.com
 * @since             1.0.0
 * @package           Simple_Vote
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Vote
 * Description:       The simplest and easiest to use voting plugin that lets you add liking and disliking buttons under your content with just a few clicks.
 * Version:           1.0.2
 * Author:            PressTigers
 * Author URI:        www.presstigers.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-vote
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SIMPLE_VOTE_VERSION', '1.0.2' );

/**
 *  Show Simple Vote Upgrade Notice
 */
function sv_showUpgradeNotification($currentPluginMetadata, $newPluginMetadata)
{

    // check "upgrade_notice"
    if (isset($newPluginMetadata->upgrade_notice) && strlen(trim($newPluginMetadata->upgrade_notice)) > 0) {
        echo '<br><br><strong>Important Upgrade Notice:</strong> ' . strip_tags($newPluginMetadata->upgrade_notice) . '';
    }
}

// Show Simple Vote Upgrade Notice
add_action('in_plugin_update_message-simple-vote/simple-vote.php', 'sv_showUpgradeNotification', 10, 2);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-vote-activator.php
 */
function activate_simple_vote() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-vote-activator.php';
	Simple_Vote_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-vote-deactivator.php
 */
function deactivate_simple_vote() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-vote-deactivator.php';
	Simple_Vote_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_vote' );
register_deactivation_hook( __FILE__, 'deactivate_simple_vote' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-vote.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function run_simple_vote() {

	$plugin = new Simple_Vote();
	$plugin->run();

}
run_simple_vote();