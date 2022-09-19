<?php
/**
 * Register require plugins for theme.
 *
 * @package     Zoo Theme
 * @version     3.0.0
 * @author      Zootemplate
 * @link        https://www.zootemplate.com/
 * @copyright   Copyright (c) 2018 ZooTemplate
 
 * @des         List plugins require with theme will register in this file. Dev can add or remove plugin or update version of plugins.
 */

add_action('tgmpa_register', 'zoo_theme_register_required_plugins');

/**
 * Register the required plugins for this theme.
 */
if (!function_exists('zoo_theme_register_required_plugins')) {
    function zoo_theme_register_required_plugins()
    {
        /*
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */
        $zoo_directory_plugins = get_template_directory() . '/inc/plugins/';
        $plugins = array(
            array(
                'name' => esc_html__('Clever Addons', 'ciao'),
                'slug' => 'clever-addons',
                'required' => true,
                'source' => $zoo_directory_plugins . 'clever-addons.zip',
                'version' => '1.0.1'
            ),
            array(
                'name' => esc_html__('Elementor Page Builder', 'ciao'),
                'slug' => 'elementor',
            ),
            array(
                'name' => esc_html__('Clever Addons For Elementor', 'ciao'),
                'slug' => 'cafe-lite',
                'required' => true,
            ),array(
                'name' => esc_html__('Clever Addons Pro For Elementor', 'ciao'),
                'slug' => 'cafe-pro',
                'required' => true,
                'source' => $zoo_directory_plugins . 'cafe-pro.zip',
            ),
            array(
                'name' => esc_html__('Meta Box', 'ciao'),
                'slug' => 'meta-box',
                'required' => true,
            ),
            array(
                'name' => esc_html__('WooCommerce', 'ciao'),
                'slug' => 'woocommerce',
                'required' => true,
            ),
            array(
                'name' => esc_html__('Clever Swatches', 'ciao'),
                'slug' => 'clever-swatches',
                'required' => true,
                'source' => $zoo_directory_plugins . 'clever-swatches.zip',
                'version' => '2.2.2'
            ),array(
                'name' => esc_html__('Clever Layered Navigation', 'ciao'),
                'slug' => 'clever-layered-navigation',
                'required' => true,
                'source' => $zoo_directory_plugins . 'clever-layered-navigation.zip',
                'version' => '1.3.9'
            ),
	        array(
		        'name' => esc_html__('Clever Portfolio', 'ciao'),
		        'slug' => 'clever-portfolio',
		        'required' => true,
		        'source' => $zoo_directory_plugins . 'clever-portfolio.zip',
		        'version' => '1.0.3'
	        ),
            array(
                'name' => esc_html__('Contact Form 7', 'ciao'),
                'slug' => 'contact-form-7',
                'required' => true,
            ),
            array(
                'name' => esc_html__('MailChimp for WordPress', 'ciao'),
                'slug' => 'mailchimp-for-wp',
                'required' => false,
            ),
            array(
                'name' => esc_html__('WP User Avatar', 'ciao'),
                'slug' => 'wp-user-avatar',
                'required' => false,
            ),
        );
        $config = array(
            'id' => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to pre-packaged plugins.
            'menu' => 'tgmpa-install-plugins', // Menu slug.
            'parent_slug' => 'themes.php',            // Parent menu slug.
            'capability' => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
            'has_notices' => true,                    // Show admin notices or not.
            'dismissable' => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg' => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message' => '',                      // Message to output right before the plugins table.
            'strings' => array(
                'page_title' => esc_html(__('Install Required Plugins', 'ciao')),
                'menu_title' => esc_html(__('Install Plugins', 'ciao')),
                'installing' => esc_html(__('Installing Plugin: %s', 'ciao')), // %s = plugin name.
                'oops' => esc_html(__('Something went wrong with the plugin API.', 'ciao')),
                'notice_can_install_required' => _n_noop(
                    'This theme requires the following plugin: %1$s.',
                    'This theme requires the following plugins: %1$s.',
                    'ciao'
                ), // %1$s = plugin name(s).
                'notice_can_install_recommended' => _n_noop(
                    'This theme recommends the following plugin: %1$s.',
                    'This theme recommends the following plugins: %1$s.',
                    'ciao'
                ), // %1$s = plugin name(s).
                'notice_cannot_install' => _n_noop(
                    'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
                    'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
                    'ciao'
                ), // %1$s = plugin name(s).
                'notice_ask_to_update' => _n_noop(
                    'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                    'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                    'ciao'
                ), // %1$s = plugin name(s).
                'notice_ask_to_update_maybe' => _n_noop(
                    'There is an update available for: %1$s.',
                    'There are updates available for the following plugins: %1$s.',
                    'ciao'
                ), // %1$s = plugin name(s).
                'notice_cannot_update' => _n_noop(
                    'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
                    'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
                    'ciao'
                ), // %1$s = plugin name(s).
                'notice_can_activate_required' => _n_noop(
                    'The following required plugin is currently inactive: %1$s.',
                    'The following required plugins are currently inactive: %1$s.',
                    'ciao'
                ), // %1$s = plugin name(s).
                'notice_can_activate_recommended' => _n_noop(
                    'The following recommended plugin is currently inactive: %1$s.',
                    'The following recommended plugins are currently inactive: %1$s.',
                    'ciao'
                ), // %1$s = plugin name(s).
                'notice_cannot_activate' => _n_noop(
                    'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
                    'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
                    'ciao'
                ), // %1$s = plugin name(s).
                'install_link' => _n_noop(
                    'Begin installing plugin',
                    'Begin installing plugins',
                    'ciao'
                ),
                'update_link' => _n_noop(
                    'Begin updating plugin',
                    'Begin updating plugins',
                    'ciao'
                ),
                'activate_link' => _n_noop(
                    'Begin activating plugin',
                    'Begin activating plugins',
                    'ciao'
                ),
                'return' => esc_html(__('Return to Required Plugins Installer', 'ciao')),
                'plugin_activated' => esc_html(__('Plugin activated successfully.', 'ciao')),
                'activated_successfully' => esc_html(__('The following plugin was activated successfully:', 'ciao')),
                'plugin_already_active' => esc_html(__('No action taken. Plugin %1$s was already active.', 'ciao')),  // %1$s = plugin name(s).
                'plugin_needs_higher_version' => esc_html(__('Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'ciao')),  // %1$s = plugin name(s).
                'complete' => esc_html(__('All plugins installed and activated successfully. %1$s', 'ciao')), // %s = dashboard link.
                'contact_admin' => esc_html(__('Please contact the administrator of this site for help.', 'ciao')),
                'nag_type' => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
            )
        );

        tgmpa($plugins, $config);

    }
}