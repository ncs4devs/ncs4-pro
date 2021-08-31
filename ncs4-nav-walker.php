<?php
class NCS4_Nav_Walker extends Walker_Nav_Menu {
	function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {

		/* Note: it's commonly recommended to use <span> for all links where
		$item -> url == '#' (i.e. a menu item which isn't a page).
		The problem is that <span> items are not focusable and thus are not
		keyboard-accessible (yes, you can use tabindex=0, but it still breaks
		many accessibility programs. Just leave it as it is.)
		*/

		$output .= '<li class="' . implode(" ", (array) $item -> classes) . '">';
		$output .= '<a href="' . $item -> url . '">';
		$output .= $item -> title;
		$output .= '</a>';

		$output .= $args -> walker -> has_children
			? '<button class="submenu-toggle"></button>'
			: '';
	}
}
