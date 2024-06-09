<?php
/**
* Template for Side Panel CPT single page
*
* @package bighearts-core\includes\post-types
* @author WebGeniusLab <webgeniuslab@gmail.com>
*/

use BigHearts_Theme_Helper as BigHearts;

get_header();
the_post();

$sb = BigHearts::get_sidebar_data();
$container_class = $sb['container_class'] ?? '';
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '12';

?>
<div class="wgl-container<?php echo apply_filters('bighearts/container/class', $container_class); ?>">
<div class="row <?php echo apply_filters('bighearts/row/class', $row_class); ?>">
    <div id='main-content' class="wgl_col-<?php echo apply_filters('bighearts/column/class', $column); ?>">
        <?php

        the_content(esc_html__('Read more!', 'bighearts-core'));

        BigHearts::link_pages();

        if (comments_open() || get_comments_number()) {
            comments_template();
        }

    echo '</div>';

    $sb && BigHearts::render_sidebar($sb);

echo '</div>';
echo '</div>';

get_footer();
