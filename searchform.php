<?php
/**
 * Template part for displaying search form
 *
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package memoo
*/
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text">Søg efter:</span>
        <input type="search" class="search-field" placeholder="Du kan prøve igen med andre søgeord." value="<?php echo get_search_query(); ?>" name="s">
        <input type="submit" class="search-submit" value="Søg.">
    </label>
    <input type="hidden" name="lang" value="da">
</form>
