<?php
/**
 * My Wislist page template
 *
 * @package  Zoo_Theme\WooCommerce\Wishlist
 */
get_header();?>
    <main id="site-main-content" class="main-content wishlist-content">
        <div class="container">
            <?php
                if (empty($_COOKIE['zooWishlistItems']) || !$wishlist_items = json_decode($_COOKIE['zooWishlistItems'])) :
                    ?><p><?php esc_html_e('Wishlist is Empty.', 'ciao') ?></p><?php
                else :
                    global $post, $product;

                    $args = [
                        'post_type' => 'product',
                        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                        'ignore_sticky_posts' => true
                    ];

                    foreach ($wishlist_items as $item_id) {
                        $args['post__in'][] = absint($item_id);
                    }

                    $query = new WP_Query(apply_filters('woocommerce_wishlist_products_query', $args));

                    ?>
                    <div class="zoo-wishlist-panel">
                        <div class="zoo-wishlist-panel-inner">
                            <h2 class="wishlist-panel-title zoo-popup-panel-title"><?php echo esc_html__('My Wishlist', 'ciao') ?></h2>
                            <table class="wishlist-items-table">
                                <thead>
                                <tr>
                                    <th class="product-title" colspan="2">
                                        <?php esc_html_e('Product','ciao');?>
                                    </th>
                                    <th class="product-price">
                                        <?php esc_html_e('Price','ciao');?>
                                    </th>
                                    <th class="product-meta">
                                        <?php esc_html_e('Product Meta','ciao');?>
                                    </th>
                                    <th class="product-actions">
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($query->have_posts()) : $query->the_post(); ?>
                                    <tr id="wislist-item-row-<?php echo get_the_ID(); ?>">
                                        <td class="product-thumbnail">
                                            <a href="<?php the_permalink(); ?>"
                                               title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
                                        </td>
                                        <td class="product-title">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                        </td>
                                        <td class="product-price">
                                            <?php woocommerce_template_loop_price(); ?>
                                        </td>
                                        <td class="product-meta">
                                            <?php woocommerce_template_single_meta(); ?>
                                        </td>
                                        <td class="product-actions">
                                            <?php woocommerce_template_loop_add_to_cart(); ?>
                                            <a href="#" class="remove-from-wishlist"
                                               title="<?php echo esc_attr__('Remove', 'ciao'); ?>"
                                               data-id="<?php echo esc_attr(get_the_ID()); ?>">
                                                <i class="zoo-icon-close"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                    wp_reset_postdata();
                endif;
            ?>
        </div>
    </main>
<?php
get_footer();
