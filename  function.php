<?php
function get_breadcrumbs(){
	global $wp_query;

	if ( !is_home() ){

		// Start the UL
		echo '<ul>';
		// Add the Home link
		echo '<li><a href="'. get_settings('home') .'">'. get_bloginfo('name') .'</a></li>';

		if ( is_category() )
		{
			$catTitle = single_cat_title( "", false );
			$cat = get_cat_ID( $catTitle );
			echo "<li> &raquo; ". get_category_parents( $cat, TRUE, " &raquo; " ) ."</li>";
		}
		elseif ( is_archive() && !is_category() )
		{
			echo "<li> &raquo; Archives</li>";
		}
		elseif ( is_search() ) {

			echo "<li> &raquo; Search Results</li>";
		}
		elseif ( is_404() )
		{
			echo "<li> &raquo; 404 Not Found</li>";
		}
		elseif ( is_single() )
		{
			$category = get_the_category();
			$category_id = get_cat_ID( $category[0]->cat_name );

			echo '<li> &raquo; '. get_category_parents( $category_id, TRUE, " &raquo; " );
			echo the_title('','', FALSE) ."</li>";
		}
		elseif ( is_page() )
		{
			$post = $wp_query->get_queried_object();

			if ( $post->post_parent == 0 ){

				echo "<li> &raquo; ".the_title('','', FALSE)."</li>";

			} else {
				$title = the_title('','', FALSE);
				$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
				array_push($ancestors, $post->ID);

				foreach ( $ancestors as $ancestor ){
					if( $ancestor != end($ancestors) ){
						echo '<li> &raquo; <a href="'. get_permalink($ancestor) .'">'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</a></li>';
					} else {
						echo '<li> &raquo; '. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</li>';
					}
				}
			}
		}

		// End the UL
		echo "</ul>";
	}
}
?>