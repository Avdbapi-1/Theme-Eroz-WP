<?php get_header(); 
if(have_posts()) : while(have_posts()) : the_post();?>
    <div class="Body">
       
        <div class="Container">
            <div class="Page Row DX Nsp SdbL">
                <main>
                    <div class="content-blog">
                    <h1><?php the_title(); ?></h1>
                        <?php the_content(); ?>
                    </div>
                    
                    <?php do_action( 'single_comment_before' );
                    
                    comments_template(); ?>
                </main>
                <aside>
                        <div class="MoreInfo post">
                        <div class="Description" data-eztitle="Description">
                                                                                </div>
                        <p class="entry-meta"><span class="Views fa-eye">1459</span> <span class="Time fa-clock">17:07</span></p>
                        <p class="title fa-folder">Categories </p>
                        <p class="EzLinks"><a href="https://torothemes.com/demo/eroz/category/blondes/">Blondes</a> </p>
                                                    <p class="title fa-tag">Tags</p>
                            <p class="EzLinks"><a href="https://torothemes.com/demo/eroz/tag/best-amateur-couple/" rel="tag">best amateur couple</a><a href="https://torothemes.com/demo/eroz/tag/best-boobs-cumshot/" rel="tag">best boobs cumshot</a><a href="https://torothemes.com/demo/eroz/tag/boobs-cumshot/" rel="tag">boobs cumshot</a><a href="https://torothemes.com/demo/eroz/tag/fishnet-stockings/" rel="tag">fishnet stockings</a><a href="https://torothemes.com/demo/eroz/tag/french-amateur/" rel="tag">french amateur</a><a href="https://torothemes.com/demo/eroz/tag/french-big-boobs/" rel="tag">french big boobs</a><a href="https://torothemes.com/demo/eroz/tag/french-homemade/" rel="tag">french homemade</a><a href="https://torothemes.com/demo/eroz/tag/french-teen/" rel="tag">french teen</a><a href="https://torothemes.com/demo/eroz/tag/hands-cumshot/" rel="tag">hands cumshot</a><a href="https://torothemes.com/demo/eroz/tag/hard-amateur-sex/" rel="tag">hard amateur sex</a><a href="https://torothemes.com/demo/eroz/tag/homemade/" rel="tag">homemade</a><a href="https://torothemes.com/demo/eroz/tag/leather-lingerie/" rel="tag">leather lingerie</a><a href="https://torothemes.com/demo/eroz/tag/louiseetmartin/" rel="tag">louiseetmartin</a><a href="https://torothemes.com/demo/eroz/tag/real-amateur/" rel="tag">real amateur</a><a href="https://torothemes.com/demo/eroz/tag/real-orgasm/" rel="tag">real orgasm</a><a href="https://torothemes.com/demo/eroz/tag/skinny-teen/" rel="tag">skinny teen</a></p>
                                            </div>
                   
                </aside>
            </div>
        </div>
    </div>
<?php endwhile; endif;
get_footer(); ?>