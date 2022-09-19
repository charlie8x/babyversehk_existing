<?php
/**
 * Customize for Shop loop product
 */
return [
    [
        'name' => 'zoo_blog',
        'type' => 'panel',
        'label' => esc_html__('Blog', 'ciao'),
    ],[
        'name' => 'zoo_blog_archive',
        'type' => 'section',
        'label' => esc_html__('Blog Archive', 'ciao'),
        'panel' => 'zoo_blog',
    ],
    [
        'name' => 'zoo_blog_general_settings',
        'type' => 'heading',
        'label' => esc_html__('General Settings', 'ciao'),
        'section' => 'zoo_blog_archive',
    ],
    [
        'name' => 'zoo_blog_layout',
        'type' => 'select',
        'section' => 'zoo_blog_archive',
        'title' => esc_html__('Layout', 'ciao'),
        'default' => 'list',
        'choices' => [
            'list' => esc_html__('List', 'ciao'),
            'grid' => esc_html__('Grid', 'ciao'),
        ]
    ],
    [
        'name' => 'zoo_blog_grid_img_size',
        'type' => 'select',
        'section' => 'zoo_blog_archive',
        'label' => esc_html__('Image size', 'ciao'),
        'description' => esc_html__('Select image size fit with layout you want use for improve performance.', 'ciao'),
        'default' => 'medium',
        'required' => ['zoo_blog_layout', '!=', 'list'],
	    'choices'=>zoo_get_image_sizes()

    ],
	[
        'name' => 'zoo_blog_img_size',
        'type' => 'select',
        'section' => 'zoo_blog_archive',
        'label' => esc_html__('Image size', 'ciao'),
        'description' => esc_html__('Select image size fit with layout you want use for improve performance.', 'ciao'),
        'default' => 'full',
        'required' => ['zoo_blog_layout', '==', 'list'],
	    'choices'=>zoo_get_image_sizes()

    ],
	[
        'name' => 'zoo_blog_cols',
        'type' => 'number',
        'section' => 'zoo_blog_archive',
        'label' => esc_html__('Columns', 'ciao'),
        'default' => 3,
        'required' => ['zoo_blog_layout', '!=', 'list'],
        'input_attrs' => array(
            'min' => 1,
            'max' => 6,
            'class' => 'zoo-range-slider'
        ),
    ],
    [
        'name' => 'zoo_enable_blog_cover',
        'type' => 'checkbox',
        'section' => 'zoo_blog_archive',
        'label' => esc_html__('Enable Blog Cover', 'ciao'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'ciao'),
        'default' => 0
    ],
    [
        'name' => 'zoo_blog_cover',
        'type' => 'styling',
        'section' => 'zoo_blog_archive',
        'title' => esc_html__('Blog cover style', 'ciao'),
        'description' => esc_html__('Styling for categories page', 'ciao'),
        'required' => ['zoo_enable_blog_cover', '==', '1'],
        'selector' => [
            'normal' => '.wrap-blog-cover',
        ],
        'css_format' => 'styling',
        'default' => [],
        'fields' => [
            'normal_fields' => [
                'margin' => false,
                'link_color' => false,
                'border_style' => false,
                'border_heading' => false,
                'border_radius' => false,
                'box_shadow' => false,
                'link_hover_color'   => false,
            ],
            'hover_fields' => false
        ]
    ],
    [
        'name' => 'zoo_blog_sidebar_settings',
        'type' => 'heading',
        'label' => esc_html__('Sidebar Settings', 'ciao'),
        'section' => 'zoo_blog_archive'
    ],
    [
        'name' => 'zoo_blog_sidebar_config',
        'type' => 'select',
        'section' => 'zoo_blog_archive',
        'title' => esc_html__('Sidebar layout', 'ciao'),
        'default' => 'left',
        'choices' => [
            'none' => esc_html__('None', 'ciao'),
            'left' => esc_html__('Left', 'ciao'),
            'right' => esc_html__('Right', 'ciao'),
        ]
    ],[
        'name' => 'zoo_blog_sidebar',
        'type' => 'select',
        'section' => 'zoo_blog_archive',
        'title' => esc_html__('Sidebar', 'ciao'),
        'required' => ['zoo_blog_sidebar_config', '!=', 'none'],
        'choices' => zoo_get_registered_sidebars()
    ],
    [
        'name' => 'zoo_blog_item_settings',
        'type' => 'heading',
        'label' => esc_html__('Blog Item', 'ciao'),
        'section' => 'zoo_blog_archive',
    ],
    [
        'name' => 'zoo_blog_loop_post_info_style',
        'type' => 'select',
        'section' => 'zoo_blog_archive',
        'title' => esc_html__('Post info style', 'ciao'),
        'default' => 'icon',
        'choices' => [
            'icon' => esc_html__('icon', 'ciao'),
            'text' => esc_html__('Text', 'ciao'),
        ]
    ],
    [
        'name' => 'zoo_enable_loop_author_post',
        'type' => 'checkbox',
        'section' => 'zoo_blog_archive',
        'label' => esc_html__('Enable Author Post', 'ciao'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'ciao'),
        'default' => 1
    ], [
        'name' => 'zoo_enable_loop_date_post',
        'type' => 'checkbox',
        'section' => 'zoo_blog_archive',
        'label' => esc_html__('Enable Date Post', 'ciao'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'ciao'),
        'default' => 1
    ], [
        'name' => 'zoo_enable_loop_cat_post',
        'type' => 'checkbox',
        'section' => 'zoo_blog_archive',
        'label' => esc_html__('Enable Post Categories', 'ciao'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'ciao'),
        'default' => 1
    ],
    [
        'name' => 'zoo_enable_loop_excerpt',
        'type' => 'checkbox',
        'section' => 'zoo_blog_archive',
        'label' => esc_html__('Enable Blog Excerpt', 'ciao'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'ciao'),
        'default' => 1
    ],
    [
        'name' => 'zoo_loop_excerpt_length',
        'type' => 'number',
        'section' => 'zoo_blog_archive',
        'label' => esc_html__('Blog Excerpt length', 'ciao'),
        'default' => 30,
        'required' => ['zoo_enable_loop_excerpt', '==', 1],
        'input_attrs' => array(
            'min' => 1,
            'max' => 256,
            'class' => 'zoo-range-slider'
        ),
    ],
    [
        'name' => 'zoo_enable_loop_readmore',
        'type' => 'checkbox',
        'section' => 'zoo_blog_archive',
        'label' => esc_html__('Enable Read more', 'ciao'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'ciao'),
        'default' => 1
    ]
];