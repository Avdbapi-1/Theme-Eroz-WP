<?php 
Class EROZ_Sidebar {
	public function create_sidebar() {
		register_sidebar( array(
	        'name'          => __( 'Sidebar Home - Home Blocks', 'eroz' ),
	        'id'            => 'sidebar-home',
	        'description'   => __( 'Home blocks under latest post', 'eroz' ),
	        'before_widget' => '<section id="%1$s" class="widget %2$s">',
	        'after_widget'  => '</section>',
	        'before_title'  => '<h3 class="widget-title">',
	        'after_title'   => '</h3>',
		) );
	}
}