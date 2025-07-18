<?php
class BCT_Public
{
    private $theme_name;
    private $version;
    //private $normalize;
    private $helpers;
    public function __construct($theme_name, $version)
    {
        $this->theme_name = $theme_name;
        $this->version = $version;
    }
    public function enqueue_styles()
    {
        wp_enqueue_style($this->theme_name, EROZ_DIR_URI . 'public/css/eroz-public.css', array(), '1.8.2', 'all');
    }
    public function enqueue_scripts()
    {
        //wp_enqueue_script( 'funciones_public_jquery', EROZ_DIR_URI . 'public/js/jquery.js',  array(), '1.0.24', true );
        wp_enqueue_script('funciones_public', EROZ_DIR_URI . 'public/js/eroz-public.js',  array('jquery'), '1.8.2', true);
        if (is_singular() && comments_open() && (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply', 'wp-includes/js/comment-reply', array(), false, true);
        }
        $enabled_cookies       = get_option('eroz_cookie_enabled');
        $url_page_cookies      = get_option('eroz_cookie_page_url');
        $text_page_cookies     = get_option('eroz_cookie_page_text');
        $text_announce_cookies = get_option('eroz_cookie_text_announce');
        $categories            = get_categories();
        $erozPublic = [
            'url'                          => admin_url('admin-ajax.php'),
            'nonce'                        => wp_create_nonce('eroz_seg'),
            'cookie_text'                  => __('We use cookies on this site to enhance your user experience.', 'eroz'),
            'cookie_btn_accept_text'       => __('ACCEPT', 'eroz'),
            'cookie_enabled'               => $enabled_cookies,
            'cookie_text_page'             => $text_page_cookies,
            'cookie_url_page'              => $url_page_cookies,
            'text_announce_cookies'        => $text_announce_cookies,
            'report_error_text'            => __('Choose a reason', 'eroz'),
            'report_send_text'             => __('Send report', 'eroz'),
            'report_write_reason'          => __('Write reason', 'eroz'),
            'report_send_text_correct'     => __('Your report was sent successfully', 'eroz'),
            'report_duplicate_report_text' => __('Your has send report', 'eroz'),
            'vote_duplicate_vote_text'     => __('Your has send vote', 'eroz'),
            'vote_send_text_correct'       => __('Your vote was sent successfully', 'eroz'),
            'all'                          => __('All', 'eroz'),
            'categories'                   => $categories,
        ];
        wp_localize_script('funciones_public', 'erozPublic', $erozPublic);
    }
    public function get_instance_navwalker()
    {
        return new EROZ_Nav_Walker();
    }
}