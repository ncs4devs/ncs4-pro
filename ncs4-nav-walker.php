<?php
class NCS4_Nav_Walker extends Walker_Nav_Menu {
	function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

		/* Note: it's commonly recommended to use <span> for all links where
		$item -> url == '#' (i.e. a menu item which isn't a page).
		The problem is that <span> items are not focusable and thus are not
		keyboard-accessible (yes, you can use tabindex=0, but it still breaks
		many accessibility programs. Just leave it as it is.)
		*/

    $atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		if ( '_blank' === $item->target && empty( $item->xfn ) ) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $item->xfn;
		}
		$atts['href']         = ! empty( $item->url ) ? $item->url : '';
		$atts['aria-current'] = $item->current ? 'page' : '';

    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

    $item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . $item -> title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$item_output .= $args -> walker -> has_children
			? '<button class="submenu-toggle"></button>'
			: '';

    $output .= '<li class="' . implode(" ", (array) $item -> classes) . '">';
		$output .= $item_output;
	}
}
