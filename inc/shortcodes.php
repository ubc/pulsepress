<?php 
# the list of shortcodes 
add_shortcode("leaderboard","pulse_press_leaderboard");

function pulse_press_leaderboard( $atts ) {
	extract( shortcode_atts( array(
		'num' 	=> get_option('posts_per_page'),
		'query' =>false,
		'html'	=>'',
		'before'=>'',
		'after' =>''
	), $atts ) );
	
	$html = $before.$html;

	if($query)
		query_posts( $query ."&meta_key=updates_votes&orderby=meta_value&order=DESC");
	else
		query_posts( 'posts_per_page='.$num.'&meta_key=updates_votes&orderby=meta_value&order=DESC' );
		
	$html .= '<ul class="pp_leaderboard">';
	while ( have_posts() ) : the_post();
		
		$html .= '<li><span class="pp_total_votes">'.pulse_press_sum_votes(get_the_ID()).'</span> <span class="pp_for">for</span>';
		$html .= '<a class="pp_permalink" href="'.get_permalink().'" title="'.esc_attr(get_the_title()).'" >'.get_the_title().'</a>';
		$html .= ' <span class="pp_author">by <a href="'.get_author_posts_url(get_the_author_id()).'">'.get_the_author().'</a></span>';
		$html .= '</li>';
	endwhile;
	$html .= "</ul>".$after;
	
	// Reset Query
	wp_reset_query();
	return $html;

}
add_shortcode("reporters","pulse_press_reporter");

function pulse_press_reporter(){


	$args = array(
    'post__not_in' => get_option('sticky_posts'), 
    'showposts' => 3,
    'order' => 'DESC');
    $html = "";
query_posts( $args );
 while (have_posts()) : the_post(); 
		
		$html .= "<div class='reporter-latest'><h3 class='title'><a href='".get_permalink()."'>".get_the_title()."</a></h3>";
		$html .= "<span class='author'><em>Reporter</em>: <strong>".get_the_author_link()."</strong></span><br /> ";
		$html .= "<span class='date'>".get_the_date()."</span> at <span class='time'>". get_the_time()." </span> ";
		$html .= "<div class='excerpt'> ". get_the_excerpt(). "</div></div>";
 endwhile; 
wp_reset_query();
return $html;
}