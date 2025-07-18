<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Post Reported', 'eroz'); ?></h1>
    <p><?php _e('These are all reports, please consider solving them.', 'eroz'); ?></p>
    
    <div>
        <div>
            <?php 
            global $wpdb; 
            $res=$wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = '_repor' ");
            $post=array();

            foreach ($res as $re) {
                $post[]=$re->post_id;
            } ?>
            
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th class="frst">#</th>
                        <th><?php _e('Post', 'eroz'); ?></th>
                        <th><?php _e('Reason', 'eroz'); ?></th>
                        <th><?php _e('Action', 'eroz'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($post) { 
                        $args=array('posts_per_page'=> -1, 'post__in'=> $post, 'post_type'=> 'post');
                        $the_query=new WP_Query($args);
                        if ($the_query->have_posts()): 
                            $con=1;
                            while ($the_query->have_posts()): $the_query->the_post(); ?>
                                <tr>
                                    <td class="frst"><?php echo $con; ?></td>
                                    <td><a class="row-title" target="_blank" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
                                    <td><?php $values = get_post_custom_values("_repor"); echo $values[0]; ?></td>
                                    <td><a data-id="<?php the_ID(); ?>"class="clean-report"><span class="dashicons dashicons-trash"></span> <?php _e('Delete', 'eroz'); ?></a></td>
                                </tr>
                            <?php $con++;
                            endwhile;
                        endif;
                        wp_reset_query();
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="clear"></div>