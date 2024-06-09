<?php
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Typography
};
use WglAddons\BigHearts_Global_Variables as BigHearts_Globals;

/**
 * Date widget for Header CPT
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class Wgl_Header_Date extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-date';
    }

    public function get_title()
    {
        return esc_html__('WGL Current Date', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-date';
    }

    public function get_categories()
    {
        return ['wgl-header-modules'];
    }

    protected function register_controls()
    {
        /**
         * CONTENT -> GENERAL
         */

        $this->start_controls_section(
            'section_date_settings',
            [
                'label' => esc_html__( 'General', 'bighearts-core' ),
            ]
        );

        $this->add_control(
            'date_format_select',
            [
                'label' => esc_html__('Date Format', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => esc_html__('Theme Default', 'bighearts-core'),
                    'wordpress_format' => esc_html__('Wordpress Format', 'bighearts-core'),
                    'custom' => esc_html__('Custom', 'bighearts-core'),
                ],
                'default' => 'default',
            ]
        );

        $this->add_control(
            'date_format_custom',
            [
                'label' => esc_html__('Custom Date Format', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'condition' => ['date_format_select' => 'custom'],
                'description' => esc_html__('Set your date format, about this, please refer to the ', 'bighearts-core')
                    . sprintf(
                        ' <a href="%1$s" target="_blank">%2$s</a>',
                        'https://wordpress.org/support/article/formatting-date-and-time/',
                        esc_html__('Wordpress.org', 'bighearts-core')
                    ),
                'label_block' => true,
                'default' => 'l, F j, Y',
            ]
        );

        $this->add_control(
            'time_zone',
            [
                'label' => esc_html__('Time Zone', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'UTC' => esc_html__('Default', 'bighearts-core'),
                    'Pacific/Midway' => esc_html__('(GMT-11:00) Midway Island', 'bighearts-core'),
                    'US/Samoa' => esc_html__('(GMT-11:00) Samoa', 'bighearts-core'),
                    'US/Hawaii' => esc_html__('(GMT-10:00) Hawaii', 'bighearts-core'),
                    'US/Alaska' => esc_html__('(GMT-09:00) Alaska', 'bighearts-core'),
                    'US/Pacific' => esc_html__('(GMT-08:00) Pacific Time (US &amp; Canada)', 'bighearts-core'),
                    'America/Tijuana' => esc_html__('(GMT-08:00) Tijuana', 'bighearts-core'),
                    'US/Arizona' => esc_html__('(GMT-07:00) Arizona', 'bighearts-core'),
                    'US/Mountain' => esc_html__('(GMT-07:00) Mountain Time (US &amp; Canada)', 'bighearts-core'),
                    'America/Chihuahua' => esc_html__('(GMT-07:00) Chihuahua', 'bighearts-core'),
                    'America/Mazatlan' => esc_html__('(GMT-07:00) Mazatlan', 'bighearts-core'),
                    'America/Mexico_City' => esc_html__('(GMT-06:00) Mexico City', 'bighearts-core'),
                    'America/Monterrey' => esc_html__('(GMT-06:00) Monterrey', 'bighearts-core'),
                    'Canada/Saskatchewan' => esc_html__('(GMT-06:00) Saskatchewan', 'bighearts-core'),
                    'US/Central' => esc_html__('(GMT-06:00) Central Time (US &amp; Canada)', 'bighearts-core'),
                    'US/Eastern' => esc_html__('(GMT-05:00) Eastern Time (US &amp; Canada)', 'bighearts-core'),
                    'US/East-Indiana' => esc_html__('(GMT-05:00) Indiana (East)', 'bighearts-core'),
                    'America/Bogota' => esc_html__('(GMT-05:00) Bogota', 'bighearts-core'),
                    'America/Lima' => esc_html__('(GMT-05:00) Lima', 'bighearts-core'),
                    'America/Caracas' => esc_html__('(GMT-04:30) Caracas', 'bighearts-core'),
                    'Canada/Atlantic' => esc_html__('(GMT-04:00) Atlantic Time (Canada)', 'bighearts-core'),
                    'America/La_Paz' => esc_html__('(GMT-04:00) La Paz', 'bighearts-core'),
                    'America/Santiago' => esc_html__('(GMT-04:00) Santiago', 'bighearts-core'),
                    'Canada/Newfoundland' => esc_html__('(GMT-03:30) Newfoundland', 'bighearts-core'),
                    'America/Buenos_Aires' => esc_html__('(GMT-03:00) Buenos Aires', 'bighearts-core'),
                    'Greenland' => esc_html__('(GMT-03:00) Greenland', 'bighearts-core'),
                    'Atlantic/Stanley' => esc_html__('(GMT-02:00) Stanley', 'bighearts-core'),
                    'Atlantic/Azores' => esc_html__('(GMT-01:00) Azores', 'bighearts-core'),
                    'Atlantic/Cape_Verde' => esc_html__('(GMT-01:00) Cape Verde Is.', 'bighearts-core'),
                    'Africa/Casablanca' => esc_html__('(GMT) Casablanca', 'bighearts-core'),
                    'Europe/Dublin' => esc_html__('(GMT) Dublin', 'bighearts-core'),
                    'Europe/Lisbon' => esc_html__('(GMT) Lisbon', 'bighearts-core'),
                    'Europe/London' => esc_html__('(GMT) London', 'bighearts-core'),
                    'Africa/Monrovia' => esc_html__('(GMT) Monrovia', 'bighearts-core'),
                    'Europe/Amsterdam' => esc_html__('(GMT+01:00) Amsterdam', 'bighearts-core'),
                    'Europe/Belgrade' => esc_html__('(GMT+01:00) Belgrade', 'bighearts-core'),
                    'Europe/Berlin' => esc_html__('(GMT+01:00) Berlin', 'bighearts-core'),
                    'Europe/Bratislava' => esc_html__('(GMT+01:00) Bratislava', 'bighearts-core'),
                    'Europe/Brussels' => esc_html__('(GMT+01:00) Brussels', 'bighearts-core'),
                    'Europe/Budapest' => esc_html__('(GMT+01:00) Budapest', 'bighearts-core'),
                    'Europe/Copenhagen' => esc_html__('(GMT+01:00) Copenhagen', 'bighearts-core'),
                    'Europe/Ljubljana' => esc_html__('(GMT+01:00) Ljubljana', 'bighearts-core'),
                    'Europe/Madrid' => esc_html__('(GMT+01:00) Madrid', 'bighearts-core'),
                    'Europe/Paris' => esc_html__('(GMT+01:00) Paris', 'bighearts-core'),
                    'Europe/Prague' => esc_html__('(GMT+01:00) Prague', 'bighearts-core'),
                    'Europe/Rome' => esc_html__('(GMT+01:00) Rome', 'bighearts-core'),
                    'Europe/Sarajevo' => esc_html__('(GMT+01:00) Sarajevo', 'bighearts-core'),
                    'Europe/Skopje' => esc_html__('(GMT+01:00) Skopje', 'bighearts-core'),
                    'Europe/Stockholm' => esc_html__('(GMT+01:00) Stockholm', 'bighearts-core'),
                    'Europe/Vienna' => esc_html__('(GMT+01:00) Vienna', 'bighearts-core'),
                    'Europe/Warsaw' => esc_html__('(GMT+01:00) Warsaw', 'bighearts-core'),
                    'Europe/Zagreb' => esc_html__('(GMT+01:00) Zagreb', 'bighearts-core'),
                    'Europe/Athens' => esc_html__('(GMT+02:00) Athens', 'bighearts-core'),
                    'Europe/Bucharest' => esc_html__('(GMT+02:00) Bucharest', 'bighearts-core'),
                    'Africa/Cairo' => esc_html__('(GMT+02:00) Cairo', 'bighearts-core'),
                    'Africa/Harare' => esc_html__('(GMT+02:00) Harare', 'bighearts-core'),
                    'Europe/Helsinki' => esc_html__('(GMT+02:00) Helsinki', 'bighearts-core'),
                    'Europe/Istanbul' => esc_html__('(GMT+02:00) Istanbul', 'bighearts-core'),
                    'Asia/Jerusalem' => esc_html__('(GMT+02:00) Jerusalem', 'bighearts-core'),
                    'Europe/Kiev' => esc_html__('(GMT+02:00) Kyiv', 'bighearts-core'),
                    'Europe/Minsk' => esc_html__('(GMT+02:00) Minsk', 'bighearts-core'),
                    'Europe/Riga' => esc_html__('(GMT+02:00) Riga', 'bighearts-core'),
                    'Europe/Sofia' => esc_html__('(GMT+02:00) Sofia', 'bighearts-core'),
                    'Europe/Tallinn' => esc_html__('(GMT+02:00) Tallinn', 'bighearts-core'),
                    'Europe/Vilnius' => esc_html__('(GMT+02:00) Vilnius', 'bighearts-core'),
                    'Asia/Baghdad' => esc_html__('(GMT+03:00) Baghdad', 'bighearts-core'),
                    'Asia/Kuwait' => esc_html__('(GMT+03:00) Kuwait', 'bighearts-core'),
                    'Africa/Nairobi' => esc_html__('(GMT+03:00) Nairobi', 'bighearts-core'),
                    'Asia/Riyadh' => esc_html__('(GMT+03:00) Riyadh', 'bighearts-core'),
                    'Europe/Moscow' => esc_html__('(GMT+03:00) Moscow', 'bighearts-core'),
                    'Asia/Tehran' => esc_html__('(GMT+03:30) Tehran', 'bighearts-core'),
                    'Asia/Baku' => esc_html__('(GMT+04:00) Baku', 'bighearts-core'),
                    'Europe/Volgograd' => esc_html__('(GMT+04:00) Volgograd', 'bighearts-core'),
                    'Asia/Muscat' => esc_html__('(GMT+04:00) Muscat', 'bighearts-core'),
                    'Asia/Tbilisi' => esc_html__('(GMT+04:00) Tbilisi', 'bighearts-core'),
                    'Asia/Yerevan' => esc_html__('(GMT+04:00) Yerevan', 'bighearts-core'),
                    'Asia/Kabul' => esc_html__('(GMT+04:30) Kabul', 'bighearts-core'),
                    'Asia/Karachi' => esc_html__('(GMT+05:00) Karachi', 'bighearts-core'),
                    'Asia/Tashkent' => esc_html__('(GMT+05:00) Tashkent', 'bighearts-core'),
                    'Asia/Kolkata' => esc_html__('(GMT+05:30) Kolkata', 'bighearts-core'),
                    'Asia/Kathmandu' => esc_html__('(GMT+05:45) Kathmandu', 'bighearts-core'),
                    'Asia/Yekaterinburg' => esc_html__('(GMT+06:00) Ekaterinburg', 'bighearts-core'),
                    'Asia/Almaty' => esc_html__('(GMT+06:00) Almaty', 'bighearts-core'),
                    'Asia/Dhaka' => esc_html__('(GMT+06:00) Dhaka', 'bighearts-core'),
                    'Asia/Novosibirsk' => esc_html__('(GMT+07:00) Novosibirsk', 'bighearts-core'),
                    'Asia/Bangkok' => esc_html__('(GMT+07:00) Bangkok', 'bighearts-core'),
                    'Asia/Jakarta' => esc_html__('(GMT+07:00) Jakarta', 'bighearts-core'),
                    'Asia/Krasnoyarsk' => esc_html__('(GMT+08:00) Krasnoyarsk', 'bighearts-core'),
                    'Asia/Chongqing' => esc_html__('(GMT+08:00) Chongqing', 'bighearts-core'),
                    'Asia/Hong_Kong' => esc_html__('(GMT+08:00) Hong Kong', 'bighearts-core'),
                    'Asia/Kuala_Lumpur' => esc_html__('(GMT+08:00) Kuala Lumpur', 'bighearts-core'),
                    'Australia/Perth' => esc_html__('(GMT+08:00) Perth', 'bighearts-core'),
                    'Asia/Singapore' => esc_html__('(GMT+08:00) Singapore', 'bighearts-core'),
                    'Asia/Taipei' => esc_html__('(GMT+08:00) Taipei', 'bighearts-core'),
                    'Asia/Ulaanbaatar' => esc_html__('(GMT+08:00) Ulaan Bataar', 'bighearts-core'),
                    'Asia/Urumqi' => esc_html__('(GMT+08:00) Urumqi', 'bighearts-core'),
                    'Asia/Irkutsk' => esc_html__('(GMT+09:00) Irkutsk', 'bighearts-core'),
                    'Asia/Seoul' => esc_html__('(GMT+09:00) Seoul', 'bighearts-core'),
                    'Asia/Tokyo' => esc_html__('(GMT+09:00) Tokyo', 'bighearts-core'),
                    'Australia/Adelaide' => esc_html__('(GMT+09:30) Adelaide', 'bighearts-core'),
                    'Australia/Darwin' => esc_html__('(GMT+09:30) Darwin', 'bighearts-core'),
                    'Asia/Yakutsk' => esc_html__('(GMT+10:00) Yakutsk', 'bighearts-core'),
                    'Australia/Brisbane' => esc_html__('(GMT+10:00) Brisbane', 'bighearts-core'),
                    'Australia/Canberra' => esc_html__('(GMT+10:00) Canberra', 'bighearts-core'),
                    'Pacific/Guam' => esc_html__('(GMT+10:00) Guam', 'bighearts-core'),
                    'Australia/Hobart' => esc_html__('(GMT+10:00) Hobart', 'bighearts-core'),
                    'Australia/Melbourne' => esc_html__('(GMT+10:00) Melbourne', 'bighearts-core'),
                    'Pacific/Port_Moresby' => esc_html__('(GMT+10:00) Port Moresby', 'bighearts-core'),
                    'Australia/Sydney' => esc_html__('(GMT+10:00) Sydney', 'bighearts-core'),
                    'Asia/Vladivostok' => esc_html__('(GMT+11:00) Vladivostok', 'bighearts-core'),
                    'Asia/Magadan' => esc_html__('(GMT+12:00) Magadan', 'bighearts-core'),
                    'Pacific/Auckland' => esc_html__('(GMT+12:00) Auckland', 'bighearts-core'),
                    'Pacific/Fiji' => esc_html__('(GMT+12:00) Fiji', 'bighearts-core'),
                ],
                'default' => 'UTC',
            ]
        );

        $this->add_control(
            'date_align',
            [
                'label' => esc_html__( 'Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'toggle' => true,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'bighearts-core' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'bighearts-core' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'bighearts-core' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .wgl-header-date' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> ITEM
         */

        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Item', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'text_transform' => ['default' => 'uppercase'],
                ],
                'selector' => '{{WRAPPER}} .wgl-header-date',
            ]
        );

        $this->add_control(
            'item_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-header-date' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> DAY
         */

        $this->start_controls_section(
            'section_style_day',
            [
                'label' => esc_html__('Day', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['date_format_select' => 'default'],
            ]
        );

        $this->add_responsive_control(
            'day_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-header-date .day' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'day_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-header-date .day' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'day_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-header-date .day' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> MONTH
         */

        $this->start_controls_section(
            'section_style_month',
            [
                'label' => esc_html__('Month', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['date_format_select' => 'default'],
            ]
        );

        $this->add_control(
            'month_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-header-date .month' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> YEAR
         */

        $this->start_controls_section(
            'section_style_year',
            [
                'label' => esc_html__('Year', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['date_format_select' => 'default'],
            ]
        );

        $this->add_control(
            'year_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-header-date .year' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $UTC = new \DateTimeZone("UTC");
        $newTZ = new \DateTimeZone($time_zone);

        $date = new \DateTime('NOW', $UTC);
        $date->setTimezone( $newTZ );

        switch ($date_format_select) {
            case 'default':
                $class_date = ' wgl-format-default';
                $date_html = '<span class="day">' . date_i18n('d') . '</span>'
                    . '<span class="month-year">'
                        . '<span class="month">' . date_i18n('M') . '</span>'
                        . '<span class="year">' . date_i18n('Y') . '</span>'
                    . '</span>';
                break;

            case 'wordpress_format':
                $date_html = date_i18n(get_option('date_format'));
                break;

            default:
                $date_html = date_i18n($date_format_custom);
                break;
        }

        echo '<div class="wgl-header-date', esc_attr($class_date ?? ''), '">',
            $date_html,
        '</div>';
    }

    /**
     * @since 1.1.5
     */
    public function wpml_support_module()
    {
        add_filter( 'wpml_elementor_widgets_to_translate',  [ $this, 'wpml_widgets_to_translate_filter' ] );
    }

    /**
     * @since 1.1.5
     */
    public function wpml_widgets_to_translate_filter( $widgets )
    {
        return \WglAddons\Includes\WGL_WPML_Settings::get_translate(
            $this, $widgets
        );
    }
}
