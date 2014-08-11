<?php
/**
 * Foundation 5 Top Bar Menu Walker Class for WordPress 3.9+
 */
 
class F5_TOP_BAR_WALKER extends Walker_Nav_Menu
{ 
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) 
	{
        $element->has_children = !empty( $children_elements[$element->ID] );
        
        if(!empty($element->classes)){
        	$element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
        	$element->classes[] = ( $element->has_children ) ? 'has-dropdown' : '';	        
        }
		
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
    
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu dropdown\">\n";
	}
    
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
	{
		$item_output = '';
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$output .= ( $depth == 0 ) ? '<li class="divider"></li>' : '';
		$class_names = $value = '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-'. $item->ID;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';
		$output.= $indent.'<li id="menu-item-'. $item->ID.'" '.$class_names.'>';
		
		if ( empty( $item->title ) && empty( $item->url )) 
		{
			$item->url = get_permalink($item->ID);
			$item->title = $item->post_title;
			
			$attributes = $this->attributes($item);

            $item_output .= '<a'. $attributes .'>';
			$item_output .= apply_filters( 'the_title', $item->title, $item->ID );
			$item_output .= '</a>';
		}
		else
		{
			$attributes = $this->attributes($item);
	
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;
		}
		
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
	}
	
	private function attributes($item)
	{
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		
		return $attributes;
	}
	
	public static function items_default_wrap($menu_text) {
		/**
		 * Set default menu for menus not yet linked to theme location
		 * Method courtesy of robertomatute - https://github.com/roots/roots/issues/939
		 */
		return str_replace('<ul>', '<ul class="right">', $menu_text);
	}
      
	public static function items_remove_defaut_wrapper() 
	{
		/**
		 * Remove default div wrapper around ul element
		 */
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				var default_nav = $(".top-bar-section > div > ul");
				if(default_nav.parent("div").hasClass("right") === true){
		  		default_nav.unwrap();
				}
			});
		</script>
		<?php
	}
}

add_filter('wp_page_menu', array('F5_TOP_BAR_WALKER','items_default_wrap'));
add_action('wp_head', array('F5_TOP_BAR_WALKER','items_remove_defaut_wrapper'));

?>
