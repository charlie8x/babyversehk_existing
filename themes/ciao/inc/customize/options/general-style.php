<?php
/**
 * Customize for General Style
 */
return [
    [
        'name' => 'zoo_style',
        'type' => 'panel',
        'label' => esc_html__('Style', 'ciao'),
    ], [
        'name' => 'zoo_general_style',
        'type' => 'section',
        'label' => esc_html__('General Style', 'ciao'),
        'panel' => 'zoo_style',
        'description' => esc_html__('Leave option blank if you want use default style of theme.', 'ciao'),
    ],
    [
        'name' => 'zoo_general_style_heading_color',
        'type' => 'heading',
        'section' => 'zoo_general_style',
        'title' => esc_html__('Color', 'ciao'),
    ],
    [
        'name' => 'zoo_color_preset',
        'type' => 'select',
        'section' => 'zoo_general_style',
        'title' => esc_html__('Preset', 'ciao'),
        'description' => esc_html__('Predefined color scheme to Style', 'ciao'),
        'default' => 'default',
        'choices' => [
            'default' => esc_html__('Default', 'ciao'),
            'black' => esc_html__('Black', 'ciao'),
            'blue' => esc_html__('Blue', 'ciao'),
            'red' => esc_html__('Red', 'ciao'),
            'yellow' => esc_html__('Yellow', 'ciao'),
            'green' => esc_html__('Green', 'ciao'),
            'grey' => esc_html__('Grey', 'ciao'),
            'custom' => esc_html__('Custom', 'ciao'),
        ]
    ],
    [
        'name' => 'zoo_primary_color',
        'type' => 'color',
        'section' => 'zoo_general_style',
        'title' => esc_html__('Primary color', 'ciao'),
        'selector' => ".accent-color",
        'css_format' => 'color: {{value}};',
        'description' => esc_html__('Primary color of theme apply only when preset is custom.', 'ciao'),
        'required'=>['zoo_color_preset','==','custom']
    ],[
        'name' => 'zoo_site_color',
        'type' => 'color',
        'section' => 'zoo_general_style',
        'title' => esc_html__('Text color', 'ciao'),
        'selector' => "body",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'zoo_site_link_color',
        'type' => 'color',
        'section' => 'zoo_general_style',
        'title' => esc_html__('Link color', 'ciao'),
        'selector' => "a",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'zoo_site_link_color_hover',
        'type' => 'color',
        'section' => 'zoo_general_style',
        'title' => esc_html__('Link color hover', 'ciao'),
        'selector' => "a:hover",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'zoo_site_heading_color',
        'type' => 'color',
        'section' => 'zoo_general_style',
        'title' => esc_html__('Heading color', 'ciao'),
        'selector' => "h1, h2, h3, h4, h5, h6",
        'css_format' => 'color: {{value}};',
    ],
    [
        'name' => 'zoo_general_heading_bg',
        'type' => 'heading',
        'section' => 'zoo_general_style',
        'title' => esc_html__('Background', 'ciao'),
    ],
    [
        'name' => 'zoo_general_bg',
        'type' => 'styling',
        'section' => 'zoo_general_style',
        'title'  => esc_html__('Background', 'ciao'),
        'selector' => [
            'normal' => "body",
        ],
        'field_class'=>'no-hide no-heading',
        'css_format' => 'styling', // styling
        'fields' => [
            'normal_fields' => [
                'text_color' => false,
                'link_color' => false,
                'link_hover_color' => false,
                'padding' => false,
                'box_shadow' => false,
                'border_radius' => false,
                'border_style' => false,
                'border_heading' => false,
                'bg_heading' => false,
                'margin' => false
            ],
            'hover_fields' => false
        ]
    ],
];
