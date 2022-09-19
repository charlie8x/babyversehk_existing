<?php
/**
 * Customize for Shop loop product
 */
return [
	[
		'type'           => 'section',
		'name'           => 'zoo_shop',
		'title'          => esc_html__( 'Shop Page', 'ciao' ),
		'panel'          => 'woocommerce',
		'theme_supports' => 'woocommerce'
	],
	[
		'name'           => 'zoo_shop_general_settings',
		'type'           => 'heading',
		'label'          => esc_html__( 'General Settings', 'ciao' ),
		'section'        => 'zoo_shop',
		'theme_supports' => 'woocommerce'
	],
	[
		'type'        => 'number',
		'name'        => 'zoo_products_number_items',
		'label'       => esc_html__( 'Product Per Page', 'ciao' ),
		'section'     => 'zoo_shop',
		'description' => esc_html__( 'Number product display per page.', 'ciao' ),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 100,
			'class' => 'zoo-range-slider'
		),
		'default'     => 9
	],
	[
		'name'           => 'zoo_enable_catalog_mod',
		'type'           => 'checkbox',
		'section'        => 'zoo_shop',
		'label'          => esc_html__( 'Enable Catalog Mod', 'ciao' ),
		'checkbox_label' => esc_html__( 'Will be enabled if checked.', 'ciao' ),
		'theme_supports' => 'woocommerce',
		'default'        => 0
	],
	[
		'name'           => 'zoo_enable_free_shipping_notice',
		'type'           => 'checkbox',
		'section'        => 'zoo_shop',
		'label'          => esc_html__( 'Enable Free Shipping Notice', 'ciao' ),
		'checkbox_label' => esc_html__( 'Free shipping thresholds will show in cart if checked.', 'ciao' ),
		'theme_supports' => 'woocommerce',
		'default'        => 1,
	],
	[
		'name'           => 'zoo_enable_shop_heading',
		'type'           => 'checkbox',
		'section'        => 'zoo_shop',
		'label'          => esc_html__( 'Enable Shop Heading', 'ciao' ),
		'checkbox_label' => esc_html__( 'Display product archive title and description.', 'ciao' ),
		'theme_supports' => 'woocommerce',
		'default'        => 1,
	],
	[
		'name'        => 'zoo_shop_banner',
		'type'        => 'image',
		'section'     => 'zoo_shop',
		'title'       => esc_html__( 'Shop banner', 'ciao' ),
		'description' => esc_html__( 'Banner image display at top Products page. It will override by Category image.', 'ciao' ),
		'required'    => [ 'zoo_enable_shop_heading', '==', '1' ],
	],
	[
		'name'           => 'zoo_shop_layout_settings',
		'type'           => 'heading',
		'label'          => esc_html__( 'Layout Settings', 'ciao' ),
		'section'        => 'zoo_shop',
		'theme_supports' => 'woocommerce'
	],
	[
		'name'    => 'zoo_shop_sidebar',
		'type'    => 'select',
		'section' => 'zoo_shop',
		'title'   => esc_html__( 'Shop Sidebar', 'ciao' ),
		'default' => 'left',
		'choices' => [
			'top'        => esc_html__( 'Top (Horizontal)', 'ciao' ),
			'left'       => esc_html__( 'Left', 'ciao' ),
			'right'      => esc_html__( 'Right', 'ciao' ),
			'off-canvas' => esc_html__( 'Off canvas', 'ciao' ),
		]
	],
	[
		'type'           => 'checkbox',
		'name'           => 'zoo_shop_full_width',
		'label'          => esc_html__( 'Enable Shop Full Width', 'ciao' ),
		'section'        => 'zoo_shop',
		'default'        => '0',
		'checkbox_label' => esc_html__( 'Shop layout will full width if enabled.', 'ciao' ),
	],
	[
		'type'           => 'checkbox',
		'name'           => 'zoo_enable_shop_loop_item_border',
		'label'          => esc_html__( 'Enable Product border', 'ciao' ),
		'section'        => 'zoo_shop',
		'default'        => '0',
		'checkbox_label' => esc_html__( 'Enable border for product item.', 'ciao' ),
	],
	[
		'type'           => 'checkbox',
		'name'           => 'zoo_enable_highlight_featured_product',
		'label'          => esc_html__( 'Enable High light Featured Product', 'ciao' ),
		'section'        => 'zoo_shop',
		'default'        => '0',
		'checkbox_label' => esc_html__( 'Featured product will display bigger more than another product.', 'ciao' ),
	],
	[
		'type'        => 'number',
		'name'        => 'zoo_shop_loop_item_gutter',
		'label'       => esc_html__( 'Product Gutter', 'ciao' ),
		'section'     => 'zoo_shop',
		'description' => esc_html__( 'White space between product item.', 'ciao' ),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 100,
			'class' => 'zoo-range-slider'
		),
		'default'     => 30
	],
	[
		'name'        => 'zoo_shop_cols_desktop',
		'type'        => 'number',
		'label'       => esc_html__( 'Shop loop columns', 'ciao' ),
		'description' => esc_html__( 'Number product per row in shop page.', 'ciao' ),
		'section'     => 'zoo_shop',
		'input_attrs' => array(
			'min'   => 2,
			'max'   => 6,
			'class' => 'zoo-range-slider'
		),
		'default'     => 4
	],
	[
		'name'        => 'zoo_shop_cols_tablet',
		'type'        => 'number',
		'label'       => esc_html__( 'Shop loop columns on Tablet', 'ciao' ),
		'section'     => 'zoo_shop',
		'unit'        => false,
		'input_attrs' => array(
			'min'   => 1,
			'max'   => 4,
			'class' => 'zoo-range-slider'
		),
		'default'     => 2,
	],
	[
		'name'        => 'zoo_shop_cols_mobile',
		'type'        => 'number',
		'label'       => esc_html__( 'Shop loop columns on Mobile', 'ciao' ),
		'section'     => 'zoo_shop',
		'input_attrs' => array(
			'min'   => 1,
			'max'   => 2,
			'class' => 'zoo-range-slider'
		),
		'default'     => 2,
	],
	[
		'name'           => 'zoo_shop_product_item_settings',
		'type'           => 'heading',
		'label'          => esc_html__( 'Product Item Settings', 'ciao' ),
		'section'        => 'zoo_shop',
		'theme_supports' => 'woocommerce'
	],
    [
        'name' => 'zoo_product_hover_effect',
        'type' => 'select',
        'section' => 'zoo_shop',
        'title' => esc_html__('Hover Effect', 'ciao'),
        'description' => esc_html__('Hover Effect of product item when hover.', 'ciao'),
        'default' => 'default',
        'choices' => [
            'default' => esc_html__('Default', 'ciao'),
            'style-2' => esc_html__('Style 2', 'ciao'),
            'style-3' => esc_html__('Style 3', 'ciao'),
            'style-4' => esc_html__('Style 4', 'ciao'),
            'style-5' => esc_html__('Style 5', 'ciao'),
            'style-6' => esc_html__('Style 6', 'ciao'),
        ]
    ],
	[
		'name'           => 'zoo_enable_shop_loop_cart',
		'type'           => 'checkbox',
		'section'        => 'zoo_shop',
		'label'          => esc_html__( 'Enable Shop Loop Cart', 'ciao' ),
		'checkbox_label' => esc_html__( 'Button Add to cart will show if checked.', 'ciao' ),
		'theme_supports' => 'woocommerce',
		'default'        => 0,
		'required'       => [ 'zoo_enable_catalog_mod', '!=', 1 ],
	],
	[
		'name'    => 'zoo_shop_cart_icon',
		'type'    => 'icon',
		'section' => 'zoo_shop',
		'title'   => esc_html__( 'Cart icon', 'ciao' ),
		'default' => [
			'type' => 'zoo-icon',
			'icon' => 'zoo-icon-cart'
		]
	],
	[
		'type'           => 'checkbox',
		'name'           => 'zoo_enable_alternative_images',
		'label'          => esc_html__( 'Enable Alternative Image', 'ciao' ),
		'section'        => 'zoo_shop',
		'default'        => '1',
		'checkbox_label' => esc_html__( 'Alternative Image will show if checked.', 'ciao' ),
	],
	[
		'type'    => 'select',
		'name'    => 'zoo_sale_type',
		'label'   => esc_html__( 'Sale label type display', 'ciao' ),
		'section' => 'zoo_shop',
		'default' => 'text',
		'choices' => [
			'numeric' => esc_html__( 'Numeric', 'ciao' ),
			'text'    => esc_html__( 'Text', 'ciao' ),
		]
	],
	[
		'type'           => 'checkbox',
		'name'           => 'zoo_enable_shop_new_label',
		'label'          => esc_html__( 'Show New Label', 'ciao' ),
		'section'        => 'zoo_shop',
		'default'        => '1',
		'checkbox_label' => esc_html__( 'Stock New will show if checked.', 'ciao' ),
	],
	[
		'type'           => 'checkbox',
		'name'           => 'zoo_enable_shop_stock_label',
		'label'          => esc_html__( 'Show Stock Label', 'ciao' ),
		'section'        => 'zoo_shop',
		'default'        => '1',
		'checkbox_label' => esc_html__( 'Stock label will show if checked.', 'ciao' ),
	],
	[
		'type'           => 'checkbox',
		'name'           => 'zoo_enable_quick_view',
		'label'          => esc_html__( 'Enable Quick View', 'ciao' ),
		'section'        => 'zoo_shop',
		'default'        => '1',
		'checkbox_label' => esc_html__( 'Button quick view will show if checked.', 'ciao' ),
	],
	[
		'type'           => 'checkbox',
		'name'           => 'zoo_enable_shop_loop_rating',
		'label'          => esc_html__( 'Show rating', 'ciao' ),
		'section'        => 'zoo_shop',
		'default'        => '1',
		'checkbox_label' => esc_html__( 'Show rating in product item if checked.', 'ciao' ),
	],
	/*Product image thumb for gallery*/
	[
		'name'           => 'zoo_gallery_thumbnail_heading',
		'type'           => 'heading',
		'label'          => esc_html__( 'Gallery Thumbnail', 'ciao' ),
		'section'        => 'woocommerce_product_images',
		'theme_supports' => 'woocommerce'
	],
	[
		'type'           => 'number',
		'name'           => 'zoo_gallery_thumbnail_width',
		'label'          => esc_html__( 'Gallery Thumbnail Width', 'ciao' ),
		'section'        => 'woocommerce_product_images',
		'default'        => '120',
		'description' => esc_html__( 'Max width of image for gallery thumbnail.', 'ciao' ),
	],
	[
		'type'           => 'number',
		'name'           => 'zoo_gallery_thumbnail_height',
		'label'          => esc_html__( 'Gallery Thumbnail Height', 'ciao' ),
		'section'        => 'woocommerce_product_images',
		'default'        => '120',
	],
	[
		'type'           => 'checkbox',
		'name'           => 'zoo_gallery_thumbnail_crop',
		'label'          => esc_html__( 'Crop', 'ciao' ),
		'section'        => 'woocommerce_product_images',
		'default'        => '0',
		'checkbox_label' => esc_html__( 'Crop Gallery Thumbnail.', 'ciao' ),
	],
];
