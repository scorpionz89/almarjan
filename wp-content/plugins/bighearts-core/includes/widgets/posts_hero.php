<?php
/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'wgl_posts_hero_load_widgets' );

function wgl_posts_hero_load_widgets()
{
    register_widget('WGL_Posts_Hero');
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 */
class WGL_Posts_Hero extends WP_Widget {

    /**
     * Widget setup.
     */
    function __construct() {
        /* Widget settings. */
        $widget_ops = array('description' => esc_html__( 'Display posts with overlay image' , 'bighearts-core' ) );

        /* Create the widget. */
        parent::__construct( 'postshero', esc_html__( 'WGL Posts Hero', 'bighearts-core' ), $widget_ops );
    }

    function widget( $args, $instance ) {
        extract( $args );

        global $wpdb;
        $time_id = rand();

        /* Variables from the widget settings. */
		$default_title = esc_html__('Recent Posts' , 'bighearts-core');
		$title         = ( ! empty( $instance['title'] ) ) ? $instance['title'] : $default_title;
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $num_posts = $instance['num_posts'];
        $categories = $instance['categories'];
        $show_related = isset($instance['show_related']) && !empty($instance['show_related']) ? 'true' : 'false';
        $show_date = isset($instance['show_date']) && !empty($instance['show_date']) ? 'true' : 'false';
        $show_cats = isset($instance['show_cats']) && !empty($instance['show_cats']) ? 'true' : 'false';

        /* Before widget (defined by themes). */
        echo BigHearts_Theme_Helper::render_html($before_widget);

        /* Display the widget title if one was input (before and after defined by themes). */
        if ( $title ){
            echo BigHearts_Theme_Helper::render_html($before_title);
            echo BigHearts_Theme_Helper::render_html($title);
            echo BigHearts_Theme_Helper::render_html($after_title);
        }
        ?>
        <?php
            global $post;

            if ( $show_related == 'true' ) { //show related category
                $related_category = get_the_category($post->ID);
                if(isset($related_category[0]->cat_name)){
                    $related_category_id = get_cat_ID( $related_category[0]->cat_name );
                } else {
                    $related_category_id = '';
                }

                $recent_posts = new WP_Query(array(
                    'showposts'             => $num_posts,
                    'cat'                   => $related_category_id,
                    'post__not_in'          => array( $post->ID ),
                    'ignore_sticky_posts'   => 1
                ));
            }
            else {
                $recent_posts = new WP_Query(array(
                    'showposts'             => $num_posts,
                    'cat'                   => $categories,
                    'ignore_sticky_posts'   => 1
                ));
            }
        ?>

    <?php if ($recent_posts->have_posts()) : ?>
        <ul class="recent-posts-widget recent-widget-<?php echo esc_attr($time_id); ?>">
            <?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>
                <?php
                    ob_start();
                        echo the_category(' ');
                    $render_cats = ob_get_clean();

                    $img_render = false;

                    if(has_post_thumbnail()):
                        $img_render = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full');
                    endif; //has_post_thumbnail
                ?>

                <li class="clearfix<?php echo ((!empty($img_render)) ? ' with_image' : '') ?>">
                    <div class="recent-posts-content">
                        <?php
                            if(!empty($img_render)){
                                echo '<div class="recent-posts-image_wrapper">';
                                    $single = BigHearts_Single_Post::getInstance();
                                    $media_link = true;
                                    $image_size = ['width' => 740, 'height' => 560];
                                    $single->render_featured_image_as_background($media_link, $image_size);
                                echo '</div>';
                            }
                        ?>
                        <div class="recent-posts-content_wrapper">
                            <div class="post_title">
                                <a href='<?php the_permalink(); ?>' title='<?php esc_attr_e('Permalink to ', 'bighearts-core'); the_title_attribute(); ?>'><?php echo esc_html(the_title($before = '', $after = '', $echo = false)); ?></a>
                            </div><!-- post-title -->
                            <?php if ($show_date == 'true') : ?>
                                <div class="meta-data">
                                    <span class="meta-date"><?php
                                        echo get_the_time(get_option('date_format'));
                                    ?></span>
                                </div> <!-- /entry-widget-date -->
                            <?php endif; ?>
                            <?php if ($show_cats == 'true') : ?>
                                <div class="post_cat">
                                    <?php
                                        echo BigHearts_Theme_Helper::render_html($render_cats);
                                    ?>
                                </div> <!-- /entry-widget-date -->
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else :

        esc_html_e('No posts were found for display','bighearts-core');

    endif; ?>

        <?php
        /* After widget (defined by themes). */
        echo BigHearts_Theme_Helper::render_html($after_widget);

        // Restor original Query & Post Data
        wp_reset_query();
        wp_reset_postdata();
        }

    /**
     * Update the widget settings.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        /* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['title'] = isset($new_instance['title']) ? strip_tags( $new_instance['title'] ) : '';
        $instance['num_posts'] = isset($new_instance['num_posts']) ? $new_instance['num_posts'] : '';
        $instance['categories'] = isset($new_instance['categories']) ? $new_instance['categories'] : '';
        $instance['show_related'] = isset($new_instance['show_related']) ? $new_instance['show_related'] : '';
        $instance['show_date'] = isset($new_instance['show_date']) ? $new_instance['show_date'] : '';
        $instance['show_cats'] = isset($new_instance['show_cats']) ? $new_instance['show_cats'] : '';

        return $instance;
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form($instance)
    {
        /* Set up some default widget settings. */
        $defaults = array(
            'title'         => esc_html__( 'Recent Posts' , 'bighearts-core' ),
            'num_posts'     => 4,
            'categories'    => 'all',
            'show_related'  => 'off',
            'show_date'     => 'on',
            'show_cats'     => 'on',
        );

        $instance = wp_parse_args((array) $instance, $defaults); ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e( 'Title:' , 'bighearts-core' ) ?></label>
            <input class="widefat" style="width: 216px;" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('num_posts')); ?>"><?php esc_html_e( 'Number of posts:' , 'bighearts-core' ); ?></label>
            <input type="number" min="1" max="100" class="widefat" id="<?php echo esc_attr($this->get_field_id('num_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('num_posts')); ?>" value="<?php echo esc_attr($instance['num_posts']); ?>" />
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_related'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_related')); ?>" name="<?php echo esc_attr($this->get_field_name('show_related')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_related')); ?>"><?php esc_html_e( 'Show related category posts' , 'bighearts-core' ); ?></label>
        </p>

        <p style="margin-top: 20px;">
            <label style="font-weight: bold;"><?php esc_html_e( 'Post meta info' , 'bighearts-core' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_date'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_date')); ?>" name="<?php echo esc_attr($this->get_field_name('show_date')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>"><?php esc_html_e( 'Show date' , 'bighearts-core' ); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_cats'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_cats')); ?>" name="<?php echo esc_attr($this->get_field_name('show_cats')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_cats')); ?>"><?php esc_html_e( 'Show categories' , 'bighearts-core' ); ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('categories')); ?>"><?php esc_html_e( 'Filter by Category:' , 'bighearts-core' ); ?></label>
            <select id="<?php echo esc_attr($this->get_field_id('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>" class="widefat categories" style="width:100%;">
                <option value='all' <?php if ( 'all' == $instance['categories'] ) echo 'selected="selected"'; ?>><?php esc_html_e( 'All categories' , 'bighearts-core' );?></option>
                <?php $categories = get_categories( 'hide_empty=0&depth=1&type=post' ); ?>
                <?php foreach( $categories as $category ) { ?>
                <option value='<?php echo esc_attr($category->term_id); ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo esc_attr($category->cat_name); ?></option>
                <?php } ?>
            </select>
        </p>
    <?php
    }
}

?>