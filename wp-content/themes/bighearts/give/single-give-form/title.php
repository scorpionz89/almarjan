<?php
/**
 * Single Give Form Title
 *
 * Displays the main title for the single donation form.
 *
 * This template is overriden by WebGeniusLab.
 *
 * @package     bighearts\give
 * @copyright   Copyright (c) 2016, GiveWP
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.0
 */

defined('ABSPATH') || exit; // Abort, if accessed directly.

$page_title = BigHearts_Theme_Helper::get_mb_option('page_title_switch');
if ($page_title === 'default') {
	$page_title = BigHearts_Theme_Helper::get_option('page_title_switch');
}

$tag = $page_title === 'off' || !$page_title ? 'h1' : 'h2'; // avoid miltiple `h1` on a page

printf(
	'<%1$s class="give-form-title entry-title">' . get_the_title() . '</%1$s>',
	$tag
);
