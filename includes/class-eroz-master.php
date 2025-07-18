<?php
class EROZ_Master
{
    protected $cargador;
    protected $theme_name;
    protected $version;
    /*Construct*/
    public function __construct()
    {
        $this->theme_name = 'Eroz Theme';
        $this->version = '1.8.4';
        $this->cargar_dependencias();
        $this->cargar_instancias();
        $this->set_idiomas();
        $this->definir_admin_hooks();
        $this->definir_public_hooks();
    }
    private function cargar_dependencias()
    {
        require_once EROZ_DIR_PATH . 'includes/class-bct-cargador.php';
        require_once EROZ_DIR_PATH . 'includes/class-bct-build-menupage.php';
        require_once EROZ_DIR_PATH . 'includes/class-eroz-nav-walker.php';
        require_once EROZ_DIR_PATH . 'includes/class-eroz-function-public.php';
        require_once EROZ_DIR_PATH . 'includes/function-eroz-do-action.php';
        require_once EROZ_DIR_PATH . 'includes/function-eroz-customizer.php';
        require_once EROZ_DIR_PATH . 'includes/function-eroz-widgets.php';
        require_once EROZ_DIR_PATH . 'includes/class-eroz-public-ajax.php';
        require_once EROZ_DIR_PATH . 'includes/class-eroz-admin-ajax.php';
        require_once EROZ_DIR_PATH . 'admin/class-bct-admin.php';
        require_once EROZ_DIR_PATH . 'public/class-bct-public.php';
        require_once EROZ_DIR_PATH . 'includes/class-eroz-support.php';
        require_once EROZ_DIR_PATH . 'includes/class-eroz-cpt.php';
        #Taxonomies Create
        require_once EROZ_DIR_PATH . 'includes/class-toro-create-taxonomy.php';
        #Permalinks Settings
        require_once EROZ_DIR_PATH . 'includes/class-toro-permalinks.php';
        require_once EROZ_DIR_PATH . 'includes/class-eroz-sidebar.php';
        require_once EROZ_DIR_PATH . 'includes/widgets/home/wdgt_categories.php';
        require_once EROZ_DIR_PATH . 'includes/widgets/home/wdgt_pornstars.php';
        require_once EROZ_DIR_PATH . 'includes/data/class-bct-data-post.php';
    }
    private function set_idiomas()
    {
        //$bct_i18n = new BCT_i18n();
        //a$this->cargador->add_action( 'after_setup_theme', $bct_i18n, 'load_plugin_textdomain' );
    }
    private function cargar_instancias()
    {
        // Cree una instancia del cargador que se utilizará para registrar los ganchos con WordPress.
        $this->cargador             = new BCT_Cargador;
        $this->bct_admin            = new BCT_Admin($this->get_theme_name(), $this->get_version());
        $this->bct_public           = new BCT_Public($this->get_theme_name(), $this->get_version());
        $this->eroz_public_ajax     = new EROZ_public_ajax;
        $this->eroz_admin_ajax      = new EROZ_admin_ajax;
        $this->toro_create_taxonomy = new TORO_Create_Taxonomy;
        $this->toro_permalink       = new TORO_permalinks;
        $this->eroz_support         = new EROZ_Support;
        $this->sidebar              = new EROZ_Sidebar;
        $this->cpt                  = new EROZ_Create_CustomPostType;
    }
    /**
     * Registrar todos los ganchos relacionados con la funcionalidad del área de administración
     * del plugin.
     */
    private function definir_admin_hooks()
    {
        $this->cargador->add_action('admin_enqueue_scripts', $this->bct_admin, 'enqueue_styles');
        $this->cargador->add_action('admin_enqueue_scripts', $this->bct_admin, 'enqueue_scripts');
        $this->cargador->add_action('admin_menu', $this->bct_admin, 'add_menu');
        $this->cargador->add_action('add_meta_boxes', $this->bct_admin, 'add_metabox');
        $this->cargador->add_action('save_post', $this->bct_admin, 'save_metabox', 10, 3);
        #sidebar 
        $this->cargador->add_action('init', $this->sidebar, 'create_sidebar');
        $this->cargador->add_action('init', $this->cpt, 'blog');
        /*REPORT CLEAN*/
        $this->cargador->add_action('wp_ajax_action_eroz_clean_report', $this->eroz_admin_ajax, 'eroz_clean_report');
        $this->cargador->add_action('wp_ajax_action_eroz_save_metabox', $this->eroz_admin_ajax, 'eroz_save_metabox');
        $this->cargador->add_action('init', $this->toro_create_taxonomy, 'taxonomy_pornstar');
        /*ACTIVATE LICENSE*/
        $this->cargador->add_action('wp_ajax_action_activate_license', $this->eroz_admin_ajax, 'eroz_activate_license');
        $positionAnalityc = get_option('analityc_position', false);
        if (!$positionAnalityc) $positionAnalityc = 'header';
        if ($positionAnalityc == 'header') {
            $this->cargador->add_action('wp_head', $this->eroz_support, 'code_analityc');
        } else {
            $this->cargador->add_action('wp_footer', $this->eroz_support, 'code_analityc');
        }
    }
    /**
     * Registrar todos los ganchos relacionados con la funcionalidad del área pública
     * del Theme.
     * @since    1.0.0
     * @access   public
     */
    private function definir_public_hooks()
    {
        $this->cargador->add_action('wp_enqueue_scripts', $this->bct_public, 'enqueue_styles');
        $this->cargador->add_action('wp_footer', $this->bct_public, 'enqueue_scripts');
        /*Post Reported*/
        $this->cargador->add_action('wp_ajax_action_eroz_send_report', $this->eroz_public_ajax, 'eroz_send_report');
        $this->cargador->add_action('wp_ajax_nopriv_action_eroz_send_report', $this->eroz_public_ajax, 'eroz_send_report');
        /*VOTE POST*/
        $this->cargador->add_action('wp_ajax_action_eroz_send_vote', $this->eroz_public_ajax, 'eroz_send_vote');
        $this->cargador->add_action('wp_ajax_nopriv_action_eroz_send_vote', $this->eroz_public_ajax, 'eroz_send_vote');
        $this->cargador->add_action('wp_ajax_nopriv_action_change_player_eroz', $this->eroz_public_ajax, 'change_player_eroz');
        $this->cargador->add_action('wp_ajax_action_change_player_eroz', $this->eroz_public_ajax, 'change_player_eroz');
    }
    /**
     * Ejecuta el cargador para ejecutar todos los ganchos con WordPress.
     *
     * @since    1.0.0
     * @access   public
     */
    public function run()
    {
        $this->cargador->run();
    }
    /**
     * El nombre del plugin utilizado para identificarlo de forma exclusiva en el contexto de
     * WordPress y para definir la funcionalidad de internacionalización.
     *
     * @since     1.0.0
     * @access    public
     * @return    string    El nombre del theme
     */
    public function get_theme_name()
    {
        return $this->theme_name;
    }
    /**
     * La referencia a la clase que itera los ganchos con el theme
     *
     * @since     1.0.0
     * @access    public
     * @return    BCT_Cargador    Itera los ganchos del theme
     */
    public function get_cargador()
    {
        return $this->cargador;
    }
    /**
     * Retorna el número de la versión deltheme
     *
     * @since     1.0.0
     * @access    public
     * @return    string    El número de la versión del theme
     */
    public function get_version()
    {
        return $this->version;
    }
}