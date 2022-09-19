<?php
/**
 * Customize for Blog Single
 */
return [
    [
        'name' => 'zoo_blog_single',
        'type' => 'section',
        'label' => esc_html__('Blog Single', 'ciao'),
        'panel' => 'zoo_blog',
    ],
    [
        'name' => 'zoo_blog_single_general_settings',
        'type' => 'heading',
        'label' => esc_html__('General Settings', 'ciao'),
        'section' => 'zoo_blog_single',
    ],
    [
        'name' => 'zoo_blog_single_sidebar_config',
        'type' => 'select',
        'section' => 'zoo_blog_single',
        'title' => esc_html__('Sidebar layout', 'ciao'),
        'default' => 'none',
        'choices' => [
            'none' => esc_html__('None', 'ciao'),
            'left' => esc_html__('Left', 'ciao'),
            'right' => esc_html__('Right', 'ciao'),
        ]
    ],
    [
        'name' => 'zoo_blog_single_sidebar',
        'type' => 'select',
        'section' => 'zoo_blog_single',
        'title' => esc_html__('Sidebar', 'ciao'),
        'required' => ['zoo_blog_single_sidebar_config', '!=', 'none'],
        'choices' => zoo_get_registered_sidebars()
    ],
    [
        'name' => 'zoo_blog_single_post_info_style',
        'type' => 'select',
        'section' => 'zoo_blog_single',
        'title' => esc_html__('Post info style', 'ciao'),
        'default' => 'icon',
        'choices' => [
            'icon' => esc_html__('icon', 'ciao'),
            'text' => esc_html__('Text', 'ciao'),
        ]
    ],
    [
        'name' => 'zoo_enable_blog_author_post',
        'type' => 'checkbox',
        'section' => 'zoo_blog_single',
        'label' => esc_html__('Enable Author Post', 'ciao'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'ciao'),
        'default' => 1
    ], [
        'name' => 'zoo_enable_blog_date_post',
        'type' => 'checkbox',
        'section' => 'zoo_blog_single',
        'label' => esc_html__('Enable Date Post', 'ciao'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'ciao'),
        'default' => 1
    ], [
        'name' => 'zoo_enable_blog_cat_post',
        'type' => 'checkbox',
        'section' => 'zoo_blog_single',
        'label' => esc_html__('Enable Post Categories', 'ciao'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'ciao'),
        'default' => 1
    ], [
        'name' => 'zoo_enable_blog_tags',
        'type' => 'checkbox',
        'section' => 'zoo_blog_single',
        'label' => esc_html__('Enable Tags', 'ciao'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'ciao'),
        'default' => 1
    ],
    [
        'name' => 'zoo_enable_blog_share',
        'type' => 'checkbox',
        'section' => 'zoo_blog_single',
        'label' => esc_html__('Enable Share', 'ciao'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'ciao'),
        'default' => 1
    ],
    [
        'name' => 'zoo_enable_next_previous_posts',
        'type' => 'checkbox',
        'section' => 'zoo_blog_single',
        'label' => esc_html__('Enable Next & Previous Posts', 'ciao'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'ciao'),
        'default' => 1
    ],
    [
        'name' => 'zoo_blog_single_related_post',
        'type' => 'heading',
        'label' => esc_html__('Related Post Settings', 'ciao'),
        'section' => 'zoo_blog_single',
        'theme_supports' => 'woocommerce'
    ],
    [
        'name' => 'zoo_enable_blog_related',
        'type' => 'checkbox',
        'section' => 'zoo_blog_single',
        'label' => esc_html__('Enable Related Posts', 'ciao'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'ciao'),
        'default' => 1
    ],
    [
        'name' => 'zoo_blog_related_numbers',
        'type' => 'number',
        'section' => 'zoo_blog_single',
        'label' => esc_html__('Related post numbers', 'ciao'),
        'default' => 3,
        'required' => ['zoo_enable_blog_related', '==', 1],
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
            'class' => 'zoo-range-slider'
        ),
    ], [
        'name' => 'zoo_blog_related_cols',
        'type' => 'number',
        'section' => 'zoo_blog_single',
        'label' => esc_html__('Related post columns', 'ciao'),
        'default' => 3,
        'required' => ['zoo_enable_blog_related', '==', 1],
        'input_attrs' => array(
            'min' => 1,
            'max' => 6,
            'class' => 'zoo-range-slider'
        ),
    ],
];