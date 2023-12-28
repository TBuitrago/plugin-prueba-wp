<?php
/*
* Plugin Name: Prueba-TBA
* Plugin URL: tomasbuitrago.com
* Description: Este será el plugin para el punto 6
* Version: 1.0
* Author: Tomas Buitrago
*/

function custom_posts_plugin_enqueue_scripts() {
    wp_enqueue_script('jquery');

    if (!wp_script_is('slick-script', 'enqueued')) {
        wp_enqueue_script('slick-script', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), null, true);
    }

    wp_enqueue_script('custom-script', plugin_dir_url(__FILE__) . 'js/custom-script.js', array('jquery', 'slick-script'), null, true);

    wp_enqueue_style('slick-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css');
    wp_enqueue_style('slick-theme-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css');
    wp_enqueue_style('custom-posts-styles', plugin_dir_url(__FILE__) . 'css/custom-posts-styles.css');
}

add_action('wp_enqueue_scripts', 'custom_posts_plugin_enqueue_scripts');

function custom_posts_plugin_shortcode() {
    ob_start();
    ?>

    <div class="custom-posts-plugin-container">
        <?php
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => -1,
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                ?>
                <div class="custom-posts-plugin-square">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('full', array('class' => 'custom-posts-plugin-mask'));
                    }
                    ?>
                    <h2 class="custom-posts-plugin-h2"><?php the_title(); ?></h2>
                    <h3 class="custom-posts-plugin-h3"><?php the_excerpt(); ?></h3>
                    <a href="<?php the_permalink(); ?>" class="custom-posts-plugin-button">Leer más</a>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>

    <?php
    return ob_get_clean();
}

add_shortcode('custom_posts_plugin', 'custom_posts_plugin_shortcode');
?>