<?php
/**
 * Meta box for theme
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @core        3.0.0
 * @author      Zootemplate
 * @link        https://www.zootemplate.com/
 * @copyright   Copyright (c) 2018 ZooTemplate
 */

if ( class_exists( 'RWMB_Loader' ) ):
	add_filter( 'rwmb_meta_boxes', 'zoo_meta_box_options' );
	if ( ! function_exists( 'zoo_meta_box_options' ) ) {
		function zoo_meta_box_options() {
			$zoo_prefix       = "zoo_";
			$zoo_meta_boxes   = array();
			$zoo_meta_boxes[] = array(
				'id'      => $zoo_prefix . 'single_post_heading',
				'title'   => esc_html__( 'Sidebar Config', 'ciao' ),
				'pages'   => array( 'post' ),
				'context' => 'side',
				'fields'  => array(
					array(
						'id'      => $zoo_prefix . "blog_single_sidebar_config",
						'type'    => 'select',
						'options' => array(
							'inherit' => esc_html__( 'Inherit', 'ciao' ),
							'left'    => esc_html__( 'Left', 'ciao' ),
							'right'   => esc_html__( 'Right', 'ciao' ),
							'none'    => esc_html__( 'None', 'ciao' ),
						),
						'std'     => 'inherit',
						'desc'    => esc_html__( 'Select sidebar layout you want set for this post.', 'ciao' )
					),
				)
			);
			//All page
			$zoo_meta_boxes[] = array(
				'id'      => $zoo_prefix . 'layout_single_heading',
				'title'   => esc_html__( 'Layout Single Product', 'ciao' ),
				'pages'   => array( 'product' ),
				'context' => 'advanced',
				'fields'  => array(
					array(
						'name'    => esc_html__( 'Layout Options', 'ciao' ),
						'id'      => $zoo_prefix . "single_product_layout",
						'type'    => 'select',
						'options' => array(
							'inherit'          => esc_html__( 'Inherit', 'ciao' ),
							'vertical-thumb'   => esc_html__( 'Product V1', 'ciao' ),
							'horizontal-thumb' => esc_html__( 'Product V2', 'ciao' ),
							'carousel'         => esc_html__( 'Product V3', 'ciao' ),
							'grid-thumb'       => esc_html__( 'Product V4', 'ciao' ),
							'sticky-1'         => esc_html__( 'Product V5', 'ciao' ),
							'sticky-2'         => esc_html__( 'Product V6', 'ciao' ),
							'sticky-3'         => esc_html__( 'Product V7', 'ciao' ),
							//'accordion'        => esc_html__( 'Product V7', 'ciao' ),
							'custom'           => esc_html__( 'Custom', 'ciao' ),
						),
						'std'     => 'inherit',
					),
					array(
						'name'    => esc_html__( 'Content Options', 'ciao' ),
						'id'      => $zoo_prefix . "single_product_content_layout",
						'type'    => 'select',
						'options' => array(
							'inherit'        => esc_html__( 'Inherit', 'ciao' ),
							'right_content'  => esc_html__( 'Right Content', 'ciao' ),
							'left_content'   => esc_html__( 'Left Content', 'ciao' ),
							'full_content'   => esc_html__( 'Full width Content', 'ciao' ),
							'sticky_content' => esc_html__( 'Sticky Content', 'ciao' ),
						),
						'std'     => 'inherit',
					),
					array(
						'name'    => esc_html__( 'Gallery Options', 'ciao' ),
						'id'      => $zoo_prefix . "product_gallery_layout",
						'type'    => 'select',
						'options' => array(
							'inherit'        => esc_html__( 'Inherit', 'ciao' ),
							'vertical-left'  => esc_html__( 'Vertical Left Thumb', 'ciao' ),
							'vertical-right' => esc_html__( 'Vertical Right Thumb', 'ciao' ),
							'horizontal'     => esc_html__( 'Horizontal', 'ciao' ),
							'slider'         => esc_html__( 'Slider', 'ciao' ),
							'grid'           => esc_html__( 'Grid', 'ciao' ),
							'sticky'         => esc_html__( 'Sticky', 'ciao' ),
						),
						'std'     => 'inherit',
					),
					array(
						'name'    => esc_html__( 'Gallery Columns', 'ciao' ),
						'id'      => $zoo_prefix . "product_gallery_columns",
						'type'    => 'select',
						'options' => array(
							'6' => esc_html__( '6', 'ciao' ),
							'5' => esc_html__( '5', 'ciao' ),
							'4' => esc_html__( '4', 'ciao' ),
							'3' => esc_html__( '3', 'ciao' ),
							'2' => esc_html__( '2', 'ciao' ),
							'1' => esc_html__( '1', 'ciao' ),
							'inherit' => esc_html__( 'Inherit', 'ciao' ),
						),
						'std'     => 'inherit',
					),
				)
			);
			$zoo_meta_boxes[] = array(
				'id'      => $zoo_prefix . 'single_product_image_360_heading',
				'title'   => esc_html__( 'Product image 360 view', 'ciao' ),
				'pages'   => array( 'product' ),
				'context' => 'advanced',
				'fields'  => array(
					array(
						'id'   => $zoo_prefix . "single_product_image_360",
						'name' => esc_html__( 'Images', 'ciao' ),
						'type' => 'image_advanced',
						'desc' => esc_html__( 'Images for 360 degree view.', 'ciao' )
					),
				)
			);
			$zoo_meta_boxes[] = array(
				'id'      => $zoo_prefix . 'single_product_video_heading',
				'title'   => esc_html__( 'Product Video', 'ciao' ),
				'pages'   => array( 'product' ),
				'context' => 'side',
				'fields'  => array(
					array(
						'id'   => $zoo_prefix . "single_product_video",
						'type' => 'oembed',
						'desc' => esc_html__( 'Enter your embed video url.', 'ciao' )
					),
				)
			);
			$zoo_meta_boxes[] = array(
				'id'      => $zoo_prefix . 'single_product_new_heading',
				'title'   => esc_html__( 'Assign product is New', 'ciao' ),
				'pages'   => array( 'product' ),
				'context' => 'side',
				'fields'  => array(
					array(
						'id'   => $zoo_prefix . "single_product_new",
						'std'  => '0',
						'type' => 'checkbox',
						'desc' => esc_html__( 'Is New Product.', 'ciao' )
					),
				)
			);
			$zoo_meta_boxes[] = array(
				'id'      => 'title_meta_box',
				'title'   => esc_html__( 'Layout Options', 'ciao' ),
				'pages'   => array( 'page', 'post' ),
				'context' => 'advanced',
				'fields'  => array(
					array(
						'name' => esc_html__( 'Title & Breadcrumbs Options', 'ciao' ),
						'desc' => esc_html__( '', 'ciao' ),
						'id'   => $zoo_prefix . "heading_title",
						'type' => 'heading'
					),
					array(
						'name' => esc_html__( 'Disable Title', 'ciao' ),
						'desc' => esc_html__( '', 'ciao' ),
						'id'   => $zoo_prefix . "disable_title",
						'std'  => '0',
						'type' => 'checkbox'
					),
					array(
						'name' => esc_html__( 'Disable Breadcrumbs', 'ciao' ),
						'desc' => esc_html__( '', 'ciao' ),
						'id'   => $zoo_prefix . "disable_breadcrumbs",
						'std'  => '0',
						'type' => 'checkbox'
					),
					array(
						'name' => esc_html__( 'Page Layout', 'ciao' ),
						'desc' => esc_html__( '', 'ciao' ),
						'id'   => $zoo_prefix . "body_heading",
						'type' => 'heading'
					),
					array(
						'name'    => esc_html__( 'Layout Options', 'ciao' ),
						'id'      => $zoo_prefix . "site_layout",
						'type'    => 'select',
						'options' => array(
							'inherit'    => esc_html__( 'Inherit', 'ciao' ),
							'normal'     => esc_html__( 'Normal', 'ciao' ),
							'boxed'      => esc_html__( 'Boxed', 'ciao' ),
							'full-width' => esc_html__( 'Full Width', 'ciao' ),
						),
						'std'     => 'inherit',
					),
					array(
						'name' => esc_html__( 'Page Max Width', 'ciao' ),
						'desc' => esc_html__( 'Accept only number. If not set, it will follow customize config.', 'ciao' ),
						'id'   => $zoo_prefix . "site_max_width",
						'type' => 'number'
					),
				)
			);

			return $zoo_meta_boxes;
		}
	}
endif;