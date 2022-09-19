<?php
/**
 * Customize for General Style
 */
return [ 
    [
        'name' => 'zoo_blog_style',
        'type' => 'section',
        'label' => esc_html__('Blog Style', 'ciao'),
        'panel' => 'zoo_style',
    ],
    [
        'name' => 'zoo_blog_archive_heading_color',
        'type' => 'heading',
        'section' => 'zoo_blog_style',
        'title' => esc_html__('Blog Archive', 'ciao'),
    ],
    [
        'name' => 'zoo_blog_title_color',
        'type' => 'color',
        'section' => 'zoo_blog_style',
        'title' => esc_html__('Title Color', 'ciao'),
        'selector' => ".post-loop-item .entry-title",
        'css_format' => 'color: {{value}};',
    ],    [
        'name' => 'zoo_site_title_color_hover',
        'type' => 'color',
        'section' => 'zoo_blog_style',
        'title' => esc_html__('Title Color Hover', 'ciao'),
        'selector' => ".post-loop-item .entry-title:hover",
        'css_format' => 'color: {{value}};',
    ],
    [
        'name' => 'zoo_blog_date_color',
        'type' => 'color',
        'section' => 'zoo_blog_style',
        'title' => esc_html__('Post date color', 'ciao'),
        'selector' => ".post-loop-item .post-date",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'zoo_blog_excerpt_color',
        'type' => 'color',
        'section' => 'zoo_blog_style',
        'title' => esc_html__('Excerpt color', 'ciao'),
        'selector' => ".post-loop-item .entry-content",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'zoo_blog_readmore_color',
        'type' => 'color',
        'section' => 'zoo_blog_style',
        'title' => esc_html__('Read More color', 'ciao'),
        'selector' => ".post-loop-item .readmore",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'zoo_blog_readmore_color_hover',
        'type' => 'color',
        'section' => 'zoo_blog_style',
        'title' => esc_html__('Link color hover', 'ciao'),
        'selector' => ".post-loop-item .readmore:hover",
        'css_format' => 'color: {{value}};',
    ],
    [
        'name' => 'zoo_blog_single_heading_color',
        'type' => 'heading',
        'section' => 'zoo_blog_style',
        'title' => esc_html__('Blog Single', 'ciao'),
    ],
    [
        'name' => 'zoo_blog_single_title_color',
        'type' => 'color',
        'section' => 'zoo_blog_style',
        'title' => esc_html__('Title post', 'ciao'),
        'selector' => ".post-loop-item .readmore:hover",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'zoo_blog_single_info_color',
        'type' => 'color',
        'section' => 'zoo_blog_style',
        'title' => esc_html__('Post Information', 'ciao'),
        'description' => esc_html__('Color of block date post, categories, author.', 'ciao'),
        'selector' => "post-detail .post-info",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'zoo_blog_single_info_color_hover',
        'type' => 'color',
        'section' => 'zoo_blog_style',
        'title' => esc_html__('Post Information Link hover', 'ciao'),
        'description' => esc_html__('Color hover link of block date post, categories, author.', 'ciao'),
        'selector' => ".post-detail .post-info a:hover",
        'css_format' => 'color: {{value}};',
    ],
];
