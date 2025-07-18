<?php
class TORO_Create_Taxonomy {
	public static function taxonomy_pornstar(){
		$slug_p = get_option( 'slug_pornstar', false );
		self::create_taxonomy('toro_pornstar', 'Pornstar', 'post', true, $slug_p);
	}
	public static function create_taxonomy($term, $name, $cpt, $tipo, $rewrite){
		$rew = isset($rewrite) ? $rewrite : 'pornstar';
		$labels = array(
		    'name'                       => $name,
		    'singular_name'              => $name,
		    'menu_name'                  => $name,
		    'all_items'                  => 'Todos',
		    'parent_item'                => 'Categoria superior',
		    'parent_item_colon'          => 'Parent Item:',
		    'new_item_name'              => 'New Item Name',
		    'add_new_item'               => 'Añadir Nuevo(a) ' . $name,
		    'edit_item'                  => 'Editar ' . $name,
		    'update_item'                => 'Actualizar ' . $name,
		    'view_item'                  => 'Ver ' . $name,
		    'separate_items_with_commas' => 'Separar con comas',
		    'add_or_remove_items'        => 'Agregar o remover ' . $name,
		    'choose_from_most_used'      => 'Escoger de las mas usadas',
		    'popular_items'              => $name . ' populares',
		    'search_items'               => 'Buscar ' . $name,
		    'not_found'                  => 'No hay resultados',
		    'no_terms'                   => 'No items',
		    'items_list'                 => 'Items list',
		    'items_list_navigation'      => 'Items list navigation',
		);
		$args = array(
		    'labels'                     => $labels,
		    'hierarchical'               => $tipo,
		    'public'                     => true,
		    'show_ui'                    => true,
		    'show_in_rest'               => true,
		    'show_admin_column'          => true,
		    'show_in_nav_menus'          => true,
		    'show_tagcloud'              => true,
		    'rewrite' => array(
	            'slug' => $rew,
	            'with_front' => true,
	            'hierarchical' => true
	        ),
		);
		register_taxonomy( $term, array( $cpt ), $args );
	}
}