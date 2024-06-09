<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/templates/wgl-countdown.php`.
 */
namespace WglAddons\Templates;

defined('ABSPATH') || exit; // Abort, if called directly.

/**
 * WGL Elementor Countdown Template
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class WGL_CountDown
{
    private static $instance;

    public function render($self, $atts)
    {
        extract($atts);

        wp_enqueue_script('jquery-countdown', get_template_directory_uri() . '/js/jquery.countdown.min.js');

        //* Module unique id
        $cd_attr = ' id=' . uniqid("countdown_");

        $cd_class = $show_separating ? ' has-dots' : '';

        $f = ! $hide_day ? 'd' : '';
        $f .= ! $hide_hours ? 'H' : '';
        $f .= ! $hide_minutes ? 'M' : '';
        $f .= ! $hide_seconds ? 'S' : '';

        //* Countdown data attribute http://keith-wood.name/countdown.html
        $data['format'] = !empty($f) ? esc_attr($f) : '';

        $data['year'] = esc_attr($countdown_year);
        $data['month'] = esc_attr($countdown_month);
        $data['day'] = esc_attr($countdown_day);
        $data['hours'] = esc_attr($countdown_hours);
        $data['minutes'] = esc_attr($countdown_min);

        $data['labels'][]  = esc_html__('Years', 'bighearts-core');
        $data['labels'][]  = esc_html__('Months', 'bighearts-core');
        $data['labels'][]  = esc_html__('Weeks', 'bighearts-core');
        $data['labels'][]  = esc_html__('Days', 'bighearts-core');
        $data['labels'][]  = esc_html__('Hours', 'bighearts-core');
        $data['labels'][]  = esc_html__('Minutes', 'bighearts-core');
        $data['labels'][]  = esc_html__('Seconds', 'bighearts-core');
        $data['labels1'][] = esc_html__('Year', 'bighearts-core');
        $data['labels1'][] = esc_html__('Month', 'bighearts-core');
        $data['labels1'][] = esc_html__('Week', 'bighearts-core');
        $data['labels1'][] = esc_html__('Day', 'bighearts-core');
        $data['labels1'][] = esc_html__('Hour', 'bighearts-core');
        $data['labels1'][] = esc_html__('Minute', 'bighearts-core');
        $data['labels1'][] = esc_html__('Second', 'bighearts-core');

        $attrs = json_encode($data, true);

        echo '<div',
            $cd_attr,
            ' class="wgl-countdown', esc_attr($cd_class), '"',
            ' data-atts="', esc_attr($attrs),
            '">',
        '</div>';
    }

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
