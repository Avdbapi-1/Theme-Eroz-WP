<?php get_header(); ?>
    <div class="Body">
        <div class="Container precook">
            <div class="Page Row DX Nsp <?php echo eroz_position_sidebar(); ?>">
            
                <main>                 
                    
                    <section class="Eroz-Thumbs List">
                        <div class="page-top">
                            <h3 class="page-header"><?php _e('Searched term', 'eroz'); ?>: <?php echo get_search_query(); ?></h3>
                        </div>
                
                        <?php $ads_home_loop = get_option( 'eroz_ads_home_loop');
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
                                <?php _e('No articles', 'eroz'); ?>
                            </div>
                        <?php endif; ?>
                    </section>
                </main>
                <!-- Sidebar -->
                <?php get_template_part( 'public/templates/sidebar' ); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>