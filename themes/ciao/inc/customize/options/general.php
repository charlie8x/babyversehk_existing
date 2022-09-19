<?php
/**
 * Customize for Site
 */
return [
    [
        'name' => 'zoo_general',
        'type' => 'section',
        'label' => esc_html__('General', 'ciao'),
        'priority'=>0
    ],
    [
        'name' => 'zoo_site_layout',
        'type' => 'select',
        'section' => 'zoo_general',
        'title' => esc_html__('Site Layout', 'ciao'),
        'description' => esc_html__('Config Layout for site', 'ciao'),
        'default' => 'normal',
        'choices' => [
            'normal' => esc_html__('Normal', 'ciao'),
            'boxed' => esc_html__('Boxed', 'ciao'),
            'full-width' => esc_html__('Full Width', 'ciao'),
        ]
    ],[
        'name' => 'zoo_site_max_width',
        'type' => 'number',
        'section' => 'zoo_general',
        'title' => esc_html__('Site Max Width', 'ciao'),
        'description' => esc_html__('Max width content of site. Leave it blank or 0, size max width will full width.', 'ciao'),
        'default' => '1400',
    ],[
        'name' => 'zoo_disable_breadcrumbs',
        'type' => 'checkbox',
        'section' => 'zoo_general',
        'title' => esc_html__('Disable Breadcrumbs', 'ciao'),
        'default' => 0,
        'checkbox_label' => esc_html__('Breadcrumbs will remove if checked.', 'ciao'),
    ],[
        'name' => 'zoo_disable_emojis',
        'type' => 'checkbox',
        'section' => 'zoo_general',
        'title' => esc_html__('Disable Emojis', 'ciao'),
        'default' => 1,
        'checkbox_label' => esc_html__('Emojis will remove if checked.', 'ciao'),
    ],[
        'name' => 'zoo_enable_lazy_image',
        'type' => 'checkbox',
        'section' => 'zoo_general',
        'title' => esc_html__('Enable Lazy Load Images', 'ciao'),
        'default' => 1,
        'checkbox_label' => esc_html__('Enable Lazy Load Images if checked.', 'ciao'),
    ],[
        'name' => 'zoo_enable_site_meta',
        'type' => 'checkbox',
        'section' => 'zoo_general',
        'title' => esc_html__('Enable Site Meta', 'ciao'),
        'default' => 0,
        'checkbox_label' => esc_html__('Show post thumbnail, title, description when share.', 'ciao'),
    ],[
        'name' => 'zoo_enable_back_top_top',
        'type' => 'checkbox',
        'section' => 'zoo_general',
        'title' => esc_html__('Enable Back to Top', 'ciao'),
        'default' => 1,
        'checkbox_label' => esc_html__('Show button back to top.', 'ciao'),
    ],
];