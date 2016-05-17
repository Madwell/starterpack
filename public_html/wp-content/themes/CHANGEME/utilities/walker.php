<?php

class minimal_navwalker extends Walker_Nav_Menu {

	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul role=\"menu\" class=\" sub-menu\">\n";
	}
	
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		// Classes
		$class_names = 'menu-item';

		if ( $args->has_children )
			$class_names .= ' dropdown';

		if ( in_array( 'current-menu-item', $item->classes ) || in_array( 'current-menu-parent', $item->classes ) )
			$class_names .= ' active';

		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		// ID
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= '<li' . $id . $class_names .'>';

		// Attributes
		$atts = array();
		$atts['href'] = ! empty( $item->url ) ? $item->url : '';
		
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		// Apply classes, id and attrs
		$item_output = '<a'. $attributes .'>' . apply_filters( 'the_title', $item->title, $item->ID ) . '</a>';

		// Apply output as filter
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	// Traverse elements to create list from elements.

	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

        if ( ! $element ) return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}