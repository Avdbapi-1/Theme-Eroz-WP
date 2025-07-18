<?php 
add_action( 'widgets_init', function(){
    register_widget( 'wdgt_pornstar' );
});
class wdgt_pornstar extends WP_Widget {
    #Sets up the widgets name etc
    public function __construct() {
        $widget_ops = array(
            'classname' => 'wdgt_pornstar',
            'description' => 'Design only for blocks of home',
        );
        parent::__construct( 'wdgt_pornstar', 'Eroz: Pornstars for Sidebar Home', $widget_ops );
    }
    # Display frontend
    public function widget( $argus, $instance ) {
        $number = ( ! empty( $instance['number'] ) ) ? (int) ( $instance['number'] ) : 5;
        echo $argus['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $argus['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $argus['after_title'];
        } ?>
        <section class="Eroz-Thumbs List">
            <?php 
            $pornstars = get_terms( array(
                'taxonomy'   => 'toro_pornstar',
                'hide_empty' => false,
                'number'     => $number
            ) );
            if( $pornstars ){
                foreach( $pornstars as $pornstar ) { 
                    $term_id = $pornstar->term_id;
                    $name    = $pornstar->name;
                    $url_p   = get_term_link($pornstar); ?>
                    <article class="post stars">
                        <header class="entry-header">
                            <a href="<?php echo $url_p; ?>">
                                <h2 class="entry-title"><?php echo $name; ?></h2>
                                <figure class="post-thumbnail">
                                    <?php if(get_image_pornstar($term_id)){ ?>
                                        <?php echo get_image_pornstar($term_id); ?>
                                    <?php } else { ?>
                                        <img loading="lazy" src="<?php echo EROZ_DIR_URI; ?>public/img/post-noimg-stars.png" alt="<?php echo $term->name; ?>">
                                    <?php } ?>
                                </figure>
                            </a>
                        </header>
                    </article>
                <?php }
            } ?>
        </section>
        <?php echo $argus['after_widget'];
    }
    #Parameters Form of Widget
    public function form( $instance ) {
        $title  = ! empty( $instance['title'] ) ? $instance['title'] : false;
        $number = isset( $instance['number'] ) ? (int)( $instance['number'] ) : 5; 
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