<?php
class BCT_Admin
{
    private $theme_name;
    private $version;
    private $build_menupage;
    //private $normalize;
    private $helpers;
    public function __construct($theme_name, $version)
    {
        $this->theme_name = $theme_name;
        $this->version = $version;
        $this->build_menupage = new BCT_Build_Menupage();
        //$this->normalize = new BCT_Normalize;
    }
    /**
     * Registra los archivos de hojas de estilos del área de administración
     */
    public function enqueue_styles($hook)
    {
        /**
         * bct-admin.css
         * Archivo de hojas de estilos principales
         * de la administración
         */
        wp_enqueue_style('bct_wordpress_global_css', EROZ_DIR_URI . 'admin/css/eroz-wordpress.css', array(), '1.0.0', 'all');
        /**
         * Condicional para controlar la carga de los archivos
         * solamente en la página del plugin
         */
        if ($hook == 'toplevel_page_manage_theme_eroz') {
        } else {
            return;
        }
        /**
         * bct-admin.css
         * Archivo de hojas de estilos principales
         * de la administración
         */
        wp_enqueue_style($this->theme_name, EROZ_DIR_URI . 'admin/css/eroz-admin.css', array(), '1.0.0', 'all');
    }
    /**
     * Registra los archivos Javascript del área de administración
     */
    public function enqueue_scripts($hook)
    {
        wp_enqueue_media();
        wp_enqueue_script('admin_global_js', EROZ_DIR_URI . 'admin/js/eroz-global.js', ['jquery'], '1.0.0', true);
        /**
         * Condicional para controlar la carga de los archivos
         * solamente en la página del plugin
         */
        if ($hook == 'toplevel_page_manage_theme_eroz') {
        } else {
            return;
        }
        /**
         * bct-admin.js
         * Archivo Javascript principal
         * de la administración
         */
        wp_enqueue_script($this->theme_name, EROZ_DIR_URI . 'admin/js/bct-admin.js', ['jquery'], '1.0.1', true);
        /*Localize JS*/
        wp_localize_script(
            $this->theme_name,
            'erozAdmin',
            [
                'url'       => admin_url('admin-ajax.php'),
                'nonce'     => wp_create_nonce('eroz_seg')
            ]
        );
    }
    /**
     * Registra los menús del plugin en el
     * área de administración
     */
    public function add_menu()
    {
        $this->build_menupage->add_menu_eroz_page(
            __('Post Reported', 'eroz'),
            __('Post Reported', 'eroz'),
            'manage_options',
            'manage_theme_eroz',
            [$this, 'eroz_report_post_page_admin'],
            'dashicons-admin-generic',
            32
        );

        $this->build_menupage->run();
    }
    /**
     * METABOX
     *  L Add metabox
     *  L Save metabox
     */
    public function add_metabox()
    {
        add_meta_box('eroz_metabox', 'Options', [$this, 'eroz_function_metabox'], 'post', 'normal', 'high', null);
    }
    public function save_metabox($post_id, $post, $update)
    {
        $input_video = get_option('eroz_meta_video', true);
        $input_duration = get_option('eroz_meta_duration', true);
        $input_trailer = get_option('eroz_meta_video_trailer', true);
        $input_src = get_option('eroz_meta_src', true);
        if (!isset($_POST['meta-box-nonce']) || !wp_verify_nonce($_POST['meta-box-nonce'], 'act_nonce_name'))
            return $post_id;
        if (!current_user_can('edit_post', $post_id))
            return $post_id;
        if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
            return $post_id;
        $input_metabox = '';
        if (isset($_POST[$input_video])) {
            $input_metabox = $_POST[$input_video];
        }
        update_post_meta($post_id, $input_video, $input_metabox);
        
        $input_original_name_1 = '';
        if (isset($_POST['video_optional_1'])) {
            $input_original_name_1 = $_POST['video_optional_1'];
        }
        update_post_meta($post_id, 'original_name_1', $input_original_name_1);
        
        // Fix: Read duration field correctly instead of using video field
        $input_duration_value = '';
        if (isset($_POST[$input_duration])) {
            $input_duration_value = $_POST[$input_duration];
        }
        update_post_meta($post_id, $input_duration, $input_duration_value);
        $input_desc = '';
        if (isset($_POST['eroz_post_desc'])) {
            $input_desc = $_POST['eroz_post_desc'];
        }
        update_post_meta($post_id, 'eroz_post_desc', $input_desc);
        
        $input_ads_player = '';
        if (isset($_POST['eroz_ads_link'])) {
            $input_ads_player = $_POST['eroz_ads_link'];
        }
        update_post_meta($post_id, 'eroz_ads_link', $input_ads_player);


        $input_ads_player_2 = '';
        if (isset($_POST['eroz_ads_link_2'])) {
            $input_ads_player_2 = $_POST['eroz_ads_link_2'];
        }
        update_post_meta($post_id, 'movie_code_1', $input_ads_player_2);

        $input_ads_player_3 = '';
        if (isset($_POST['eroz_ads_link_3'])) {
            $input_ads_player_3 = $_POST['eroz_ads_link_3'];
        }
        update_post_meta($post_id, 'movie_code_2', $input_ads_player_3);

        $input_ads_player_4 = '';
        if (isset($_POST['eroz_ads_link_4'])) {
            $input_ads_player_4 = $_POST['eroz_ads_link_4'];
        }
        update_post_meta($post_id, 'movie_code_3', $input_ads_player_4);

        $input_metabox = '';
        if (isset($_POST[$input_trailer])) {
            $input_metabox = $_POST[$input_trailer];
        }
        update_post_meta($post_id, $input_trailer, $input_metabox);
        $input_src = '';
        if (isset($_POST['eroz_meta_src'])) {
            $input_src = $_POST['eroz_meta_src'];
        }
        update_post_meta($post_id, 'eroz_meta_src', $input_src);
    }
    /**
     * Controla las visualizaciones del menú
     * en el área de administración
     *   L 1. Manage Theme = License
     *   L 2. Metabox Post Editor
     *   L 3. Post Reported
     */
    public function controlador_display_menu()
    {
        require_once EROZ_DIR_PATH . 'admin/partials/eroz-admin-display.php';
    }
    public function eroz_function_metabox()
    {
        require_once EROZ_DIR_PATH . 'admin/partials/eroz_function_metabox.php';
    }
    public function eroz_report_post_page_admin()
    {
        require_once EROZ_DIR_PATH . 'admin/partials/eroz-report-post_page_admin.php';
    }
}
