<?php
/**
 * Position Sidebar
 *   1. Left = SdbL
 *   2. Right = SdbR
 *   3. None = SdbN
 */
if ( ! function_exists( 'eroz_position_sidebar' ) ) {
    function eroz_position_sidebar() { 
        $position = get_option('eroz_sidebar_position');
        // Khởi tạo giá trị mặc định cho $pos để tránh lỗi Undefined variable
        $pos = 'SdbL'; // Giá trị mặc định là left
        
        if($position == 'left'){
            $pos = 'SdbL';
        } elseif($position == 'right'){
            $pos = 'SdbR';
        } elseif($position == 'none'){
            $pos = 'SdbN';
        }
        return $pos;
    }
}
add_theme_support( 'automatic-feed-links' );
add_theme_support('custom-background');
add_editor_style(array('assets/css/editor-style.css'));
if ( ! isset( $content_width ) ) {
  $content_width = 1200;
}
add_action( 'after_setup_theme', 'wpse_theme_setup' );
function wpse_theme_setup() {
    add_theme_support( 'title-tag' );
}
function secondtotime($seconds){
    if(is_numeric($seconds)) {
        if($seconds >= 3600){
            $timeFormat = gmdate("H:i:s", $seconds);
        } else {
            $timeFormat = gmdate("i:s", $seconds);
        }
        return $timeFormat;
    } else {
        return $seconds;
    }
}
/**
* ADS SIDEBAR SINGLE
*/
function eroz_ads_sidebar_single() {
    $ads_video_1 = get_option( 'eroz_ads_single_video1');
    $ads_video_2 = get_option( 'eroz_ads_single_video2');
    if($ads_video_1){ ?>
        <div class="Dvr-B">
            <?php echo $ads_video_1;  ?>
        </div>
    <?php } 
    if($ads_video_2){ ?>
        <div class="Dvr-B">
            <?php echo $ads_video_2;  ?>
        </div>
    <?php }
}
/**
* BREADCRUMB
*/
function get_breadcrumb() {
    if (is_page()) { ?>
        <p class="Breadcrumb fa-home">
            <a href="<?php echo esc_url(home_url()); ?>"><?php _e('Home', 'eroz'); ?></a> 
            <span class="fa-chevron-right"></span> 
            <strong><?php echo get_the_title(); ?></strong>
        </p>
    <?php } elseif (is_single()) { 
        $category = get_the_category(); 
        if (!empty($category)) { 
            // Lấy tiêu đề bài viết
            $post_title = get_the_title();
            // Cắt lấy phần ID đầu tiên
            $post_id_part = explode(' ', $post_title)[0]; ?>
            
            <p class="Breadcrumb fa-home">
                <a href="<?php echo esc_url(home_url()); ?>"><?php _e('Home', 'eroz'); ?></a> 
                <span class="fa-chevron-right"></span> 
                <a href="<?php echo get_category_link($category[0]->term_id); ?>">
                    <?php echo esc_html($category[0]->cat_name); ?>
                </a> 
                <span class="fa-chevron-right"></span> 
                <strong><?php echo esc_html($post_id_part); ?></strong>
            </p>
    <?php } 
    } elseif (is_category() || is_tag()) { 
        $category_name = get_queried_object()->name;
        $category_first_word = explode(' ', $category_name)[0]; ?>
        
        <p class="Breadcrumb fa-home">
            <a href="<?php echo esc_url(home_url()); ?>"><?php _e('Home', 'eroz'); ?></a> 
            <span class="fa-chevron-right"></span> 
            <strong><?php echo esc_html($category_first_word); ?></strong>
        </p>
    <?php } 
}

/**
* GET TITLES PAGES
*/
function get_titles_pages(){
    global $post;
    if(is_front_page()) {
        $title = get_bloginfo('name');
    } elseif(is_singular()){
        $title = get_the_title( $post->ID );
    } elseif(is_category()){
        $title = single_cat_title();
    } elseif(is_tag()){
        $title = single_cat_title();
    } elseif(is_tax()){
        $title = single_cat_title();
    } elseif(is_search()){
        $title = get_search_query();
    } elseif(is_404()){
      $title = '404';
    }
    return $title;
}
/**
* Header Get social Links
*/
function get_social_header(){
    if(get_option( 'eroz_social_facebook')){  ?>
        <li><a href="<?php echo get_option( 'eroz_social_facebook' , true ); ?>" class="fa-facebook-f fab"></a></li>
    <?php }
    if(get_option( 'eroz_social_twitter')){  ?>
        <li><a href="<?php echo get_option( 'eroz_social_twitter' , true ); ?>" class="fa-twitter fab"></a></li>
    <?php } 
    if(get_option( 'eroz_social_google')){  ?>
        <li><a href="<?php echo get_option( 'eroz_social_google' , true ); ?>" class="fa-google-plus-g fab"></a></li>
    <?php }
    if(get_option( 'eroz_social_instagram')){  ?>
        <li><a href="<?php echo get_option( 'eroz_social_instagram' , true ); ?>" class="fa-instagram fab"></a></li>
    <?php }
    if(get_option( 'eroz_social_youtube')){  ?>
        <li><a href="<?php echo get_option( 'eroz_social_youtube' , true ); ?>" class="fa-youtube fab"></a></li>
    <?php } ?>
        <li class="GoTop"><a href="#Ez-Wp" class="fa-arrow-up"></a></li>
    <?php
}
/**
* Registrando los Menus
*/
function register_my_menus() {
    register_nav_menus(
        array(
            'header-menu' => __( 'Header Menu', 'eroz' ),
            'footer-menu' => __( 'Footer Menu', 'eroz' )
        )
    );
}
add_action( 'init', 'register_my_menus' );
/**
* Registrando los Sidebar del sitio
*/
register_sidebar(array
    (
    'name'          => __( 'Main Widget', 'eroz' ),
    'id'            => 'widget-principal',
    'description'   => __( 'Main Widget', 'eroz' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
    )
);
//get image category by termid
function get_image_category($term_id){
    $category_image = get_term_meta( $term_id, 'category-image', true );
    $media_item_src = wp_get_attachment_image( $category_image, 'thumbnail', false, array( 'loading' => 'lazy' ) );
    return $media_item_src;
}
//get image category by termid
function get_image_pornstar($term_id){
    $category_image = get_term_meta( $term_id, 'category-image', true );
    $term = get_term( $term_id, 'toro_pornstar' );
    $media_item_src = wp_get_attachment_image( $category_image, 'toro_pornstar', "", array( "alt" => $term->name ));
    return $media_item_src;
}
// get category/tag
function get_terms_taxonomy($taxonomy){
    global $post;
    $terms = wp_get_post_terms( $post->ID , array( $taxonomy ) );
    foreach ( $terms as $term ) {
        echo '<a href="'.get_term_link( $term ).'">'.$term->name.'</a> ';
    }  
}
//%VOTE POST
function vote_post_percent($post_id){
    $like = get_post_meta( $post_id, 'like', true );
    $unlike = get_post_meta( $post_id, 'unlike', true );
    if(!$like) {$like = 0;}
    if(!$unlike) {$unlike = 0;}
    $total = $like + $unlike;
    if($total == 0) {
        $percent = 0;
    } else {
        $percent = round(($like / $total) * 100);
    }
    $data = array('total' => $total, 'percent' => $percent);
    return $data;
}
//Logotipo en Header
function logotype() {
  if(get_custom_logo()) { 
    the_custom_logo();
  } else { ?>
    <a href="<?php echo esc_url( home_url() ); ?>"><img loading="lazy" src="<?php echo EROZ_DIR_URI; ?>public/img/cnt/eroz.svg" alt="<?php bloginfo('name'); ?>"></a>
  <?php }
}
//Support Basic Theme
if ( ! function_exists( 'fcv_theme_prefix_setup' ) ) {
  function fcv_theme_prefix_setup() {
      add_theme_support( 'custom-logo', array(
      ) );
  }
  add_action( 'after_setup_theme', 'fcv_theme_prefix_setup' );
}
add_theme_support( 'post-thumbnails' );
add_theme_support( 'custom-header' );
//Pagination
function eroz_pagination() {
  if( is_singular() )
    return;
    global $wp_query;
    if( $wp_query->max_num_pages <= 1 )
    return;
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
    if ( $paged >= 1 )
      $links[] = $paged;
    if ( $paged >= 3 ) {
      $links[] = $paged - 1;
      $links[] = $paged - 2;
    }
    if ( ( $paged + 2 ) <= $max ) {
      $links[] = $paged + 2;
      $links[] = $paged + 1;
    }
    echo '<div class="nav-links">' . "\n";
    if ( get_previous_posts_link() )
      printf( '%s' . "\n", get_previous_posts_link( __('Previous', 'eroz') ) );
    if ( ! in_array( 1, $links ) ) {
      $class = 1 == $paged ? ' class="page-item active"' : '';
      printf( '<a class="page-link" href="'.get_pagenum_link( 1 ).'">1</a>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
      if ( ! in_array( 2, $links ) )
          echo '<a>...</a>';
    }
    sort( $links );
    foreach ( (array) $links as $link ) {
      $class = $paged == $link ? ' class="page-link current"' : '';
      printf( '<a%s class="page-link" href="'.get_pagenum_link( $link ).'">'.$link.'</a>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
    if ( ! in_array( $max, $links ) ) {
      if ( ! in_array( $max - 1, $links ) )
          echo '<span class="extend">...</span>' . "\n";
      $class = $paged == $max ? ' class="page-item active"' : '';
      printf( '<a class="page-link" href="'.get_pagenum_link( $max ).'">'.$max.'</a>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
    if ( get_next_posts_link() )
      printf( '%s' . "\n", get_next_posts_link( __('Next', 'eroz') ) );
      echo '</div>' . "\n";
}
/*NEXT POST LINK AND PREV POST LINK CLASS*/
add_filter('next_posts_link_attributes', 'posts_link_attributes_next');
function posts_link_attributes_next() {
    return 'class="next-pagin page-numbers"';
}
add_filter('previous_posts_link_attributes', 'posts_link_attributes_prev');
function posts_link_attributes_prev() {
    return 'class="prev-pagin page-numbers"';
}
/**
 * ADD TERM META
 * SAVE TERM META
 * TERM META IMAGE
 */
function my_category_addform_termmeta() {
  wp_nonce_field( 'my_category_termmeta', 'my_category_termmeta_nonce' );?>
  <div class="form-field category-image-wrap">
    <label for="category-image"><?php _e('Featured Image', 'eroz'); ?></label>
    <div class="custom_media_item">
      <figure style="margin-top:0;margin-left:0"><img loading="lazy" src="" style="max-width:150px;display:none;" /></figure>
      <a href="#" class="button button-primary custom_media_item_upload"><?php _e('Upload image', 'eroz'); ?></a>
      <input type="hidden" id="category-image" name="category-image" value="" />
      <a href="#" class="button button-primary custom_media_item_delete" style="display:none;"><?php _e('Delete', 'eroz'); ?></a>
    </div>
  </div>
<?php }
add_action( 'category_add_form_fields', 'my_category_addform_termmeta' );
add_action( 'toro_pornstar_add_form_fields', 'my_category_addform_termmeta' );
//Función para añadir campos personalizados al formulario de Editar taxonomía
function my_category_editform_termmeta( $term ) {
  $category_image = get_term_meta( $term->term_id, 'category-image', true );
  wp_nonce_field( 'my_category_termmeta', 'my_category_termmeta_nonce' );?>
  <tr class="form-field category-image-wrap">
    <th scope="row"><label for="category-image"><?php _e('Featured Image', 'eroz'); ?></label></th>
    <td>
      <div class="custom_media_item">
        <?php
        $display = "";
        if (empty($category_image) || $category_image == "") { $display = 'display:none';}
        $media_item_src = wp_get_attachment_url( $category_image );?>
        <figure style="margin-top:0;margin-left:0"><img loading="lazy" src="<?php echo $media_item_src;?>" style="max-width:150px;<?php echo $display;?>" /></figure>
        <a href="#" class="button button-primary custom_media_item_upload"><?php _e('Upload image', 'eroz'); ?></a>
        <input type="hidden" id="category-image" name="category-image" value="<?php echo $category_image;?>" />
        <a href="#" class="button button-primary custom_media_item_delete" style="<?php echo $display;?>"><?php _e('Delete', 'eroz'); ?></a>
      </div>
    </td>
  </tr>
<?php }
add_action( 'category_edit_form_fields', 'my_category_editform_termmeta' );
add_action( 'toro_pornstar_edit_form_fields', 'my_category_editform_termmeta' );
function my_category_fields_save_data( $term_id ) {
  // Comprobamos si se ha definido el nonce.
  if ( ! isset( $_POST['my_category_termmeta_nonce'] ) ) {
    return $term_id;
  }
  $nonce = $_POST['my_category_termmeta_nonce'];
  // Verificamos que el nonce es válido.
  if ( !wp_verify_nonce( $nonce, 'my_category_termmeta' ) ) {
    return $term_id;
  }
  // Si existen entradas antiguas las recuperamos
  $old_category_image = get_term_meta( $term_id, 'category-image', true );
  // Saneamos lo introducido por el usuario.
  $category_image = sanitize_text_field( $_POST['category-image'] );
  // Actualizamos el campo meta en la base de datos.
  update_term_meta( $term_id, 'category-image', $category_image, $old_category_image );
}
add_action( 'edit_category', 'my_category_fields_save_data' );
add_action( 'create_category', 'my_category_fields_save_data' );
add_action( 'edit_toro_pornstar', 'my_category_fields_save_data' );
add_action( 'create_toro_pornstar', 'my_category_fields_save_data' );
function edd_sam() {
    $license = get_option( 'license', '0' );
    $store_url = 'https://torothemes.com';
    $item_id = '1635';
    $api_params = array(
        'edd_action' => 'check_license',
        'license' => $license,
        'item_id' => $item_id,
        'url' => home_url()
    );
    $response = wp_remote_post( $store_url, array( 'body' => $api_params, 'timeout' => 15, 'sslverify' => false ) );
        if ( is_wp_error( $response ) ) {
        return false;
    }
    $license_data = json_decode( wp_remote_retrieve_body( $response ) );
    if( $license_data->license == 'valid' ) {
        return 'valid';
        exit;
        // this license is still valid
    } else {
        return 'invalid';
    exit;
    // this license is no longer valid
  }
}