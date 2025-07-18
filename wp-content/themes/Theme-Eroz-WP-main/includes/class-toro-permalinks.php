<?php
class TORO_permalinks {
	public function __construct() {
		add_action('admin_init', array( $this, 'settingsInit'));
		add_action('admin_init', array( $this, 'settingsSave'));
	}
	/* Fields
	-------------------------------------------------------------------------------
	*/
	public function settingsInit() {
		$this->addField('', array($this, 'tr_grabber_permalink_title'));
		$this->addField('tr_movies_permalink', array( $this, 'tr_movies_permalink'), __('Pornstar', 'tr-grabber') );
	}
	/* Callbacks
	-------------------------------------------------------------------------------
	*/
	public function tr_grabber_permalink_title() {
		echo '<h2 class="title">'. __('ToroThemes - Permalink Settings') .'</h2>';
	}
	public function tr_movies_permalink() {
		echo $this->input('slug_pornstar', 'pornstar', '/name/');
	}
	/* Save settings
	-------------------------------------------------------------------------------
	*/
	public function settingsSave() {
		if ( ! is_admin() ) return;
		$this->saveField('slug_pornstar');
	}
	/*Helpers
	-------------------------------------------------------------------------------
	*/
	public function input( $option_name, $placeholder = '', $type = NULL, $ul = NULL ) {
        $slug_p = get_option( 'slug_pornstar', false );
		$slug = isset($slug_p) ? $slug_p : 'pornstar';
		$value = isset($slug_p) ? $slug_p : 'pornstar';
        $type = ($type) ? '<code>'. $type .'</code>' : null;
		return '<code>'. home_url() .'/</code><input name="'. $option_name .'" id="'. $option_name .'" type="text" class="regular-text code" value="'. $slug .'" placeholder="'. $placeholder .'" />'.$type;
	}
	public function addField( $option_name, $callback, $title = NULL ){
		add_settings_field(
			$option_name, // id
			$title,       // setting title
			$callback,    // display callback
			'permalink',  // settings page
			'optional'    // settings section
		);
	}
	public function saveField( $option_name ){
        if ( isset( $_POST[$option_name] )  ) {
			$permalink_structure = $_POST[$option_name] ;
			if($_POST[$option_name] != '') { 
				update_option( 'slug_pornstar', $permalink_structure);
			}
		}
	}
}
