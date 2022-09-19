<?php
/**
 * Theme functions file
 *
 * @package  Zoo_Theme
 * @author   Zootemplate
 * @link     http://www.zootemplate.com
 *
 */

/**
 * Load default constants
 *
 * @var  resource
 */
require get_template_directory().'/core/const.php';

/**
 * Check if system meets requirements
 *
 * @see  https://developer.wordpress.org/reference/hooks/after_switch_theme/
 */
function zoo_theme_pre_activation_check($old_theme_name, WP_Theme $old_theme_object)
{
	try {
		if (version_compare(PHP_VERSION, '5.6', '<')) {
			throw new Exception(sprintf('Whoops, this theme requires %1$s version %2$s at least. Please upgrade %1$s to the latest version for better perfomance and security!', 'PHP', '5.6'));
		}

		if (version_compare($GLOBALS['wpdb']->db_version(), '5.5', '<')) {
			throw new Exception(sprintf('Whoops, this theme requires %1$s version %2$s at least. Please upgrade %1$s to the latest version for better perfomance and security.', 'MySQL', '5.5'));
		}

		if (version_compare($GLOBALS['wp_version'], '4.7', '<')) {
			throw new Exception(sprintf('Whoops, this theme requires %1$s version %2$s at least. Please upgrade %1$s to the latest version for better perfomance and security!', 'WordPress', '4.7'));
		}

		if (!defined('WP_CONTENT_DIR') || !is_writable(WP_CONTENT_DIR)) {
			throw new Exception('WordPress content directory is not writable. Please correct this directory permissions!');
		}
	} catch (Exception $e) {
		$die_msg = sprintf('<h1 class="align-center">'.esc_html__('Theme Activation Error', 'ciao').'</h1><p class="zoo-active-theme-error" >%s</p><p class="align-center"><a href="%s">'.esc_html__('Return to dashboard', 'ciao').'</a></p>', $e->getMessage(), get_admin_url(null, 'index.php'));
		switch_theme($old_theme_object->stylesheet);
		wp_die($die_msg, esc_html__('Theme Activation Error', 'ciao'), 500);
	}

	add_option(ZOO_SETTINGS_KEY, [
		'header_scripts'  => '',
		'footer_scripts'  => '',
		'import_settings' => '',
		'enable_dev_mode' => 0,
		'enable_builtin_mega_menu' => 0,
		'mobile_breakpoint_width' => 992,
	]);

	update_option(get_option('template', 'ciao').'_header_prebuilt_templates', [
		'header-default' => [
			'name'       => esc_html__('Header Default', 'ciao'),
			'image'      => ZOO_THEME_URI.'core/assets/icons/header-default.svg',
			'panel_id'   => 'header_builder_panel',
			'thememods'  => 'prebuilt'
		],
		'header-default-center' => [
			'name'       => esc_html__('Header Default Center', 'ciao'),
			'image'      => ZOO_THEME_URI.'core/assets/icons/header-default-center.svg',
			'panel_id'   => 'header_builder_panel',
			'thememods'  => 'prebuilt'
		],
		'header-default-dark' => [
			'name'       => esc_html__('Header Default Dark', 'ciao'),
			'image'      => ZOO_THEME_URI.'core/assets/icons/header-default-dark.svg',
			'panel_id'   => 'header_builder_panel',
			'thememods'  => 'prebuilt'
		],
		'header-wide-nav' => [
			'name'       => esc_html__('Header Wide Nav', 'ciao'),
			'image'      => ZOO_THEME_URI.'core/assets/icons/header-wide-nav.svg',
			'panel_id'   => 'header_builder_panel',
			'thememods'  => 'prebuilt'
		],
		'header-wide-nav-dark' => [
			'name'       => esc_html__('Header Wide Nav Dark', 'ciao'),
			'image'      => ZOO_THEME_URI.'core/assets/icons/header-wide-nav-dark.svg',
			'panel_id'   => 'header_builder_panel',
			'thememods'  => 'prebuilt'
		],
		'header-simple-signup' => [
			'name'       => esc_html__('Header Simple Signup', 'ciao'),
			'image'      => ZOO_THEME_URI.'core/assets/icons/header-simple-signup.svg',
			'panel_id'   => 'header_builder_panel',
			'thememods'  => 'prebuilt'
		],
		'header-simple-right-buttons' => [
			'name'       => esc_html__('Header Simple Right Buttons', 'ciao'),
			'image'      => ZOO_THEME_URI.'core/assets/icons/header-simple-right-buttons.svg',
			'panel_id'   => 'header_builder_panel',
			'thememods'  => 'prebuilt'
		],
		'header-simple-cart-top' => [
			'name'       => esc_html__('Header Simple Cart Top', 'ciao'),
			'image'      => ZOO_THEME_URI.'core/assets/icons/header-cart-top.svg',
			'panel_id'   => 'header_builder_panel',
			'thememods'  => 'prebuilt'
		]
	]);

	if (!is_child_theme()) {
		set_transient('theme_setup_wizard_redirect', '1');
	}
}
add_action('after_switch_theme', 'zoo_theme_pre_activation_check', 10, 2);

/**
 * Setup theme
 *
 * @see  https://developer.wordpress.org/reference/hooks/after_setup_theme/
 */
function zoo_theme_default_setup()
{
	$settings = get_option(ZOO_SETTINGS_KEY);

	register_nav_menus([
		'top-menu'     => esc_html__('Top Menu', 'ciao'),
		'primary-menu' => esc_html__('Primary Menu', 'ciao'),
		'mobile-menu'  => esc_html__('Mobile Menu', 'ciao')
	]);

	// Load common resources
	require ZOO_THEME_DIR.'core/common/functions/filesystem.php';
	require ZOO_THEME_DIR.'core/common/functions/fonts.php';
	require ZOO_THEME_DIR.'core/common/functions/css.php';
	require ZOO_THEME_DIR.'core/common/functions/page.php';
	require ZOO_THEME_DIR.'core/common/functions/media.php';
	require ZOO_THEME_DIR.'core/common/functions/theme.php';
	require ZOO_THEME_DIR.'core/common/functions/plugin.php';
	require ZOO_THEME_DIR.'core/common/functions/layout.php';
	require ZOO_THEME_DIR.'core/common/functions/shortcode.php';
	require ZOO_THEME_DIR.'core/common/functions/formatting.php';
	require ZOO_THEME_DIR.'core/common/functions/customize.php';
	require ZOO_THEME_DIR.'core/common/hooks.php';

	// Load admin resources.
	if (is_admin()) {
		require ZOO_THEME_DIR.'core/admin/functions/menu.php';
		require ZOO_THEME_DIR.'core/admin/helpers/class-zoo-logger.php';
		if (class_exists('CleverAddons', false) && !class_exists('Clever_Mega_Menu', false) && !class_exists('CleverSoft\WpPlugin\Cmm4E\Plugin', false) && !empty($settings['enable_builtin_mega_menu'])) {
			require ZOO_THEME_DIR.'core/admin/megamenu/class-menu-editor.php';
		}
		require ZOO_THEME_DIR.'core/admin/pages/zoo-welcome-page.php';
		require ZOO_THEME_DIR.'core/admin/pages/zoo-customize-page.php';
		require ZOO_THEME_DIR.'core/admin/pages/zoo-settings-page.php';
		require ZOO_THEME_DIR.'core/admin/migration/class-zoo-wxr-parser.php';
		require ZOO_THEME_DIR.'core/admin/migration/class-zoo-wxr-importer.php';
		require ZOO_THEME_DIR.'core/admin/migration/class-zoo-customize-importer.php';
		require ZOO_THEME_DIR.'core/admin/migration/tgm-plugin-activation.php';
		require ZOO_THEME_DIR.'core/admin/migration/class-zoo-demo-importer.php';
		require ZOO_THEME_DIR.'core/admin/pages/zoo-setup-demo-page.php';
		require ZOO_THEME_DIR.'core/admin/migration/class-zoo-setup-wizard.php';
		require ZOO_THEME_DIR.'core/admin/hooks.php';
	} else { // Load public resources.
		require ZOO_THEME_DIR.'core/public/megamenu/class-mega-menu-walker.php';
		require ZOO_THEME_DIR.'core/public/breadcrumb/zoo-breadcrumb.php';
		require ZOO_THEME_DIR.'core/public/functions/pagination.php';
		require ZOO_THEME_DIR.'core/public/functions/breadcrumb.php';
		require ZOO_THEME_DIR.'core/public/hooks.php';
	}

	// Load customize resources.
	require ZOO_THEME_DIR.'core/customize/class-zoo-customize-sanitizer.php';
	require ZOO_THEME_DIR.'core/customize/class-zoo-customize-live-css.php';
	require ZOO_THEME_DIR.'core/customize/builder/class-zoo-customize-builder-block.php';
	require ZOO_THEME_DIR.'core/customize/builder/class-zoo-customize-builder-element.php';
	require ZOO_THEME_DIR.'core/customize/builder/class-zoo-customize-header-builder.php';
	require ZOO_THEME_DIR.'core/customize/builder/class-zoo-customize-footer-builder.php';
	require ZOO_THEME_DIR.'core/customize/builder/class-zoo-customize-frontend-builder.php';
	require ZOO_THEME_DIR.'core/customize/builder/class-zoo-customize-builder.php';
	require ZOO_THEME_DIR.'core/customize/class-zoo-customizer.php';

	// Load extra theme functionality.
	require ZOO_THEME_DIR.'inc/init.php';
}
add_action('after_setup_theme', 'zoo_theme_default_setup', 9, 0);
