<?php
/**
 * View template for Posts widget
 *
 * @package CAFE\Templates
 * @copyright 2018 CleverSoft. All rights reserved.
 */
global $wp_query;

$args = array(
    'post_type' => 'post',
    'posts_per_page' => ($settings['posts_per_page'] > 0) ? $settings['posts_per_page'] : get_option('posts_per_page')
);
if ($settings['cat']) {
    $catid = array();
    foreach ($settings['cat'] as $catslug) {
        $catid[] .= get_category_by_slug($catslug)->term_id;
    }
    $args['category__in'] = $catid;
}
if ($settings['pagination'] != 'none') {
    $args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
	if (is_front_page() && !empty($wp_query->query['paged'])) {
		$args['paged'] = $wp_query->query['paged'];
	}
}

$the_query = new WP_Query($args);
if ($the_query->have_posts()):
    $layout = $settings['layout'];
    $css_class = 'cafe-posts';
    $css_class .= ' ' . $layout . '-layout';
    $css_class_item[] = 'cafe-post-item';
    $css_class_item[] = 'post-loop-item';
    $css_class_item[] = $layout . '-layout-item';
    $css_class_item[] = 'cafe-col';
    $data_config = '';
    if ($layout == 'grid') {
        $css_class .= ' cafe-row cafe-grid-lg-' . $settings['col'] . '-cols cafe-grid-md-' . $settings['col_tablet'] . '-cols cafe-grid-' . $settings['col_mobile'] . '-cols';
    } elseif($layout == 'carousel') {
	    $autoplay_speed = $settings['autoplay_speed'] != NULL ? $settings['autoplay_speed'] : '3000';
	    $nav= $settings['show_nav']!= ''? $settings['show_nav']:'false';
	    $pag= $settings['show_pag']!=''? $settings['show_pag']:'false';
	    $scroll=$settings['scroll']!=''?$settings['scroll']:1;
	    $data_config = '{"slides_to_show":' . $settings['col'] . ',"slides_to_show_tablet":' . $settings['col_tablet'] . ',"slides_to_show_mobile":' . $settings['col_mobile'] . ',"slides_to_scroll":' . $scroll . ',"show_nav":' . $nav . ',"show_pag":' . $pag . ',"autoplay":' . $settings['autoplay'] . ',"speed":' . $autoplay_speed . '}';
	    $css_class .= ' cafe-carousel';
    }
    $css_class .= ' ' . $settings['css_class'];
    ?>
    <div class="<?php echo esc_attr($css_class) ?>"
         <?php if ($data_config != ''){ ?>data-cafe-config='<?php echo esc_attr($data_config); ?>'<?php } ?>>
        <?php
        while ($the_query->have_posts()):
            $the_query->the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php echo post_class($css_class_item) ?>>
                    <?php
                    if (has_post_thumbnail()) {
                        ?>
                        <div class="wrap-media">
                            <?php
                            if (is_sticky()) {
                                ?>
                                <span class="sticky-post-label"><i class="cs-font clever-icon-light"></i> <?php echo esc_html__('Featured', 'ciao') ?></span>
                                <?php
                            }
                            ?>
                            <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title_attribute() ?>">
                                <?php
                                the_post_thumbnail($settings['image_size']);
                                ?>
                            </a>
                        </div>
                    <?php }else{
                        if (is_sticky()) {
                            ?>
                            <span class="sticky-post-label"><i class="cs-font clever-icon-light"></i> <?php echo esc_html__('Featured', 'ciao') ?></span>
                            <?php
                        }
                    } ?>
                    <div class="wrap-post-item-content">
                        <?php
                        the_title(sprintf('<h3 class="entry-title title-post"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>');
                        ?>
                        <ul class="post-info">
		                    <?php
		                    if ($settings['show_author_post']=='true') { ?>
                                    <li class="author-post"><?php esc_html_e('by', 'ciao'); ?>
                                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename'))); ?>"
                                           title="<?php echo esc_attr(get_the_author()) ?>">
						                    <?php echo esc_html(get_the_author()) ?>
                                        </a>
                                    </li>
			                    <?php }
		                    if ($settings['show_date_post']=='true') {
				                    ?>
                                    <li class="post-date"><span><?php esc_html_e('On', 'ciao'); ?></span><?php echo esc_html(get_the_date()); ?></li>
			                    <?php }
		                    if ($settings['show_cat_post']=='true') {
				                    ?>
                                    <li class="list-cat"><span><?php esc_html_e('In', 'ciao'); ?></span><?php echo get_the_term_list(get_the_ID(), 'category', '', ', ', ''); ?></li>
			                    <?php }
		                    ?>
                        </ul>
                        <?php
                        if ($settings['output_type'] != 'none') { ?>
                        <div class="entry-content">
                            <?php
                            if ($settings['output_type'] == 'excerpt'){
                                echo cafe_get_excerpt($settings['excerpt_length']);
                            }else{
                                the_content();
                            }
                            ?>
                        </div>
                        <?php }
                        if($settings['show_read_more']=='true') {
                            ?>
                            <a href="<?php the_permalink(); ?>"
                               class="readmore"><?php echo esc_html__('Read more', 'ciao'); ?></a>
                            <?php
                        }
                        ?>
                    </div>
            </article>
        <?php
        endwhile;
        ?>
    </div>
<?php
    if ($settings['pagination'] != 'none' && $layout != 'carousel') :
        cafe_pagination(3, $the_query, '');
    endif;
endif;
wp_reset_postdata();