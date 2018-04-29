<?php

class Memoo_walker_nav_menu extends Walker_Nav_Menu {

private $blog_sidebar_pos = "";
// add classes to ul sub-menus
function start_lvl( &$output, $depth = 0, $args = Array() ) {
    // depth dependent classes
    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
    $classes = array(
        'dropdown-menu',
        ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
        ( $display_depth >=2 ? '' : '' ),
        'menu-depth-' . $display_depth
        );
    $class_names = implode(' ', $classes );

    // build html
    $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
}

// add main/sub classes to li's and links
 function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    global $wp_query, $wpdb;
    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

    // Check if menu item is in main menu
    $has_children = $wpdb->get_var("SELECT COUNT(meta_id)
                            FROM wp_postmeta
                            WHERE meta_key='_menu_item_menu_item_parent'
                            AND meta_value='".$item->ID."'");

    // depth dependent classes
    $depth_classes = array(
        ( $depth == 0 ? '' : '' ), //class for the top level menu which got sub-menu
        ( ($depth >=2 || $has_children > 0) ? 'dropdown' : '' ), //class for the level-1 sub-menu which got level-2 sub-menu and level-2 menu which got level-3 submenu
        ( $depth >=2 ? 'sub-sub-menu-item' : '' ), //class for the level-2 sub-menu which got level-3 sub-menu
        ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
        'menu-item-depth-' . $depth
    );
    $depth_class_names = esc_attr( trim(implode( ' ', $depth_classes )) );

    // passed classes
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

    // build html
    $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

    // link attributes
    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
    //$attributes .= ' class="' . ( $depth > 0 ? '' : '' ) . '"';


    if ( $depth == 0 && $has_children > 0  ) {
        // These lines adds your custom class and attribute
        $attributes .= ' class="dropdown-toggle"';
    }
    if ( $depth == 1 && $has_children > 0  ) {
        // These lines adds your custom class and attribute
        $attributes .= ' class="dropdown-toggle"';
    }
    $description  = ! empty( $item->description ) ? '<i class="'.esc_attr( $item->description ).'" aria-hidden="true"></i>' : '';

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
        if ($description != '') {
            if (in_array('right', $item->classes, true)) {
                $item_output .= $args->link_before . '<span class="menu-list-item-title">'. apply_filters( 'the_title', $item->title, $item->ID ) .'</span>'. $description . $args->link_after; //If you want the description to be output after <a>
            } else {
                $item_output .= $description.$args->link_before . '<span class="menu-list-item-title">'. apply_filters( 'the_title', $item->title, $item->ID ) .'</span>'. $args->link_after; //If you want the description to be output after <a>
            }
        } else {
            $item_output .= $args->link_before . '<span class="menu-list-item-title">'. apply_filters( 'the_title', $item->title, $item->ID ) .'</span>' . $args->link_after;
        }
    $item_output .= '</a>';

    if ( get_option('memoo_header_hide_menu_arrows', '') != '' ) {
        $extra_class = ' hide-arrow';
    } else {
        $extra_class = '';
    }

    // Add the caret if menu level is 0
    if ( $depth == 0 && $has_children > 0  ) {
        $item_output .= '<span class="caret-wrapper'.$extra_class.'"><i class="far fa-chevron-down"></i></span>';
    }

    if ( $depth == 1 && $has_children > 0  ) {
        $item_output .= '<span class="caret-wrapper'.$extra_class.'"><i class="far fa-chevron-right"></i></span>';
    }

    $item_output .= $args->after;

    // build html
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
}
} //End Walker_Nav_Menu
