<?php get_header(); ?>
    <div class="Body">
        <div class="Container precook">
            <div class="Page Row DX Nsp <?php echo eroz_position_sidebar(); ?>">
                <main>
                    <section class="Eroz-Thumbs List">
                        <?php $title_latest = get_option( 'title_latest_videos', false );
                        
                        if( $title_latest and $title_latest != ''){ ?>
                            <div class="page-top">
                                <h3 class="page-header"><?php echo $title_latest; ?></h3>
                            </div>
                        <?php } 
                        
                        $ads_home_loop = get_option( 'eroz_ads_home_loop');
                        
                        if($ads_home_loop){ ?>
                            <div class="DvrCn">
                                <div class="Dvr-B">
                                    <?php echo $ads_home_loop; ?>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if(have_posts()) : while(have_posts()) : the_post(); 
                            get_template_part( 'public/templates/loop', 'principal' );
                        endwhile; ?> 
                            <div class="numeration">
                                <nav class="navigation pagination" role="navigation">
                                    <?php eroz_pagination(); ?>
                                </nav>
                            </div>
                        <?php else: ?>
                            <div>
                                <?php _e('There are no articles', 'eroz'); ?>
                            </div>
                        <?php endif; ?>
                    </section>

                    <?php $ads_home_loop = get_option( 'eroz_ads_home_after_loop' );
                    if($ads_home_loop){ ?>
                        <div class="Dvr-A">
                            <?php echo $ads_home_loop; ?>
                        </div>
                    <?php }  ?>
                    
                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-home')) :endif;  ?>
                </main>
                <?php get_template_part( 'public/templates/sidebar' ); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>