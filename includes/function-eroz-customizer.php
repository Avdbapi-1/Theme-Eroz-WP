<?php
/**
 * CUSTOMIZER
 */
if( class_exists( 'WP_Customize_Control' ) ):
    class Eroz_TinyMCE_Custom_control extends WP_Customize_Control {
        public $type = 'tinymce_editor';
        public function enqueue(){
            wp_enqueue_script( 'skyrocket-custom-controls-js', EROZ_DIR_URI . 'admin/customizer/customizer.js', array( 'jquery' ), '1.0', true );
            wp_enqueue_style( 'skyrocket-custom-controls-css', EROZ_DIR_URI . 'admin/customizer/customizer.css', array(), '1.0', 'all' );
            wp_enqueue_editor();
        }
        public function to_json() {
            parent::to_json();
            $this->json['skyrockettinymcetoolbar1'] = isset( $this->input_attrs['toolbar1'] ) ? esc_attr( $this->input_attrs['toolbar1'] ) : 'bold italic bullist numlist alignleft aligncenter alignright link';
            $this->json['skyrockettinymcetoolbar2'] = isset( $this->input_attrs['toolbar2'] ) ? esc_attr( $this->input_attrs['toolbar2'] ) : '';
        }
        public function render_content(){
        ?>
            <div class="tinymce-control">
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php if( !empty( $this->description ) ) { ?>
                    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <?php } ?>
                <textarea id="<?php echo esc_attr( $this->id ); ?>" class="customize-control-tinymce-editor" <?php $this->link(); ?>><?php echo esc_attr( $this->value() ); ?></textarea>
            </div>
        <?php
        }
    }
endif;
function my_customize_register( $wp_customize ) {
    function theme_slug_sanitize_select( $input, $setting ){
        $input = sanitize_key($input);
        $choices = $setting->manager->get_control( $setting->id )->choices;
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                   
    }
    function theme_slug_sanitize_checkbox( $input ){
         return ( ( isset( $input ) && true == $input ) ? true : false );
    }
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('header_image');
    $wp_customize->add_panel( 'eroz_options', array(
        'title' => __( 'Eroz', 'eroz' ),
        'priority' => 30,
        'capability' => 'edit_theme_options',
    ));

        /* Global Settings */
        $wp_customize->add_section( 'general_section' , array(
            'title' => __( 'Global settings', 'eroz' ),
            'panel' => 'eroz_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));

            /* Enable tubeace compatibility */
            $wp_customize->add_setting( 'enable_tubeace', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_checkbox'
            ));
            $wp_customize->add_control('enable_tubeace', array(
                'label' => __( 'Enable Tubeace', 'eroz' ),
                'section' => 'general_section',
                'priority' => 2,
                'type' => 'checkbox'
            ));

        #Home section
        $wp_customize->add_section( 'home_section' , array(
            'title' => __( 'Home', 'eroz' ),
            'panel' => 'eroz_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
            $wp_customize->add_setting( 'sample_tinymce_editor',
                array(
                    'type' => 'option',
                    'capability' => 'edit_theme_options',
                    'sanitize_callback' => 'wp_kses_post'
                )
            );
            $wp_customize->add_control( new Eroz_TinyMCE_Custom_control( $wp_customize, 'sample_tinymce_editor',
                array(
                    'label' => __( 'Text SEO Home', 'eroz' ),
                    'section' => 'home_section',
                    'input_attrs' => array(
                        'toolbar1' => 'formatselect bold italic bullist numlist alignleft aligncenter alignright link',
                    )
                )
            ) );
            $wp_customize->add_setting( 'title_latest_videos', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses'
            ));
            $wp_customize->add_control('title_latest_videos', array(
                'label'    => __( 'Title latest video', 'eroz' ),
                'section'  => 'home_section',
                'priority' => 2,
                'type'     => 'text'
            ));

        #Singlee..php 
        $wp_customize->add_section( 'single_section' , array(
            'title'      => __( 'Entry', 'eroz' ),
            'panel'      => 'eroz_options',
            'priority'   => 1,
            'capability' => 'edit_theme_options',
        ));

            $wp_customize->add_setting( 'single_related_number', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'absint',
                'transport'         => 'refresh',
            ));
            $wp_customize->add_control('single_related_number', array(
                'label'    => __( 'Number items for related post', 'eroz' ),
                'section'  => 'single_section',
                'priority' => 2,
                'type'     => 'number', 
            ));


        
        #Metabox section
        $wp_customize->add_section( 'metabox_section' , array(
            'title' => __( 'Metabox', 'eroz' ),
            'panel' => 'eroz_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
            #metabox video
            $wp_customize->add_setting( 'eroz_meta_video', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses' 
            ));
            $wp_customize->add_control('eroz_meta_video', array(
                'label' => __( 'Metabox video', 'eroz' ),
                'section' => 'metabox_section',
                'priority' => 1,
                'type' => 'text',
            ));
            #metabox duration
            $wp_customize->add_setting( 'eroz_meta_duration', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses' 
            ));
            $wp_customize->add_control('eroz_meta_duration', array(
                'label' => __( 'Metabox duration', 'eroz' ),
                'section' => 'metabox_section',
                'priority' => 1,
                'type' => 'text',
            ));
            #metabox duration
            $wp_customize->add_setting( 'eroz_meta_video_trailer', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses' 
            ));
            $wp_customize->add_control('eroz_meta_video_trailer', array(
                'label' => __( 'Metabox Video Trailer', 'eroz' ),
                'section' => 'metabox_section',
                'priority' => 1,
                'type' => 'text',
            ));
        #Cookie section
        $wp_customize->add_section( 'cookie_section' , array(
            'title' => __( 'Cookies', 'eroz' ),
            'panel' => 'eroz_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
            $wp_customize->add_setting( 'eroz_cookie_enabled', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_checkbox'
            ));
            $wp_customize->add_control('eroz_cookie_enabled', array(
                'label' => __( 'Enabled Cookies', 'eroz' ),
                'section' => 'cookie_section',
                'priority' => 2,
                'type' => 'checkbox'
            ));
            $wp_customize->add_setting( 'eroz_cookie_page_url', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'esc_url_raw'
            ));
            $wp_customize->add_control('eroz_cookie_page_url', array(
                'label' => __( 'URL page cookies', 'eroz' ),
                'section' => 'cookie_section',
                'priority' => 2,
                'type' => 'text'
            ));
            $wp_customize->add_setting( 'eroz_cookie_page_text', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses'
            ));
            $wp_customize->add_control('eroz_cookie_page_text', array(
                'label' => __( 'Title page cookies', 'eroz' ),
                'section' => 'cookie_section',
                'priority' => 2,
                'type' => 'text'
            ));
            $wp_customize->add_setting( 'eroz_cookie_text_announce', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses'
            ));
            $wp_customize->add_control('eroz_cookie_text_announce', array(
                'label'    => __( 'Text cookies announcement', 'eroz' ),
                'section'  => 'cookie_section',
                'priority' => 2,
                'type'     => 'textarea'
            ));
        #Pornstar Page
        $wp_customize->add_section( 'pornstar_page' , array(
            'title'      => __( 'Pornstars', 'eroz' ),
            'panel'      => 'eroz_options',
            'priority'   => 1,
            'capability' => 'edit_theme_options',
        ));

            $wp_customize->add_setting( 'pornstar_page_number', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'absint',
                'transport' => 'refresh',
            ));
            $wp_customize->add_control('pornstar_page_number', array(
                'label'    => __( 'Posts per page (Pornstar Page)', 'eroz' ),
                'section'  => 'pornstar_page',
                'priority' => 2,
                'type'     => 'number', 
            ));
        #Sidebar section
        $wp_customize->add_section( 'sidebar_section' , array(
            'title' => __( 'Sidebar', 'eroz' ),
            'panel' => 'eroz_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
            $wp_customize->add_setting( 'eroz_sidebar_position', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_select'
            ));
            $wp_customize->add_control('eroz_sidebar_position', array(
                'label' => __( 'Position', 'eroz' ),
                'section' => 'sidebar_section',
                'priority' => 2,
                'type' => 'select',
                'choices' => array(
                    'left' => __('Left', 'eroz'),
                    'right' => __('Right', 'eroz'),
                    'none' => __('None', 'eroz')
                )
            ));
        $wp_customize->add_section( 'footer_section' , array(
            'title' => 'Footer',
            'panel' => 'eroz_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
            $wp_customize->add_setting( 'eroz_text_footer', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'wp_filter_nohtml_kses'
            ));
            $wp_customize->add_control('eroz_text_footer', array(
                'label'    => __( 'Footer Text', 'eroz' ),
                'section'  => 'footer_section',
                'priority' => 2,
                'type'     => 'text'
            ));
    $wp_customize->add_panel( 'eroz_ads', array(
        'title' => __( 'ADS', 'eroz' ),
        'priority' => 30,
        'capability' => 'edit_theme_options',
    ));
        #Eroz Ads Home
        $wp_customize->add_section( 'eroz_ads_home' , array(
            'title' => __( 'ADS Home', 'eroz' ),
            'panel' => 'eroz_ads',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
            #Eroz ADS Home Loop
            $wp_customize->add_setting( 'eroz_ads_home_loop', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                #'sanitize_callback' => 'wp_kses_post'
            ));
            $wp_customize->add_control('eroz_ads_home_loop', array(
                'label' => __( 'ADS Home Loop', 'eroz' ),
                'section' => 'eroz_ads_home',
                'priority' => 1,
                'type' => 'textarea',
            ));
            #Eroz ADS Home Bottom
            $wp_customize->add_setting( 'eroz_ads_home_after_loop', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                #'sanitize_callback' => 'wp_kses_post'
            ));
            $wp_customize->add_control('eroz_ads_home_after_loop', array(
                'label' => __( 'ADS Home After Loop', 'eroz' ),
                'section' => 'eroz_ads_home',
                'priority' => 1,
                'type' => 'textarea',
            ));
        #Eroz Ads Single
        $wp_customize->add_section( 'eroz_ads_single' , array(
            'title' => __( 'ADS Single', 'eroz' ),
            'panel' => 'eroz_ads',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
            #Eroz ADS Single Top
            $wp_customize->add_setting( 'eroz_ads_single_top', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                #'sanitize_callback' => 'wp_kses_post'
            ));
            $wp_customize->add_control('eroz_ads_single_top', array(
                'label' => __( 'ADS Single Top', 'eroz' ),
                'section' => 'eroz_ads_single',
                'priority' => 1,
                'type' => 'textarea',
            ));
            #Eroz ADS over player
            $wp_customize->add_setting( 'eroz_ads_overplayer', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                #'sanitize_callback' => 'wp_kses_post'
            ));
            $wp_customize->add_control('eroz_ads_overplayer', array(
                'label' => __( 'ADS Single over player link', 'eroz' ),
                'section' => 'eroz_ads_single',
                'priority' => 1,
                'type' => 'text',
            ));
            #Eroz ADS into player
            $wp_customize->add_setting( 'eroz_ads_intoplayer', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                #'sanitize_callback' => 'wp_kses_post'
            ));
            $wp_customize->add_control('eroz_ads_intoplayer', array(
                'label' => __( 'ADS Single into player', 'eroz' ),
                'section' => 'eroz_ads_single',
                'priority' => 1,
                'type' => 'textarea',
            ));
            #Eroz ADS description
            $wp_customize->add_setting( 'eroz_ads_single_desc', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                #'sanitize_callback' => 'wp_kses_post'
            ));
            $wp_customize->add_control('eroz_ads_single_desc', array(
                'label' => __( 'ADS Single on description', 'eroz' ),
                'section' => 'eroz_ads_single',
                'priority' => 1,
                'type' => 'textarea',
            ));
            #Eroz ADS Single Video
            $wp_customize->add_setting( 'eroz_ads_single_video1', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                #'sanitize_callback' => 'wp_kses_post'
            ));
            $wp_customize->add_control('eroz_ads_single_video1', array(
                'label' => __( 'ADS Single Video 1', 'eroz' ),
                'section' => 'eroz_ads_single',
                'priority' => 1,
                'type' => 'textarea',
            ));
            $wp_customize->add_setting( 'eroz_ads_single_video2', array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                #'sanitize_callback' => 'wp_kses_post'
            ));
            $wp_customize->add_control('eroz_ads_single_video2', array(
                'label' => __( 'ADS Single Video 2', 'eroz' ),
                'section' => 'eroz_ads_single',
                'priority' => 1,
                'type' => 'textarea',
            ));
    #Social
    $wp_customize->add_section( 'eroz_social' , array(
        'title'      => __( 'Social', 'eroz' ),
        'priority'   => 30,
    ));
        $wp_customize->add_setting( 'eroz_social_facebook', array(
            'type' => 'option',
            'capability' => 'edit_theme_options',
             'sanitize_callback' => 'esc_url_raw'
        ));
        $wp_customize->add_control('eroz_social_facebook', array(
            'label' => __( 'Facebook', 'eroz' ),
            'section' => 'eroz_social',
            'priority' => 1,
            'type' => 'text',
        ));
        $wp_customize->add_setting( 'eroz_social_twitter', array(
            'type' => 'option',
            'capability' => 'edit_theme_options',
             'sanitize_callback' => 'esc_url_raw'
        ));
        $wp_customize->add_control('eroz_social_twitter', array(
            'label' => __( 'Twitter', 'eroz' ),
            'section' => 'eroz_social',
            'priority' => 1,
            'type' => 'text',
        ));
        $wp_customize->add_setting( 'eroz_social_google', array(
            'type' => 'option',
            'capability' => 'edit_theme_options',
             'sanitize_callback' => 'esc_url_raw'
        ));
        $wp_customize->add_control('eroz_social_google', array(
            'label' => __( 'Google', 'eroz' ),
            'section' => 'eroz_social',
            'priority' => 1,
            'type' => 'text',
        ));
        $wp_customize->add_setting( 'eroz_social_instagram', array(
            'type' => 'option',
            'capability' => 'edit_theme_options',
             'sanitize_callback' => 'esc_url_raw'
        ));
        $wp_customize->add_control('eroz_social_instagram', array(
            'label' => __( 'instagram', 'eroz' ),
            'section' => 'eroz_social',
            'priority' => 1,
            'type' => 'text',
        ));
        $wp_customize->add_setting( 'eroz_social_youtube', array(
            'type' => 'option',
            'capability' => 'edit_theme_options',
             'sanitize_callback' => 'esc_url_raw'
        ));
        $wp_customize->add_control('eroz_social_youtube', array(
            'label' => __( 'Youtube', 'eroz' ),
            'section' => 'eroz_social',
            'priority' => 1,
            'type' => 'text',
        ));
    #Colors
    $wp_customize->add_section( 'eroz_color' , array(
        'title'      => __( 'Colors', 'eroz' ),
        'priority'   => 30,
    ));
        $wp_customize->add_setting( 'eroz_color_1' , array(
            'default' => '#141414',
            'sanitize_callback' => 'sanitize_hex_color'
        ));
        $wp_customize->add_control(
            new WP_Customize_Color_Control($wp_customize,'eroz_color_1',array(
                'label'       => __('Body Background','eroz'),          
                'section'     => 'eroz_color',
                'settings'    => 'eroz_color_1'
            ))
        );  
        $wp_customize->add_setting( 'eroz_color_2' , array(
            'default' => '#999',
            'sanitize_callback' => 'sanitize_hex_color'
        ));
        $wp_customize->add_control(
            new WP_Customize_Color_Control($wp_customize,'eroz_color_2',array(
                'label'       => __('Text Color','eroz'),           
                'section'     => 'eroz_color',
                'settings'    => 'eroz_color_2'
            ))
        );  
        $wp_customize->add_setting( 'eroz_color_3' , array(
            'default' => '#fff',
            'sanitize_callback' => 'sanitize_hex_color'
        ));
        $wp_customize->add_control(
            new WP_Customize_Color_Control($wp_customize,'eroz_color_3',array(
                'label'       => __('Links Color','eroz'),          
                'section'     => 'eroz_color',
                'settings'    => 'eroz_color_3'
            ))
        );  
        $wp_customize->add_setting( 'eroz_color_4' , array(
            'default' => '#424242',
            'sanitize_callback' => 'sanitize_hex_color'
        ));
        $wp_customize->add_control(
            new WP_Customize_Color_Control($wp_customize,'eroz_color_4',array(
                'label'       => __('Border Color','eroz'),         
                'section'     => 'eroz_color',
                'settings'    => 'eroz_color_4'
            ))
        );  
        $wp_customize->add_setting( 'eroz_color_5' , array(
            'default' => '#ffa90a',
            'sanitize_callback' => 'sanitize_hex_color'
        ));
        $wp_customize->add_control(
            new WP_Customize_Color_Control($wp_customize,'eroz_color_5',array(
                'label'       => __('Main Color','eroz'),           
                'section'     => 'eroz_color',
                'settings'    => 'eroz_color_5'
            ))
        );  
        $wp_customize->add_setting( 'eroz_color_6' , array(
            'default' => '#0b0b0b',
            'sanitize_callback' => 'sanitize_hex_color'
        ));
        $wp_customize->add_control(
            new WP_Customize_Color_Control($wp_customize,'eroz_color_6',array(
                'label'       => __('Secondary Color','eroz'),          
                'section'     => 'eroz_color',
                'settings'    => 'eroz_color_6'
            ))
        );  
        $wp_customize->add_setting( 'eroz_color_7' , array(
            'default' => '#212121',
            'sanitize_callback' => 'sanitize_hex_color'
        ));
        $wp_customize->add_control(
            new WP_Customize_Color_Control($wp_customize,'eroz_color_7',array(
                'label'       => __('Third Color','eroz'),          
                'section'     => 'eroz_color',
                'settings'    => 'eroz_color_7'
            ))
        );  
        $wp_customize->add_setting( 'eroz_color_8' , array(
            'default' => '#333',
            'sanitize_callback' => 'sanitize_hex_color'
        ));
        $wp_customize->add_control(
            new WP_Customize_Color_Control($wp_customize,'eroz_color_8',array(
                'label'       => __('Inputs/Textarea - Background Color','eroz'),           
                'section'     => 'eroz_color',
                'settings'    => 'eroz_color_8'
            ))
        );  
        $wp_customize->add_setting( 'eroz_color_9' , array(
            'default' => '#000',
            'sanitize_callback' => 'sanitize_hex_color'
        ));
        $wp_customize->add_control(
            new WP_Customize_Color_Control($wp_customize,'eroz_color_9',array(
                'label'       => __('Buttons:Hover - Text Color','eroz'),           
                'section'     => 'eroz_color',
                'settings'    => 'eroz_color_9'
            ))
        );  
        $wp_customize->add_setting( 'eroz_color_10' , array(
            'default' => '#ffc107',
            'sanitize_callback' => 'sanitize_hex_color'
        ));
        $wp_customize->add_control(
            new WP_Customize_Color_Control($wp_customize,'eroz_color_10',array(
                'label'       => __('Buttons:Hover - Background Color','eroz'),         
                'section'     => 'eroz_color',
                'settings'    => 'eroz_color_10'
            ))
        );  


    #Analityc Section 
    $wp_customize->add_section( 'section_analityc' , array(
        'title'      => __( 'Analityc', 'eroz' ),
        'panel'      => 'eroz_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));
        $wp_customize->add_setting( 'analityc_code', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            
        ));
        $wp_customize->add_control('analityc_code', array(
            'label'    => __( 'Analityc code', 'eroz' ),
            'section'  => 'section_analityc',
            'priority' => 2,
            'type'     => 'textarea',
        ));

        $wp_customize->add_setting( 'analityc_position', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_select'
        ));
        $wp_customize->add_control('analityc_position', array(
            'label'       => __( 'Analityc position', 'eroz' ),
            'section'     => 'section_analityc',
            'priority'    => 2,
            'type'        => 'select',
            'description' => 'By default is header',
            'choices'     => array(
                'header' => 'Header',
                'footer' => 'Footer',
            )
        ));
    $wp_customize->add_section( 'section_language' , array(
        'title' => __( 'Language', 'eroz' ),
        'panel' => 'eroz_options',
        'priority' => 1,
        'capability' => 'edit_theme_options',
    ));

        $wp_customize->add_setting( 'lang_option', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('lang_option', array(
            'label'    => __( 'Option', 'eroz' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'lang_like', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('lang_like', array(
            'label'    => __( 'Like', 'eroz' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'lang_share', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('lang_share', array(
            'label'    => __( 'Share', 'eroz' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'lang_large_player', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('lang_large_player', array(
            'label'    => __( 'Large player', 'eroz' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));
        $wp_customize->add_setting( 'lang_report', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('lang_report', array(
            'label'    => __( 'Report', 'eroz' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'lang_close_play', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('lang_close_play', array(
            'label'    => __( 'Close and play', 'eroz' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'lang_search', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('lang_search', array(
            'label'    => __( 'Search...', 'eroz' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));
        

}
add_action( 'customize_register', 'my_customize_register' );
function eroz_customize_colors(){
        $eroz_color_1 = esc_html(get_theme_mod('eroz_color_1','#141414'));
        $eroz_color_2 = esc_html(get_theme_mod('eroz_color_2','#999'));
        $eroz_color_3 = esc_html(get_theme_mod('eroz_color_3','#fff'));
        $eroz_color_4 = esc_html(get_theme_mod('eroz_color_4','#424242'));
        $eroz_color_5 = esc_html(get_theme_mod('eroz_color_5','#ffa90a'));
        $eroz_color_6 = esc_html(get_theme_mod('eroz_color_6','#0b0b0b'));
        $eroz_color_7 = esc_html(get_theme_mod('eroz_color_7','#212121'));
        $eroz_color_8 = esc_html(get_theme_mod('eroz_color_8','#333'));
        $eroz_color_9 = esc_html(get_theme_mod('eroz_color_9','#000'));
        $eroz_color_10 = esc_html(get_theme_mod('eroz_color_10','#ffc107'));
        ?>
        <style type="text/css">
            /*(Body Background Color)*/body,.EzHdCn,.Footer .Bot,.Button.B,.Trending a,.EzLinks a,.Button.B:hover,.Trending a:hover,.EzLinks a:hover{background-color:<?php echo $eroz_color_1; ?>}
            /*(Text Color)*/body,.Header .Top,.Cookies,.MoreInfo,.Footer .Top,.Footer .Bot,.Footer .Bot a,input,textarea,select,.Form-Select label,.SelectBox>span,.Form-Icon input+i,.Form-Icon textarea+i,.Form-Search button{color:<?php echo $eroz_color_2; ?>}
            /*(Links Color)*/a,.widget-title,.page-header,.comment-reply-title,.SelectBox>ul>li:hover,.post.category .entry-title,.EzHdCn .title,.Button.B,.Trending a,.EzLinks a,.Header .Top a,.Header .Bot a,.menu li li[class*="fa-"]:before,.menu li ul li:hover>a,.menu li ul li:hover>a:hover,.Cookies a,.Cookies .title,.MoreInfo .title,.MoreInfo a,.Footer .Top h1,.Footer .Top h2,.Footer .Top h3,.Footer .Top h4,.Footer .Top h5,.Footer .Top h6,.Footer .Top .title,.Footer .Top a,.Footer .Bot a:hover,.Button.A,.nav-links a,.nav-links span,.Button.A:hover,.nav-links a:hover,input:focus,textarea:focus,select:focus,.Form-Select select:focus+label,.SelectBox.on>span,.HdOption input:checked+span,.tagcloud a,.tagcloud a:hover{color:<?php echo $eroz_color_3; ?>}
            /*(Border Color)*/fieldset,table thead th,input:focus,textarea:focus,select:focus,.Form-Select select:focus+label,input,textarea,select,.Form-Select label{border-color:<?php echo $eroz_color_4; ?>}
            input:focus,textarea:focus,select:focus,.Form-Select select:focus+label,.SelectBox.on>span{background-color:<?php echo $eroz_color_4; ?>}
            .Button.A:hover,.nav-links a:hover,.tagcloud a:hover{background-color:<?php echo $eroz_color_4; ?>}
            /*(Main Color)*/a:hover,.menu .menu-item-has-children>i,.Header .Top .title:before,.Cookies:before,.Button.A[class*="fa-"]:before,.nav-links .prev-pagin:before,.nav-links .next-pagin:after,.SelectBox.Sm>span:before,.FilterBy,.EzVotes .numper>strong,.page-top .page-header span,.required,.comment-reply-link:before,.comment-notes:before,.EzHdCn .title:before,.MoreInfo .title:before,[data-eztitle]:before,.Breadcrumb:before,.Breadcrumb span,.Header .Top a:hover,.Header .Bot a:hover,.menu li.current-menu-item>a,.menu li:hover>a,.menu>li[class*="fa-"]:before,.menu li li[class*="fa-"]:hover:before,.Cookies a:hover,.MoreInfo a:hover,.Footer .Top a:hover,.Form-Icon input:focus+i,.Form-Icon textarea:focus+i,.Form-Select select:focus+label:before,.Form-Checkbox input:checked~i,.Form-Radio input:checked~i,.Form-Search button:hover,.Button.B:before,.Button.B:hover,.Trending a:hover,.EzLinks a:hover{color:<?php echo $eroz_color_5; ?>}
            .widget-title,.page-header,.comment-reply-title,.comment-list .children{border-color:<?php echo $eroz_color_5; ?>}
            .EzVotes .percnt div,.EzVotes .percnt:before,.Button,a.Button,button,input[type='button'],input[type='reset'],input[type='submit']{background-color:<?php echo $eroz_color_5; ?>}
            .menu>li.current-menu-item>a{box-shadow:inset 2px 0 0 <?php echo $eroz_color_5; ?>}
            @media screen and (min-width:992px){.menu>li.current-menu-item>a{box-shadow:inset 0 -2px 0 <?php echo $eroz_color_5; ?>}}
            /*(Secondary Color)*/
            .Button,a.Button,button,input[type='button'],input[type='reset'],input[type='submit']{color:<?php echo $eroz_color_6; ?>}
            .Header .Bot,.MenuBtn:after,.MenuBtn .Button:before,.MenuBtn .Button:after,.MenuBtn.on:after,.MenuBtn.on .Button:before,.MenuBtn.on .Button:after{background-color:<?php echo $eroz_color_6; ?>}
            @media screen and (max-width:991px){.menu ul{background-color:<?php echo $eroz_color_6; ?>}}
            @media screen and (min-width:992px){.menu li li:hover>a{background-color:<?php echo $eroz_color_6; ?>}}
            /*(Third Color)*/
            .Header .Top,.Header .Mid,.Cookies,.DvrCn:before,.SelectBox>ul,.Trending,.Video,.comment-form,.MoreInfo,.Footer .Top{background-color:<?php echo $eroz_color_7; ?>}
            .Footer .Bot{border-color:<?php echo $eroz_color_7; ?>}
            @media screen and (max-width:991px){#Ez-Wp .Header .Bot,.Header .Social{background-color:<?php echo $eroz_color_7; ?>}}
            @media screen and (min-width:992px){.menu .menu-item-has-children>ul{background-color:<?php echo $eroz_color_7; ?>}}
            /*(Inputs/Textarea - Background Color)*/input,textarea,select,.Form-Select label,.SelectBox>span,.HdOption input:not(:checked)+span,.Button.A,.tagcloud a,.nav-links a,.nav-links span{background-color:<?php echo $eroz_color_8; ?>}
            .HdOption span{border-color:<?php echo $eroz_color_8; ?>}
            /*(Buttons:Hover - Text Color)*/
            .Button:hover,a.Button:hover,button:hover,input[type='button']:hover,input[type='reset']:hover,input[type='submit']:hover,.post .entry-header.hd:after,.nav-links .current,.Button.B.on,.Button.B.on:before,.Button.B.on:hover{color:<?php echo $eroz_color_9; ?>}
            /*(Buttons:Hover - Background Color)*/.Button:hover,a.Button:hover,button:hover,input[type='button']:hover,input[type='reset']:hover,input[type='submit']:hover,.post .entry-header.hd:after,.nav-links .current,.Button.B.on,.Button.B.on:hover{background-color:<?php echo $eroz_color_10; ?>}
            .MenuBtn.on .Button{background-color:<?php echo $eroz_color_10; ?>}
            /*No Edit*/.SelectBox>ul>li:hover{background-color:rgba(0,0,0,.2)}
            .Header .Top,.Footer .Top,.Cookies,.Button.A,.post-thumbnail,.Video,.tagcloud a{box-shadow:0 0 30px rgba(0,0,0,.5)}
            .DvrCn:before,.comment-form,.MoreInfo{box-shadow:inset 0 0 150px rgba(0,0,0,.3),0 0 30px rgba(0,0,0,.5)}
            .nav-links a,.nav-links span,.Trending,.EzLinks a:hover,.Button.B:hover{box-shadow:inset 0 0 30px rgba(0,0,0,.3),0 0 30px rgba(0,0,0,.5)}
            @media screen and (max-width:991px){.Header .Bot,.Header .Social{box-shadow:inset 0 0 150px rgba(0,0,0,.3),0 0 30px rgba(0,0,0,.5)}}
            @media screen and (min-width:992px){.menu .menu-item-has-children>ul,.SelectBox>ul{box-shadow:inset 0 0 150px rgba(0,0,0,.3),0 0 30px rgba(0,0,0,.5)}}            
        </style> 
    <?php 
}
    add_action('wp_head','eroz_customize_colors');