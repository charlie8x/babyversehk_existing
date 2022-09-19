<?php
/**
 * Import customize style
 *
 * @return Css inline at header.
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        https://www.zootemplate.com/
 * @copyright   Copyright (c) 2018 Zootemplate
 
 */

// Render css customize
add_action('wp_enqueue_scripts', 'zoo_enqueue_render', 1000);
// Enqueue scripts for theme.
function zoo_enqueue_render()
{
    //Load font
    $zoo_fonts = array();
    if (get_theme_mod('zoo_typo_base', '') == '' || get_theme_mod('zoo_typo_base')['font'] == '') {
        $zoo_fonts[] = array('font-family' => 'Larsseit', 'variant' => '400');
    }
    if (get_theme_mod('zoo_typo_heading', '') == '' || get_theme_mod('zoo_typo_heading')['font'] == '') {
        $zoo_fonts[] = array('font-family' => 'Larsseit', 'variant' => '500');
    }
    if (get_theme_mod('zoo_typo_woo', '') == '' || get_theme_mod('zoo_typo_woo')['font'] == '') {
        $zoo_fonts[] = array('font-family' => 'Larsseit', 'variant' => '500');
    }
    $zoo_local_font = array();
    $zoo_google_font = array();
    foreach ($zoo_fonts as $font) {
        if ($font) {
            if (in_array('Larsseit', $font)) {
                $zoo_local_font[] = 'Larsseit';
            } else {
                $zoo_google_font[] = $font;
            }
        }
    }
    if (!empty(array_filter($zoo_google_font))) {
        $zoo_google_font = zoo_import_google_fonts($zoo_google_font);
        wp_enqueue_style('zoo-font', $zoo_google_font, false, '');
    }
    // Load custom style
    wp_add_inline_style('zoo-styles', zoo_customize_style($zoo_local_font));
    if (get_theme_mod('zoo_custom_js') != '') {
        wp_add_inline_script('zoo-scripts', zoo_customize_js());
    }
}

if (!function_exists('zoo_customize_js')) {
    function zoo_customize_js()
    {
        $zoo_script = '';
        if (get_theme_mod('zoo_custom_js') != '') {
            $zoo_script = get_theme_mod('zoo_custom_js');
        }
        return $zoo_script;
    }
}
if (!function_exists('zoo_customize_style')) {
    function zoo_customize_style($zoo_local_font = array())
    {
        /* ----------------------------------------------------------
                                    Responsive control
                            Control Breakpoint of header Layout
                            Don't remove this section
        ---------------------------------------------------------- */
        $css = '';
        $theme_settings = get_option(ZOO_SETTINGS_KEY, []);
        $mobile_breakpoint = !empty($theme_settings['mobile_breakpoint_width']) ? strval(intval($theme_settings['mobile_breakpoint_width'])) : '992';
        $css .= '@media(min-width: ' . $mobile_breakpoint . 'px) {
          .wrap-site-header-mobile {
            display: none;
          }
          .show-on-mobile {
            display: none;
          }
        }
        
        @media(max-width: ' . $mobile_breakpoint . 'px) {
          .wrap-site-header-desktop {
            display: none;
          }
          .show-on-desktop {
            display: none;
          }
        }';
        /* ----------------------------------------------------------
                            End Responsive control
                    Control Breakpoint of header Layout
                    Don't remove this section
        ---------------------------------------------------------- */
        /* ----------------------------------------------------------
                                    Typography
                            All typography must add here
        ---------------------------------------------------------- */
        if (!empty($zoo_local_font)) {
            if (in_array('Larsseit', $zoo_local_font)) {
                $css .= '@font-face {
    font-family: \'Larsseit\';
    src: url(\'' . ZOO_THEME_URI.'assets/fonts/larsseit/larsseit-light.otf\') format(\'otf\'),
    url(\'' . ZOO_THEME_URI.'assets/fonts/larsseit/larsseit-light.woff\') format(\'woff\');
    font-weight: 300;
    font-style: normal;
    font-display: auto;
}

@font-face {
    font-family: \'Larsseit\';
    src: url(\'' . ZOO_THEME_URI.'assets/fonts/larsseit/larsseit.otf\') format(\'otf\'),
    url(\'' . ZOO_THEME_URI.'assets/fonts/larsseit/larsseit.woff\') format(\'woff\');
    font-weight: 400;
    font-style: normal;
	font-display: auto;
}

@font-face {
    font-family: \'Larsseit\';
    src: url(\'' . ZOO_THEME_URI.'assets/fonts/larsseit/larsseit-medium.otf\') format(\'otf\'),
    url(\'' . ZOO_THEME_URI.'assets/fonts/larsseit/larsseit-medium.woff\') format(\'woff\');
    font-weight: 500;
    font-style: normal;
	font-display: auto;
}

@font-face {
    font-family: \'Larsseit\';
    src: url(\'' . ZOO_THEME_URI.'assets/fonts/larsseit/larsseit-bold.otf\') format(\'otf\'),
    url(\'' . ZOO_THEME_URI.'assets/fonts/larsseit/larsseit-bold.woff\') format(\'woff\');
    font-weight: 600;
    font-style: normal;
font-display: auto;
}
                ';
            }
        }

        $css .= '@media(min-width:1500px){.container{max-width:' . zoo_site_width() . ';width:100%}}';

        /* ----------------------------------------------------------
                               Load Font
        ---------------------------------------------------------- */
        $body_font = get_theme_mod('zoo_typo_base', '');
        if (isset($body_font['font-size'])) {
            $css .= "html{";
            $css .= "font-size:" . $body_font['font-size'];
            $css .= "}";
        }

        /*Typography generate Css*/
        if ($body_font == '' || $body_font['font'] == '') {
            $css .= "html{";
            $css .= "font-size: 16px;";
            $css .= "}";
            $css .= zoo_generate_css_font('body', array('font-family' => 'Larsseit', 'variant' => '400'));
        }
        if (get_theme_mod('zoo_typo_heading', '') == '' || get_theme_mod('zoo_typo_heading')['font'] == '') {
            $css .= zoo_generate_css_font('h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6', array('font-family' => 'Larsseit', 'variant' => '500'));
        }
        if (get_theme_mod('zoo_typo_woo', '') == '' || get_theme_mod('zoo_typo_woo')['font'] == '') {
            $css .= zoo_generate_css_font('.product-loop-title,  .product_title', array('font-family' => 'Larsseit', 'variant' => '500'));
        }
        /*Preset Color*/
        if (zoo_theme_preset() != '') {
            //put all css class follow accent color to $accent_class
            $accent_color_class = '.blockquote:before, .blockquote:before, blockquote cite:hover, .blockquote cite:hover, .post-content a:hover,.zoo-single-post-nav-item span,.sidebar .widget .recentcomments a:hover,
			.sidebar .widget_rss li .rsswidget:hover, .zoo-posts-widget .post-widget-item a:hover,.post-loop-item .entry-title a:hover ,.primary-menu > ul.nav-menu > li:hover > a, .primary-menu > ul.nav-menu > li.active > a, .primary-menu > ul.nav-menu > li:active > a,
			.cat-item span.count, .widget_archive li span.count, .list-label-cat a:hover, .footer-row .widget_recent_comments a:hover, .builder-block-footer-widget-5 .widget-area .zoo-widget-social-icon.icon li a:hover,
			.builder-block-footer-widget-6 .widget-area .widget_nav_menu a:hover, 
			.woocommerce div.product form.cart .button.zoo-wishlist-button:hover i, .woocommerce div.product form.cart .zoo-wishlist-button.added_to_cart:hover i, .woocommerce div.product form.cart .button.zoo-compare-button:hover i, .woocommerce div.product form.cart .zoo-compare-button.added_to_cart:hover i,
			.woocommerce div.product form.cart .button.zoo-wishlist-button.browse-wishlist i, .woocommerce div.product form.cart .zoo-wishlist-button.browse-wishlist.added_to_cart i, .woocommerce div.product form.cart .button.zoo-compare-button.browse-products-compare i, .woocommerce div.product form.cart .zoo-compare-button.browse-products-compare.added_to_cart i,
			.zoo-extend-cart-info-item a:hover';

	        $accent_bg_class='#zoo-back-to-top:hover,  #zoo-theme-dev-actions .button,.sidebar .widget .recentcomments a:hover:before, .wishlist-counter,.element-cart-icon:not(.inside) .element-cart-count, .post-loop-item .sticky-post-label,
			.grid-layout .wrap-media .sticky-post-label:before, .list-label-cat a, .mc4wp-form .wrap-form-input button,  .zoo-cw-gallery-loading::before, .zoo-cw-gallery-loading::after,
			.notify-form .wpcf7-form > p .wpcf7-submit:hover, li.product .wrap-product-img:after , .woocommerce .wrap-product-loop-buttons .button:hover, .woocommerce .wrap-product-loop-buttons .added_to_cart:hover,
			li.product .zoo-wishlist-button.browse-wishlist, li.product .zoo-compare-button.browse-products-compare, .wrap-content-popup-page .close-popup-page:hover, .woocommerce .zoo-ln-loading::after, .woocommerce .zoo-layer-nav::before,
			.product-sidebar .zoo-ln-slider-range.ui-widget.ui-widget-content .ui-slider-range, .zoo-mask-close.loading:before, .loading.close-zoo-extend-cart-info:before';

	        $accent_border_class='#zoo-back-to-top:hover,.list-label-cat a, .product-sidebar .zoo-ln-slider-range.ui-widget.ui-widget-content .ui-slider-handle';

	        $css .= $accent_color_class . '{color:' . zoo_theme_preset() . '}';
	        $css .= $accent_bg_class . '{background-color:' . zoo_theme_preset() . '}';
	        $css .= $accent_border_class . '{border-color:' . zoo_theme_preset() . '}';
        }
        if (class_exists('WooCommerce')) {
            $gutter = zoo_product_gutter();
            $css .= '.products .product{padding-left:' . $gutter . 'px;padding-right:' . $gutter . 'px}';
            $css .= 'ul.products, .woocommerce ul.products{margin-left:-' . $gutter . 'px !important;margin-right:-' . $gutter . 'px !important;width:calc(100% + ' . ($gutter * 2) . 'px)}';
        }
        if (get_theme_mod('zoo_custom_css') != '') {
            $css .= get_theme_mod('zoo_custom_css');
        }
        return $css;
    }
}