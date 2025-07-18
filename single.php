<?php get_header(); 
if(have_posts()) : while(have_posts()) : the_post();?>
    <div class="Body">
        <?php $ads_video_top   = get_option( 'eroz_ads_single_top');
        $ads_video_into_player = get_option( 'eroz_ads_intoplayer');
        $ads_single_desc       = get_option( 'eroz_ads_single_desc');
        $input_video = get_option( 'eroz_meta_video', false ); 

        $tubeace = get_option('enable_tubeace');
        $videos      = array();

        if($tubeace == 1){
            $field_tubeace = get_post_meta( get_the_ID(), 'video_url', true );
			$url = get_post_meta( get_the_ID(), 'url', true );
			$site = get_post_meta( get_the_ID(), 'site', true );
			$embed_ace = get_post_meta(get_the_ID(), 'embed_code', true);
			$video_0 = false;
			//xvideos
			if (strpos($field_tubeace, 'www.xvideos.com') !== false) {
	
				$field_tubeace_array = explode('/', $field_tubeace);
				$field_tubeace_array_reverse = array_reverse($field_tubeace_array);
				$id_xvideos_full = $field_tubeace_array_reverse[1];
				$id_xvideos = str_replace('video', '', $id_xvideos_full);
				$video_0 = '<iframe src="https://www.xvideos.com/embedframe/'.$id_xvideos.'" frameborder="0" width="510" height="400" scrolling="no" allowfullscreen="allowfullscreen"></iframe>';
				
			} //pornhub
			elseif(strpos($url, 'www.pornhub.com') !== false) {
				$url_id = get_post_meta( get_the_ID(), 'video_id', true );
				$video_0 = '<iframe src="https://www.pornhub.com/embed/'.$url_id.'" frameborder="0" width="510" height="400" scrolling="no" allowfullscreen="allowfullscreen"></iframe>';
			}  //xhamster
			elseif(strpos($site, 'xhamster.com') !== false) {
				$url_id = get_post_meta( get_the_ID(), 'video_id', true );
				$video_0 = '<iframe src="https://xhamster.com/xembed.php?video='.$url_id.'" frameborder="0" width="510" height="400" scrolling="no" allowfullscreen="allowfullscreen"></iframe>';
			} //youporn
			elseif(strpos($site, 'youporn.com') !== false) {
				$url_id = get_post_meta( get_the_ID(), 'video_id', true );
				$video_0 = '<iframe src="https://www.youporn.com/embed/'.$url_id.'" frameborder="0" width="510" height="400" scrolling="no" allowfullscreen="allowfullscreen"></iframe>';
			} //tube8.com
			elseif(strpos($site, 'tube8.com') !== false) {
				$url_id = get_post_meta( get_the_ID(), 'video_id', true );
				$video_0 = '<iframe src="https://www.tube8.com/embed/category/title/'.$url_id.'" frameborder="0" width="510" height="400" scrolling="no" allowfullscreen="allowfullscreen"></iframe>';
			} //redtube
			elseif(strpos($site, 'redtube.com') !== false) {
				$url_id = get_post_meta( get_the_ID(), 'video_id', true );
				$video_0 = '<iframe src="https://embed.redtube.com/?id='.$url_id.'&bgcolor=000000" frameborder="0" width="510" height="400" scrolling="no" allowfullscreen="allowfullscreen"></iframe>';
			} //sunporn
			elseif(strpos($embed_ace, 'sunporno.com') !== false) {
				$video_0 = $embed_ace;
			} 

            if (strpos($video_0, '[fvplayer') !== false) { $video_0 = do_shortcode($video_0); }
            if($video_0){$videos[] = $video_0;}
        }


        $video_1     = get_post_meta( get_the_ID(), $input_video, true );
        $video_2     = get_post_meta( get_the_ID(), 'video_optional_1', true );
        $video_3     = get_post_meta( get_the_ID(), 'video_optional_2', true );
        $video_4     = get_post_meta( get_the_ID(), 'video_optional_3', true );
        $video_5     = get_post_meta( get_the_ID(), 'video_optional_4', true );
		
		if (strpos($video_1, '[fvplayer') !== false) { $video_1 = do_shortcode($video_1); }
		if (strpos($video_2, '[fvplayer') !== false) { $video_2 = do_shortcode($video_2); }
		if (strpos($video_3, '[fvplayer') !== false) { $video_3 = do_shortcode($video_3); }
		if (strpos($video_4, '[fvplayer') !== false) { $video_4 = do_shortcode($video_4); }
		if (strpos($video_5, '[fvplayer') !== false) { $video_5 = do_shortcode($video_5); }
		
		if($video_1){$videos[] = $video_1;}
        if($video_2){$videos[] = $video_2;}
        if($video_3){$videos[] = $video_3;}
        if($video_4){$videos[] = $video_4;}
        if($video_5){$videos[] = $video_5;}

        
        if($ads_video_top){ ?>
            <div class="Dvr-B">
                <?php echo $ads_video_top; ?>
            </div>
        <?php } ?>
        <div id="Eroz" class="Video">
            <div class="Container precook">
                <?php do_action( 'single_over_video' ); 
                if(count($videos) > 1){ ?>
                    <ul class="aa-tbs videos-tbs videos-ul-player">
                        <?php foreach ($videos as $key => $vi):
                            $co = $key + 1; ?>
                            <li><a data-ide="<?php the_ID(); ?>" data-key="<?php echo $key; ?>" href="#video-op-a" class="Button B <?php if($key == 0){echo 'on';} ?>"><?php echo lang_eroz('Option', 'lang_option'); ?> <?php echo $co; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php } ?>
                <div class="Row Nsp">
                    <aside>
                        <div class="aa-cn" id="aa-videos-op">
                            <div id="video-op-a" class="aa-tb anm-a hdd on">
                                <div class="Player <?php if($ads_video_into_player){ ?>Pause<?php } ?>">
                                    <?php 
                                    if(count($videos) > 0){
                                        echo $videos[0];
                                    } else {
                                        $vcont = get_the_content();
										$videoframe = explode("</iframe>",$vcont);
                                        echo $videoframe[0]."</iframe>"; 
                                    } ?>
                                    <div class="Dvr">
                                        <?php if($ads_video_into_player){ ?>
                                            <div class="Dvr-B">
                                                <?php echo $ads_video_into_player; ?>
                                            </div>
                                        <a class="Button fa-play-circle far" href="javascript:void(0)"><?php echo lang_eroz('Close and play', 'lang_close_play'); ?></a><?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php do_action( 'single_option_video' ); ?>
                    </aside>
                    <aside>
                        <?php eroz_ads_sidebar_single(); ?>
                    </aside>
                </div>
            </div>
        </div>
        <div class="Container">
            <div class="Page Row DX Nsp SdbL">
                <main>
                    <?php do_action( 'single_comment_before' );
                    comments_template(); ?>
                </main>
                <aside>
                    <div class="MoreInfo post">
                        <div class="Description" data-eztitle="<?php _e('Description', 'eroz'); ?>">
                            <?php $content = get_post_meta(get_the_ID(), 'eroz_post_desc', true);
                            echo $content; ?>
                        </div>
                        
                        <?php 
                        // Hiển thị Original Name
                        $original_name = get_post_meta(get_the_ID(), 'original_name_1', true);
                        if(!empty($original_name)){ ?>
                            <p class="title fa-file-text"><?php _e('Original Name', 'eroz'); ?></p>
                            <p class="EzLinks"><?php echo esc_html($original_name); ?></p>
                        <?php } ?>
                        
                        <?php 
                        // Hiển thị Movie Code
                        $movie_code_1 = get_post_meta(get_the_ID(), 'movie_code_1', true);
                        $movie_code_2 = get_post_meta(get_the_ID(), 'movie_code_2', true);
                        $movie_code_3 = get_post_meta(get_the_ID(), 'movie_code_3', true);
                        
                        if(!empty($movie_code_1) || !empty($movie_code_2) || !empty($movie_code_3)){ ?>
                            <p class="title fa-code"><?php _e('Movie Code', 'eroz'); ?></p>
                            <p class="EzLinks">
                                <?php 
                                if(!empty($movie_code_1)) echo '<span class="movie-code">' . esc_html($movie_code_1) . '</span>';
                                if(!empty($movie_code_2)) echo '<span class="movie-code">' . esc_html($movie_code_2) . '</span>';
                                if(!empty($movie_code_3)) echo '<span class="movie-code">' . esc_html($movie_code_3) . '</span>';
                                ?>
                            </p>
                        <?php } ?>
                        
                        <p class="entry-meta"><?php 
                        // Sửa lỗi Undefined array key 0 - kiểm tra array trước khi truy cập
                        $views_meta = get_post_meta( $post->ID, 'views' );
                        if(!empty($views_meta) && isset($views_meta[0]) && $views_meta[0]){ 
                            ?><span class="Views fa-eye"><?php echo $views_meta[0]; ?></span><?php 
                        } 
                        
                        $input_duration = get_option( 'eroz_meta_duration', true ); 
                        $duration_meta = get_post_meta( $post->ID, $input_duration);
                        if(!empty($duration_meta) && isset($duration_meta[0]) && $duration_meta[0] && secondtotime(get_post_meta( $post->ID, $input_duration, true ))){ 
                            ?><span class="Time fa-clock"><?php 
                            echo secondtotime(get_post_meta( $post->ID, $input_duration, true )); 
                            ?></span><?php 
                        } 
                        ?></p>
                        <p class="title fa-folder"><?php _e( 'Categories', 'eroz' ); ?> </p>
                        <p class="EzLinks"><?php get_terms_taxonomy('category'); ?></p>
                        <?php $tags_list = get_the_tag_list( '', '', '', $post->id); 
                        $pornstar_list = get_the_term_list( $post->ID, 'toro_pornstar', '', '' );
                        if($tags_list){ ?>
                            <p class="title fa-tag"><?php _e('Tags', 'eroz'); ?></p>
                            <p class="EzLinks"><?php echo $tags_list; ?></p>
                        <?php }
                        if($pornstar_list){ ?>
                            <p class="title fa-star"><?php _e('Pornstar', 'eroz'); ?></p>
                            <p class="EzLinks"><?php echo $pornstar_list; ?></p>
                        <?php } ?>
                    </div>
                    <?php if($ads_single_desc){ ?>
                        <section class="widget Dvr-B">
                            <?php echo $ads_single_desc; ?>
                        </section>
                    <?php } ?>
                </aside>
            </div>
        </div>
    </div>
<?php endwhile; endif; get_footer(); ?>