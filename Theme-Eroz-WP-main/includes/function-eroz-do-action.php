<?php

/**
 * home.php
 * Show ADS under loop
 */
function do_action_home_ads_under_loop(){
        $ads_home_loop = get_option( 'eroz_ads_home_after_loop' );
        if($ads_home_loop){ ?>
            <div class="Dvr-A">
                <?php echo $ads_home_loop; ?>
            </div>
        <?php } 
}
add_action('home_after_loop','do_action_home_ads_under_loop');

/**
 * home.php
 * Show Categories Recommended
 */
function do_action_home_categories_recommended(){
        $number_cat = get_option( 'eroz_cat_number', true );
        $order_cat = get_option( 'eroz_cat_type', true );
        $url_cat = get_option( 'eroz_cat_url', true );
        if($order_cat == 'name') {
            $order = 'ASC';
        } elseif($order_cat == 'count') {
            $order = 'DESC';
        }
        if($number_cat > 0) { 
            $title_cat = get_option( 'title_recomended_categories', false ); ?>
            <section class="widget recommended_categories">
                <?php if( $title_cat and $title_cat != '' ){ ?>
                    <h3 class="widget-title"><?php echo $title_cat; ?></h3>
                <?php } ?>

                <section class="Eroz-Thumbs List">
                    <?php 
                    if($order_cat == 'random') {
                        $categories = get_terms('category', 'orderby=name&order= ASC&hide_empty=0');
                        shuffle($categories);
                        $categories = array_slice($categories, 0, $number_cat);
                    } else {
                        $categories = get_terms( 'category', array(
                            'orderby'    => $order_cat,
                            'order'     => $order,
                            'hide_empty' => true,
                            'number' => $number_cat
                        ) ); 
                    }
                    if ( $categories ){
                        foreach ( $categories as $category ) { ?>
                            <article class="post category">
                                <header class="entry-header">
                                    <a href="<?php echo esc_url( get_term_link( $category ) ); ?>">
                                        <h2 class="entry-title"><?php echo $category->name; ?></h2>
                                        <figure class="post-thumbnail">
                                            <?php if(get_image_category($category->term_id)){ ?>
                                                <?php echo get_image_category($category->term_id); ?>
                                            <?php } else { ?>
                                                <img loading="lazy" src="<?php echo EROZ_DIR_URI; ?>public/img/post-noimg.png" alt="<?php echo $category->name; ?>">
                                            <?php } ?>
                                        </figure>
                                    </a>
                                </header>
                            </article>
                        <?php }
                    } ?>
                </section>
                <?php if($url_cat){ ?>
                    <a href="<?php echo $url_cat; ?>" class="Button A Sm" data-ttico="arrow_forward"><?php _e('View All', 'eroz'); ?></a>
                <?php } ?>
            </section>
        <?php }
}
add_action('home_after_loop','do_action_home_categories_recommended');

/**
 * Footer.php
 * Show description of text
 */
function do_action_footer_description(){ 
        if(is_front_page()){ 
            if(get_option( 'sample_tinymce_editor')){ ?>
                <section class="Top">
                    <div class="Description Container">
                        <?php echo wpautop(get_option( 'sample_tinymce_editor' )); ?>
                    </div>
                </section>
            <?php } 
        } elseif(is_single()) { 
            global $post; 
            $desc = get_post_meta( $post->ID, 'eroz_post_desc' ); 
            if($desc){ ?>
                <section class="Top">
                    <div class="Description Container">
                        <?php echo $desc[0]; ?>
                    </div>
                </section>
            <?php }
        } elseif(is_category() or is_tag()) { 
            if(category_description()){ ?>
                <section class="Top">
                    <div class="Description Container">
                        <?php echo category_description(); ?>
                    </div>
                </section>
            <?php }
        } elseif(is_tax('toro_pornstar')) {
             if(category_description()){ ?>
                <section class="Top">
                    <div class="Description Container">
                        <?php echo category_description(); ?>
                    </div>
                </section>
            <?php }
        }
}
add_action('footer_option','do_action_footer_description');

/**
 * Footer.php
 * Show Menu and Copyright
 */
function do_action_footer_menu_copyright(){ ?>
    <div class="Bot">
        <nav class="Container Row CX AtRw Nsp JstfCnB AlgnCnC">
            <?php if ( has_nav_menu( 'footer-menu' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'footer-menu',
                    'items_wrap'     => '<ul class="menu Ft Row BX AtRw JstfCnC">%3$s</ul>'
                ) ); 
            } else { ?>
                <ul class="Menu Ft Row BX AtRw JstfCnC">
                    <?php if(current_user_can('administrator')){ ?>
                        <li>
                            <a target="_blank" href="<?php echo esc_url( home_url() ); ?>/wp-admin/nav-menus.php"><?php _e('Create menu', 'eroz') ?></a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <?php $text_footer = get_option( 'eroz_text_footer', false );
            if($text_footer){ ?>
                <p class="Copy"><?php echo $text_footer; ?></p>
            <?php } ?>
        </nav>
    </div>
<?php }
add_action('footer_option','do_action_footer_menu_copyright');

/**
 * Single.php
 * Show bar options
 */
function do_action_single_bar_option() { 
    ?>
    <ul class="Options Ul Row AX AtRw JstfCnB Nsp">
        <li>
            <a id="like-post" data-id="<?php the_ID(); ?>" href="javascript:void(0)" class="Button B Md fa-thumbs-up"><?php echo lang_eroz('Like', 'lang_like'); ?></a>
            <a id="unlike-post" data-id="<?php the_ID(); ?>" href="javascript:void(0)" class="Button B Md fa-thumbs-down"></a>
            <?php $vote = vote_post_percent(get_the_ID()); ?>
            <div class="EzVotes">
                <div class="numper"><strong><?php echo $vote['percent']; ?>%</strong> <span id="txtmt"><strong><?php echo $vote['total']; ?></strong> <?php _e( 'votes', 'eroz' ); ?></span></div>
                <div class="percnt"><div style="width:<?php echo $vote['percent']; ?>%"></div></div>
            </div>
        </li>
        <li>
            <a href="#comments" class="Button B Md fa-comment-dots"><?php echo get_comments_number(); ?></a>
            <span id="post-share" class="Button B Md fa-share-alt"><span><?php echo lang_eroz('Share', 'lang_share'); ?></span></span>
            <span class="Button B Md LargePlayer AATggl fa-expand" data-tggl="Eroz"><span><?php echo lang_eroz('Large Player', 'lang_large_player'); ?></span></span>
            <span id="post-report" class="Button B Md fa-flag"><span><?php echo lang_eroz('Report', 'lang_report'); ?></span></span>
        </li>
    </ul>
    <?php 
}
add_action('single_option_video','do_action_single_bar_option', 20);
/**
 * Single.php
 * Show option share post
 */
function do_action_single_share() { 
    ?>
        <div id="EzShare" class="EzHdCn">
            <ul class="Ul Row BX">
                <li class="Auto">
                    <p class="title fa-share-alt"><?php _e('Share', 'eroz') ?></p>
                    <ul class="Share Ul">
                        <li class="fcbk"><a  href="javascript:void(0)" onclick="window.open ('http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>', 'Facebook', 'toolbar=0, status=0, width=650, height=450');"><i class="fa-facebook-f fab"></i></a></li>
                        <li class="twtr"><a href="javascript:void(0)" onclick="javascript:window.open('https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&amp;text=<?php the_title(); ?>&amp;tw_p=tweetbutton&amp;url=<?php the_permalink(); ?>', 'Twitter', 'toolbar=0, status=0, width=650, height=450');"><i class="fa-twitter fab"></i></a></li>
                        <li class="ggle"><a onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa-google-plus-g fab"></i></a></li>
                        <li class="whts"><a data-action="share/whatsapp/share" href="whatsapp://send?text=<?php the_permalink(); ?>"><i class="fa-whatsapp fab"></i></a></li>
                    </ul>
                </li>
                <li>
                    <p class="title fa-code"><?php _e('Embed', 'eroz') ?></p>
                    <input type="text" value="<?php the_permalink(); ?>">
                </li>
            </ul>
        </div>
    <?php 
}
add_action('single_option_video','do_action_single_share', 30);
/**
 * Single.php
 * Show option Post Reported
 */
function do_action_single_report() { 
     ?>
        <div id="EzReport" class="EzHdCn">
            <form data-id="<?php the_ID(); ?>" id="form-report">
                <p class="ReportOp">
                    <span class="Form-Radio"><label><input type="radio" name="radio2" value="Underage"><i class="fa-circle"></i><i class="fa-dot-circle"></i><?php _e('Underage', 'eroz'); ?></label></span>
                    <span class="Form-Radio"><label><input type="radio" name="radio2" value="Not Porn"><i class="fa-circle"></i><i class="fa-dot-circle"></i><?php _e('Not Porn', 'eroz'); ?></label></span>
                    <span class="Form-Radio"><label><input type="radio" name="radio2" value="Spam"><i class="fa-circle"></i><i class="fa-dot-circle"></i><?php _e('Spam', 'eroz'); ?></label></span>
                    <span class="Form-Radio"><label><input type="radio" name="radio2" value="Other"><i class="fa-circle"></i><i class="fa-dot-circle"></i><?php _e('Other', 'eroz') ;?></label></span>
                </p>
                <textarea id="reason_text" placeholder="<?php echo _e('Give us more details...', 'eroz'); ?>"></textarea>
            </form>
        </div>
    <?php 
}
add_action('single_option_video','do_action_single_report', 40);

/**
 * Single.php
 * Show related post
 */
function do_action_single_related() {
    global $post;
    $number_items = get_option( 'single_related_number', false );
    if(!$number_items) $number_items = 8;
    $custom_taxterms = wp_get_object_terms( $post->ID, 'category', array('fields' => 'ids') );
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $number_items,
        'orderby'        => 'rand',
        'tax_query'      => array(
            array(
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => $custom_taxterms
            )
        ),
        'post__not_in' => array ($post->ID),
    );
    $the_related = new WP_Query( $args );
    if ( $the_related->have_posts() ) : ?>
        <section class="Eroz-Thumbs List">
            <div class="page-top">
                <h3 class="page-header"><?php _e('Related Videos', 'eroz'); ?></h3>
            </div>
            <?php 
                while ( $the_related->have_posts() ) : $the_related->the_post(); 
                    get_template_part( 'public/templates/loop', 'principal' );
                endwhile;
            wp_reset_query(); ?>
        </section>
    <?php endif;  
}
add_action('single_comment_before','do_action_single_related');
/**
 * Single.php
 * ADS over player
 */
function do_action_ads_over_player() {
        ?>
       
            <?php 
            global $post; 
            $ads_global = get_option( 'eroz_ads_overplayer'); 
            $ads_single = get_post_meta( $post->ID, 'eroz_ads_link', true); 
            $ads_single_2 = get_post_meta( $post->ID, 'eroz_ads_link_2', true); 
            $ads_single_3 = get_post_meta( $post->ID, 'eroz_ads_link_3', true); 
            $ads_single_4 = get_post_meta( $post->ID, 'eroz_ads_link_4', true); 
            if($ads_global != '' or $ads_single != ''){ ?>

                 <div class="cnt-down">

                    <?php if($ads_single) { ?>
                        <a target="_blank" href="<?php echo $ads_single; ?>" class="Button"><?php _e('DOWNLOAD', 'eroz'); ?></a>

                        <?php if($ads_single_2){ ?>
                            <a target="_blank" href="<?php echo $ads_single_2; ?>" class="Button"><?php _e('DOWNLOAD', 'eroz'); ?></a>
                        <?php } ?>
                        <?php if($ads_single_3){ ?>
                            <a target="_blank" href="<?php echo $ads_single_3; ?>" class="Button"><?php _e('DOWNLOAD', 'eroz'); ?></a>
                        <?php } ?>
                        <?php if($ads_single_4){ ?>
                            <a target="_blank" href="<?php echo $ads_single_4; ?>" class="Button"><?php _e('DOWNLOAD', 'eroz'); ?></a>
                        <?php } ?>
                    <?php } else { ?>
                        <a target="_blank" href="<?php echo $ads_global; ?>" class="Button"><?php _e('PLAY OR DOWNLOAD THIS VIDEO ON HD', 'eroz'); ?></a>
                    <?php } ?>
                </div>
            <?php } ?>

        
    <?php
}
add_action('single_over_video','do_action_ads_over_player', 20);
/**
 * Single.php
 * GET Category
 */
function do_action_get_category_single() {
    ?>
    <p class="EzLinks"><?php get_terms_taxonomy('category'); ?></p>
    <?php
}
add_action('dddsingle_over_video','do_action_get_category_single', 10);
/**
 * Single.php
 * BREADCRUMB
 */
function do_action_get_breadcrumb() {
    get_breadcrumb();
}
add_action('single_over_video','do_action_get_breadcrumb', 5);