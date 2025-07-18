<?php 
add_action( 'widgets_init', function(){
    register_widget( 'wdgt_categories' );
});
class wdgt_categories extends WP_Widget {
    #Sets up the widgets name etc
    public function __construct() {
        $widget_ops = array(
            'classname' => 'recommended_categories',
            'description' => 'Design only for blocks of home',
        );
        parent::__construct( 'wdgt_categories', 'Eroz: Categories for Sidebar Home', $widget_ops );
    }
    # Display frontend
    public function widget( $argus, $instance ) {
        $number = ( ! empty( $instance['number'] ) ) ? (int) ( $instance['number'] ) : 5;
        $url = ( ! empty( $instance['url'] ) ) ? $instance['url'] : false;
        $order_cat    = ( ! empty( $instance['orderby'] ) ) ? ( $instance['orderby'] ) : 'name';
        if($order_cat == 'name') {
            $order = 'ASC';
        } elseif($order_cat == 'count') {
            $order = 'DESC';
        }
        echo $argus['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $argus['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $argus['after_title'];
        } ?>
        <section class="Eroz-Thumbs List">
            <?php 
            if($order_cat == 'random') {
                $categories = get_terms('category', 'orderby=name&order= ASC&hide_empty=0');
                shuffle($categories);
                $categories = array_slice($categories, 0, $number);
            } else {
                $categories = get_terms( 'category', array(
                    'orderby'    => $order_cat,
                    'order'      => $order,
                    'hide_empty' => true,
                    'number'     => $number
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
        <?php if($url){ ?>
            <a href="<?php echo $url; ?>" class="Button A Sm" data-ttico="arrow_forward"><?php _e('View All', 'eroz'); ?></a>
        <?php } ?>
        <?php echo $argus['after_widget'];
    }
    #Parameters Form of Widget
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : false;
        $number = isset( $instance['number'] ) ? (int)( $instance['number'] ) : 5; 
        $url    = ! empty( $instance['url'] ) ? $instance['url'] : false;
        $orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : 'name';
        ?>

        <div class="wdgt-tt">
            
            <div>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'eroz' ); ?></label>
                <div class="fr-input">
                    <span class="dashicons dashicons-edit-large"></span>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
                </div>
            </div>


            <div>
                <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number Items', 'eroz'); ?></label>
                <div class="fr-input">
                    <span class="dashicons dashicons-shortcode"></span>
                    <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
                </div>
            </div>

            <div>
                <label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e('URL', 'eroz'); ?></label>
                <div class="fr-input">
                    <span class="dashicons dashicons-admin-links"></span>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>">
                </div>
            </div>

            <div>
                <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Order by', 'eroz'); ?></label>
                <div class="fr-input">
                    <span class="dashicons dashicons-randomize"></span>
                    <select id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
                        <option<?php selected($orderby, 'name' ); ?> value="name">Name</option>
                <option<?php selected($orderby, 'count' ); ?> value="count">Items</option>
                <option<?php selected($orderby, 'random' ); ?> value="random">Random</option>
                    </select>
                </div>             
            </div>
        </div>   

        <?php
    }
    #Save Data
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        foreach( $new_instance as $key => $value )
        {
            $updated_instance[$key] = sanitize_text_field($value);
        }
        return $updated_instance;
    }
}