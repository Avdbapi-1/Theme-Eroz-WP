<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php if(is_single()) : 
        $description = get_the_excerpt();
        if(empty($description)) {
            $description = get_the_title();
        }
    ?>
        <meta name="description" content="<?php echo esc_attr(wp_strip_all_tags($description)); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>
<?php global $eroz_master; ?>
<body <?php body_class(); ?>>
    <!--<Ez-Wp>-->
    <div id="Ez-Wp">
        <header class="Header">
            <div class="Top">
                <div class="Container Row CX AtRw JstfCnB">
                    <h1 class="title fa-play-circle far"><?php echo get_titles_pages(); ?></h1>
                    <ul class="Social Ul">
                        <?php get_social_header(); ?>
                    </ul>
                </div>
            </div>
            <div class="Mid">
                <div class="Container Row AX AtRw AlgnCnC JstfCnB">
                    <figure class="Logo"><?php logotype(); ?></figure>
                    <div class="Form-Search">
                        <?php get_search_form(); ?>
                    </div>
                    <span class="MenuBtn AATggl Fxd" data-tggl="Ez-Wp"><span class="Button">Menu</span></span>
                </div>
            </div>
            <nav class="Bot">
                <?php if ( has_nav_menu( 'header-menu' ) ) {
                wp_nav_menu( array(
                        'theme_location' => 'header-menu',
                        'items_wrap'     => '<ul class="menu Container Row DX AtRw">%3$s</ul>',
                        'walker'         => $eroz_master->bct_public->get_instance_navwalker()
                    ) ); 
                } else { ?>
                <ul class="menu Container Row DX AtRw menu-top-menu-container">
                    <?php if(current_user_can('administrator')){ ?>
                        <li>
                            <a target="_blank" href="<?php echo esc_url( home_url() ); ?>/wp-admin/nav-menus.php">Crear Menu en wp-admin</a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
            </nav>
        </header>
<?php 
 