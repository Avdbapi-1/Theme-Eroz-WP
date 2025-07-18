<?php
global $wpdb;

$_details = wp_get_theme('eroz');

#Constant

$eroz_dir_path = (substr(get_template_directory(),     -1) === '/') ? get_template_directory()     : get_template_directory()     . '/';
$eroz_dir_uri  = (substr(get_template_directory_uri(), -1) === '/') ? get_template_directory_uri() : get_template_directory_uri() . '/';

define('EROZ_VERSION', $_details['Version']);

define('EROZ_DIR_PATH', $eroz_dir_path);
define('EROZ_DIR_URI',  $eroz_dir_uri);

function activate_eroz()
{
	require_once EROZ_DIR_PATH . 'includes/class-eroz-activator.php';
	EROZ_Activator::activate();
}
add_action('after_switch_theme', 'activate_eroz');
function deactivate_eroz()
{
	require_once EROZ_DIR_PATH . 'includes/class-eroz-deactivator.php';
	EROZ_Deactivator::deactivate();
}
add_action('switch_theme', 'deactivate_eroz');
#Class Master
require_once EROZ_DIR_PATH . 'includes/class-eroz-master.php';
function run_eroz_master()
{
	global $eroz_master;
	$eroz_master = new EROZ_Master;
	$eroz_master->run();
}
run_eroz_master();
function dequeue_gutenberg_theme_css()
{
	wp_dequeue_style('wp-block-library');
}
add_action('wp_enqueue_scripts', 'dequeue_gutenberg_theme_css', 100);
function remove_pages_from_search()
{
	global $wp_post_types;
	$wp_post_types['page']->exclude_from_search = true;
}
add_action('init', 'remove_pages_from_search');
load_theme_textdomain('eroz', get_template_directory() . '/languages');
function pagination_pornstar()
{
	$number = get_option('pornstar_page_number', false);
	if (!$number)
		$number = 10;
	$episodes = get_terms('toro_pornstar', array(
		'hide_empty'    => 0,
		'number'        => 30000,
	));
	$categories = count($episodes);
	global $wp_query, $wp_rewrite;
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	$pagination = array(
		'base'      => @add_query_arg('paged', '%#%'),
		'format'    => '',
		'total'     => ceil($categories / $number),
		'current'   => $current,
		'prev_text' => '<p style="margin: 0;" class="prev-pagin">' . __("Previous", "eroz") . '</p>',
		'next_text' => '<p style="margin: 0;" class="next-pagin">' . __("Next", "eroz") . '</p>',
		'type'      => 'plain'
	);
	if ($wp_rewrite->using_permalinks())
		$pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged');
	if (!empty($wp_query->query_vars['s']))
		$pagination['add_args'] = array('s' => get_query_var('s'));
	echo paginate_links($pagination);
};


function lang_eroz($text, $id_text)
{
	$text_database = get_option($id_text);
	if ($text_database) {
		$text = $text_database;
	} else {
		$text = __($text, 'eroz');
	}
	return $text;
}
