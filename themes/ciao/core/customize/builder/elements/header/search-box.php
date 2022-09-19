<?php

/**
 * Zoo_Customize_Builder_Element_Search_Box
 *
 * @package  Zoo_Theme\Core\Customize\Builder\Elements
 * @author   Zootemplate
 * @link     http://www.zootemplate.com
 *
 */
final class Zoo_Customize_Builder_Element_Search_Box extends Zoo_Customize_Builder_Element
{
    public $id = 'search-box'; // Required
    public $section = 'header_search_box'; // Optional

    /**
     * Optional construct
     *
     * Zoo_Builder_Item_HTML constructor.
     */
    public function __construct()
    {
        $this->title = esc_html__('Search Box', 'ciao');

        add_action('wp_ajax_zoo_get_live_search_results', [$this, '_ajax_get_search_results'], 10, 0);
        add_action('wp_ajax_nopriv_zoo_get_live_search_results', [$this, '_ajax_get_search_results'], 10, 0);
    }

    /**
     * Register Builder item
     * @return array
     */
    public function get_builder_configs()
    {
        return array(
            'name' => $this->title,
            'id' => $this->id,
            'col' => 0,
            'width' => 3,
            'section' => $this->section // Customizer section to focus when click settings
        );
    }

    /**
     * Optional, Register customize section and panel.
     *
     * @return array
     */
    public function get_customize_configs(WP_Customize_Manager $wp_customize = null)
    {
        // Render callback function
        $fn = array($this, 'render');
        $selector = ".site-header .header-search-box";
        $config = array(
            array(
                'name' => $this->section,
                'type' => 'section',
                'panel' => 'header_settings',
                'title' => $this->title,
            ),

            [
                'name' => $this->section . '_heading_general',
                'type' => 'heading',
                'section' => $this->section,
                'priority' => 0,
                'title' => esc_html__('General Settings', 'ciao'),
            ],
            array(
                'name'            => $this->section .'_icon_preset',
                'type'            => 'image_select',
                'section'         => $this->section,
                'render_callback' => [$this, 'render'],
                'title'           => esc_html__('Icon Style', 'ciao'),
                'default'         => 'preset-1',
                'css_format'      => 'html_class',
                'device_settings' => true,
                'priority' => 0,
                'choices'         => array(
                    'style-1'         => array(
                        'img' => ZOO_THEME_URI . 'core/assets/images/search-preset-1.png',
                    ),'style-2'         => array(
                        'img' => ZOO_THEME_URI . 'core/assets/images/search-preset-2.png',
                    ),'style-3'         => array(
                        'img' => ZOO_THEME_URI . 'core/assets/images/search-preset-3.png',
                    ),'style-4'         => array(
                        'img' => ZOO_THEME_URI . 'core/assets/images/search-preset-4.png',
                    ),'style-5'         => array(
                        'img' => ZOO_THEME_URI . 'core/assets/images/search-preset-5.png',
                    ),
                )
            ),

            [
                'name' => $this->section . '_show_icon_only',
                'type' => 'checkbox',
                'section' => $this->section,
                'render_callback' => 'Zoo_Customize_Header_Builder::render',
                'title' => esc_html__('Show only search icon', 'ciao'),
                'checkbox_label' => esc_html__('Will be showed if checked.', 'ciao'),
                'device_settings' => true,
                'priority' => 0
            ],
            [
                'name' => $this->section . '_live_search_enable',
                'type' => 'checkbox',
                'section' => $this->section,
                'render_callback' => 'Zoo_Customize_Header_Builder::render',
                'title' => esc_html__('AJAX Live Search', 'ciao'),
                'checkbox_label' => esc_html__('Will be enabled if checked.', 'ciao'),
                'priority' => 1
            ],
            array(
                'name' => $this->section . '_placeholder',
                'type' => 'text',
                'section' => $this->section,
                'selector' => "$selector",
                'render_callback' => $fn,
                'label' => esc_html__('Placeholder', 'ciao'),
                'default' => esc_html__('Search ...', 'ciao'),
            ),array(
                'name' => $this->section . '_button_label',
                'type' => 'text',
                'section' => $this->section,
                'selector' => "$selector",
                'render_callback' => $fn,
                'label' => esc_html__('Button Label', 'ciao'),
                'description' => esc_html__('Leave it blank if don\'t want show.', 'ciao'),
                'default' => esc_html__('', 'ciao'),
            ),
            [
                'name' => $this->section . '_heading_style',
                'type' => 'heading',
                'section' => $this->section,
                'title' => esc_html__('Style Settings', 'ciao'),
            ],[
                'name' => $this->section . '_advanced_styling',
                'type' => 'checkbox',
                'section' => $this->section,
                'title' => esc_html__('Enable Advanced Styling', 'ciao'),
                'checkbox_label' => esc_html__('Allow change style if checked', 'ciao'),
            ],
            array(
                'name' => $this->section . '_width',
                'type' => 'slider',
                'device_settings' => true,
                'section' => $this->section,
                'selector' => "$selector .header-search-form",
                'css_format' => 'width: {{value}};',
                'label' => esc_html__('Search Form Width', 'ciao'),
                'description' => esc_html__('Note: The width can not greater than grid width.', 'ciao'),
                'required'=>[$this->section . '_advanced_styling','==',1]
            ),

            array(
                'name' => $this->section . '_height',
                'type' => 'slider',
                'device_settings' => true,
                'section' => $this->section,
                'min' => 0,
                'step' => 1,
                'max' => 100,
                'default' => 40,
                'selector' => "$selector .header-search-form",
                'css_format' => 'height: {{value}};',
                'label' => esc_html__('Search Form Height', 'ciao'),
                'required'=>[$this->section . '_advanced_styling','==',1]
            ),
            array(
                'name' => $this->section . '_icon_size',
                'type' => 'slider',
                'device_settings' => true,
                'section' => $this->section,
                'min' => 5,
                'step' => 1,
                'max' => 100,
                'selector' => "$selector .btn-lb-search>i, $selector .header-search-form .button.search-submit>i",
                'css_format' => 'line-height: {{value}}; font-size: {{value}};width: {{value}};height: {{value}}',
                'label' => esc_html__('Icon Size', 'ciao'),
                'required'=>[$this->section . '_advanced_styling','==',1]
            ),

            array(
                'name' => $this->section . '_icon_pos',
                'type' => 'slider',
                'device_settings' => true,
                'default' => array(
                    'desktop' => array(
                        'value' => 0,
                        'unit' => 'px'
                    ),
                    'mobile' => array(
                        'value' => 0,
                        'unit' => 'px'
                    ),
                ),
                'section' => $this->section,
                'min' => -150,
                'step' => 1,
                'max' => 90,
                'selector' => "$selector .btn-lb-search",
                'css_format' => 'margin-left: {{value}}; ',
                'label' => esc_html__('Icon Position', 'ciao'),
                'required'=>[$this->section . '_advanced_styling','==',1]
            ),
            array(
                'name' => $this->section . '_form_styling',
                'type' => 'styling',
                'section' => $this->section,
                'css_format' => 'styling',
                'title' => esc_html__('Form Styling', 'ciao'),
                'description' => esc_html__('Styling for search form', 'ciao'),
                'required'=>[$this->section . '_advanced_styling','==',1],
                'selector' => array(
                    'normal' => "{$selector} form.header-search-form",
                ),
                'fields' => array(
                    'normal_fields' => array(
                        'text_color' => false,
                        'link_color' => false,
                        'bg_cover' => false,
                        'bg_image' => false,
                        'bg_repeat' => false,
                        'bg_attachment' => false,
                        'margin' => false,
                        'link_hover_color'   => false,
                    ),
                    'hover_fields' => false,
                )
            ),
            array(
                'name' => $this->section . '_font_size',
                'type' => 'typography',
                'section' => $this->section,
                'selector' => "$selector .header-search-form .search-field",
                'css_format' => 'typography',
                'label' => esc_html__('Input Text Typography', 'ciao'),
                'description' => esc_html__('Typography for search input', 'ciao'),
                'required'=>[$this->section . '_advanced_styling','==',1]
            ),

            array(
                'name' => $this->section . '_input_styling',
                'type' => 'styling',
                'section' => $this->section,
                'css_format' => 'styling',
                'title' => esc_html__('Input Styling', 'ciao'),
                'description' => esc_html__('Search input styling', 'ciao'),
                'required'=>[$this->section . '_advanced_styling','==',1],
                'selector' => array(
                    'normal' => "{$selector} .search-field, {$selector} .wrap-form-lb-search .header-search-form .search-field",
                    'hover' => "{$selector} .search-field:focus, {$selector} .wrap-form-lb-search .header-search-form .search-field:focus",
                    'normal_text_color' => "{$selector} .search-field, {$selector} input.search-field::placeholder,{$selector} .wrap-form-lb-search .header-search-form .search-field,{$selector} .wrap-form-lb-search .header-search-form .search-field::placeholder",
                ),
                'default' => array(
                    'normal' => array(
                        'border_style' => 'none'
                    )
                ),
                'fields' => array(
                    'normal_fields' => array(
                        'link_color' => false, // disable for special field.
                        'bg_cover' => false,
                        'bg_image' => false,
                        'bg_repeat' => false,
                        'bg_attachment' => false,
                        'margin' => false,
                        'link_hover_color'   => false,
                    ),
                    'hover_fields' => array(
                        'link_color' => false,
                        'padding' => false,
                        'bg_cover' => false,
                        'bg_image' => false,
                        'bg_repeat' => false,
                        'border_radius' => false,
                    ), // disable hover tab and all fields inside.
                )
            ),

            array(
                'name' => $this->section . '_cat_styling',
                'type' => 'styling',
                'section' => $this->section,
                'css_format' => 'styling',
                'required'=>[$this->section . '_advanced_styling','==',1],
                'title' => esc_html__('Categories field styling', 'ciao'),
                'description' => esc_html__('Categories field styling', 'ciao'),
                'selector' => array(
                    'normal' => "{$selector} .header-search-form .wrap-list-cat-search,{$selector}  .wrap-form-lb-search .header-search-form .wrap-list-cat-search",
                    'hover' => "{$selector} .header-search-form .wrap-list-cat-search:hover,{$selector}  .wrap-form-lb-search .header-search-form .wrap-list-cat-search:hover",
                ),
                'fields' => array(
                    'normal_fields' => array(
                        'link_color' => false, // disable for special field.
                        'bg_cover' => false,
                        'bg_image' => false,
                        'bg_repeat' => false,
                        'bg_attachment' => false,
                        //'padding' => false,
                        'margin' => false,
                        'link_hover_color'   => false,
                    ),
                    'hover_fields' => array(
                        'link_color' => false,
                        'padding' => false,
                        'bg_cover' => false,
                        'bg_image' => false,
                        'bg_repeat' => false,
                        'bg_attachment' => false,
                        'border_radius' => false,
                    ), // disable hover tab and all fields inside.
                )
            ),
            array(
                'name' => $this->section . '_icon_styling',
                'type' => 'styling',
                'section' => $this->section,
                'css_format' => 'styling',
                'title' => esc_html__('Icon Styling', 'ciao'),
                'description' => esc_html__('Search icon styling for light box search', 'ciao'),
                'required'=>[$this->section . '_advanced_styling','==',1],
                'selector' => array(
                    'normal' => "{$selector} .btn-lb-search",
                    'hover' => "{$selector} .btn-lb-search:hover",
                ),
                'fields' => array(
                    'normal_fields' => array(
                        'link_color' => false, // disable for special field.
                        'bg_cover' => false,
                        'bg_image' => false,
                        'bg_repeat' => false,
                        'bg_attachment' => false,
                        //'padding' => false,
                        'margin' => false,
                        'link_hover_color'   => false,
                    ),
                    'hover_fields' => array(
                        'link_color' => false,
                        'padding' => false,
                        'bg_cover' => false,
                        'bg_image' => false,
                        'bg_repeat' => false,
                        'bg_attachment' => false,
                        'border_radius' => false,
                    ), // disable hover tab and all fields inside.
                )
            ),
            array(
                'name' => $this->section . '_button_styling',
                'type' => 'styling',
                'section' => $this->section,
                'css_format' => 'styling',
                'title' => esc_html__('Button Search Styling', 'ciao'),
                'description' => esc_html__('Search input styling', 'ciao'),
                'required'=>[$this->section . '_advanced_styling','==',1],
                'selector' => array(
                    'normal' => "{$selector} .header-search-form .button.search-submit",
                    'hover' => "{$selector} .header-search-form .button.search-submit:hover",
                ),
                'fields' => array(
                    'normal_fields' => array(
                        'link_color' => false, // disable for special field.
                        'bg_cover' => false,
                        'bg_image' => false,
                        'bg_repeat' => false,
                        'bg_attachment' => false,
                        //'padding' => false,
                        'margin' => false,
                        'link_hover_color'   => false,
                    ),
                    'hover_fields' => array(
                        'link_color' => false,
                        'padding' => false,
                        'bg_cover' => false,
                        'bg_image' => false,
                        'bg_repeat' => false,
                        'bg_attachment' => false,
                        'border_radius' => false,
                    ), // disable hover tab and all fields inside.
                )
            ),


        );

        if (class_exists('WooCommerce', false)) {
            $config[] = [
                'name' => $this->section . '_show_product_cat_options',
                'type' => 'checkbox',
                'section' => $this->section,
                'priority' => 2,
                'render_callback' => 'Zoo_Customize_Header_Builder::render',
                'title' => esc_html__('Product Categories&#8217; Options', 'ciao'),
                'checkbox_label' => esc_html__('Will be showed if checked.', 'ciao')
            ];
        }

        // Item Layout
        return array_merge($config, $this->get_layout_configs('#site-header'));
    }

    /**
     * Optional. Render item content
     */
    public function render()
    {
        $atts = [];
        $args  = func_get_args();
        $align = zoo_customize_get_setting($this->builder_id.'_'.$this->id.'_align');

        if ($align) {
            if (!empty($args[1]) && is_array($align)) {
                $align = $align[$args[1]];
            }
            $atts['align'] = $align;
        }

        $atts['icon-only'] = zoo_customize_get_setting($this->section . '_show_icon_only', $args[1]);
        $atts['placeholder'] = zoo_customize_get_setting($this->section . '_placeholder');
        $atts['button-label'] = zoo_customize_get_setting($this->section . '_button_label');
        $atts['preset'] = zoo_customize_get_setting($this->section . '_icon_preset', $args[1]);
        $atts['live-search'] = zoo_customize_get_setting($this->section . '_live_search_enable');
        $atts['show-cat'] = zoo_customize_get_setting($this->section . '_show_product_cat_options');
        $atts['advanced-styling'] = zoo_customize_get_setting($this->section . '_advanced_styling');

        $tpl = apply_filters('header/element/search-box', ZOO_THEME_DIR . 'core/customize/templates/header/element-search-box.php', $atts);

        require $tpl;
    }

    /**
     * @internal  Used as a callback.
     */
    public function _ajax_get_search_results()
    {
        if (isset($_POST['searchQuery'])) {
            $queries = json_decode(stripslashes($_POST['searchQuery']));
            $query_args = [
                's' => sanitize_text_field($queries->queryString),
                'post_type' => 'any'
            ];
            if (!empty($queries->productCat)) {
                $query_args['post_type'] = 'product';
                if ($queries->productCat != 'all') {
                    $query_args['tax_query'][] = [
                        'taxonomy' => 'product_cat',
                        'terms' => intval($queries->productCat)
                    ];
                }
            }
            $search_result = get_posts($query_args);
            ob_start();
            if ($search_result && is_array($search_result)) {
                global $post;
                ?>
                <div class="wrap-search-result">
                    <ul class="list-search-result">
                        <?php foreach ($search_result as $post) : setup_postdata($post); ?>
                            <li class="search-result-item">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                    <div class="wrap-img-result">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    </div>
                                    <div class="wrap-result-content">
                                        <h3 class="title-result"><?php the_title(); ?></h3>
                                        <?php
                                        if ('product' === $post->post_type && class_exists('WC_Product')) { ?>
                                            <p class="price amount">
                                                <?php
                                                $prdct = new WC_Product($post->ID);
                                                echo wp_kses_post($prdct->get_price_html());
                                                ?>
                                            </p>
                                            <?php
                                        } else {
                                            echo zoo_strip_all_shortcodes(get_the_excerpt());
                                        } ?>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php
                wp_reset_postdata();
            } else {
                ?><div class="wrap-search-result no-result"><?php esc_html_e('No result found!', 'ciao'); ?></div><?php
            }
            $output = ob_get_contents();
            ob_end_clean();
            echo wp_kses_post($output);
            exit;
        }
    }
}

$self->add_element('header', new Zoo_Customize_Builder_Element_Search_Box());
