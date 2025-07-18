<?php 
/**
 * WIDGET CATEGORY - TAG : LIST
 * v.1.0.1
 * Show category or tags
 */
add_action( 'widgets_init', function(){
    register_widget( 'widget_categories' );
});
class widget_categories extends WP_Widget {
    public function __construct() {
        $widget_ops = array(
            'classname' => 'widget_categories',
            'description' => 'Show list of category or tags',
        );
        parent::__construct( 'widget_categories', 'Category/Tag List', $widget_ops );
    }
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        } ?>
        <?php 
        $type = isset( $instance['type'] ) ? $instance['type'] : 1;
        $number = isset( $instance['number'] ) ? $instance['number'] : 5;
        $more = isset( $instance['more'] ) ? $instance['more'] : '';
        if($type == 1) { $tax = 'category'; }
        elseif($type == 2) { $tax = 'post_tag'; }
        else { $tax = 'category'; }
        $categories = get_terms( $tax, array(
            'hide_empty' => 0,
            'number' => $number
        ) ); ?>
        <ul>
        <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ){
            foreach ( $categories as $category ) { ?>
                    <li><a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo $category->name; ?></a></li>
            <?php }
        } ?>
        </ul>
        <?php if($more != ''){ ?>
            <a href="<?php echo $more; ?>" class="Button A Sm fa-arrow-right"><?php _e('View All', 'eroz'); ?></a>
        <?php } ?>
        <?php echo $args['after_widget'];
    }
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'eroz' );
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $type = isset( $instance['type'] ) ? absint( $instance['type'] ) : 1;
        $more = ! empty( $instance['more'] ) ? $instance['more'] : __( '', 'eroz' );
        ?>
            <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'eroz' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of terms: ', 'eroz' ); ?></label>
                <input style="width:60px!important" class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>
            <p>
                <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Show terms of:', 'eroz'); ?></label>
                <select style="width: 100%;" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
                    <option<?php selected($type, 1 ); ?> value="1"><?php _e('Category', 'eroz'); ?></option>
                    <option<?php selected($type, 2 ); ?> value="2"><?php _e('Tag','eroz'); ?></option>
                </select>                
            </p>
            <p>
            <label for="<?php echo $this->get_field_id( 'more' ); ?>"><?php _e( 'Link view more:', 'eroz' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'more' ); ?>" name="<?php echo $this->get_field_name( 'more' ); ?>" type="text" value="<?php echo esc_attr( $more ); ?>">
            </p>
        <?php
    }
    public function update( $new_instance, $old_instance ) {
        foreach( $new_instance as $key => $value )
        {
            $updated_instance[$key] = sanitize_text_field($value);
        }
        return $updated_instance;
    }
}
/**
 * WIDGET TOP POST FILTER
 * v.1.0.1
 * Show post by format
 */
add_action( 'widgets_init', function(){
    register_widget( 'widget_post_election' );
});
class widget_post_election extends WP_Widget {
    public function __construct() {
        $widget_ops = array(
            'classname' => 'widget_post_election',
            'description' => 'Post show with filters',
        );
        parent::__construct( 'widget_post_election', 'Post Show', $widget_ops );
    }
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        } ?>
        <div class="Eroz-Thumbs">
        <?php 
        $number = isset( $instance['number'] ) ? $instance['number'] : 5;
        $more = isset( $instance['more'] ) ? $instance['more'] : '';
        $order = isset( $instance['order'] ) ? $instance['order'] : 1;    
        if($order == 1) {
            $argus = array(
                'post_type' => 'post',
                'posts_per_page' => $number,
                'orderby' => 'date',
                'order' => 'DESC'
            ); 
        } elseif($order == 2) {
            $argus = array(
                'post_type' => 'post',
                'posts_per_page' => $number,
                'orderby' => 'views',
                'order' => 'DESC'
            );
        } elseif($order == 3) {
            $argus = array(
                'post_type' => 'post',
                'posts_per_page' => $number,
                'orderby' => 'rand'
            );
        }
            $the_query = new WP_Query( $argus );
            if ( $the_query->have_posts() ) :
                while ( $the_query->have_posts() ) : $the_query->the_post(); 
                    get_template_part( 'public/templates/loop', 'principal' );
                endwhile; endif; wp_reset_query(); ?>
        </div>
        <?php if($more != ''){ ?>
            <a href="<?php echo $more; ?>" class="Button A Sm fa-arrow-right"><?php _e('View All', 'eroz'); ?></a>
        <?php }
        echo $args['after_widget'];
    }
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'eroz' );
        $order    = isset( $instance['order'] ) ? absint( $instance['order'] ) : 1;
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $more = ! empty( $instance['more'] ) ? $instance['more'] : __( '', 'eroz' );
        ?>
            <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'eroz' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order by', 'eroz'); ?></label>
                <select style="width: 100%;" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
                    <option<?php selected($order, 1 ); ?> value="1"><?php _e('Latest', 'eroz'); ?></option>
                    <option<?php selected($order, 2 ); ?> value="2"><?php _e('Views (Require WP-PostViews)', 'eroz'); ?></option>
                    <option<?php selected($order, 3 ); ?> value="3"><?php _e('Random', 'eroz'); ?></option>
                </select>                
            </p>
            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of post: ', 'eroz' ); ?></label>
                <input style="width:60px!important" class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>
            <p>
            <label for="<?php echo $this->get_field_id( 'more' ); ?>"><?php _e( 'Link view more:', 'eroz' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'more' ); ?>" name="<?php echo $this->get_field_name( 'more' ); ?>" type="text" value="<?php echo esc_attr( $more ); ?>">
            </p>
        <?php
    }
    public function update( $new_instance, $old_instance ) {
        foreach( $new_instance as $key => $value )
        {
            $updated_instance[$key] = sanitize_text_field($value);
        }
        return $updated_instance;
    }
}