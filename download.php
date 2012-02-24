<?php  
header("Content-type: text/csv");  
header("Cache-Control: no-store, no-cache");
header('Content-Disposition: attachment; filename="wordpress-export-posts.csv"');  

$outstream = fopen("php://output",'w');  

// Include WordPress 
define('WP_USE_THEMES', false);
require('../../wp-load.php');

$list = array();
$list[] = array('Post Title', 'Permalink', 'Meta Description');

// The Query: get all published posts
$the_query = new WP_Query( 'post_type=post&post_status=publish&posts_per_page=-1' );					 
// The Loop
while ( $the_query->have_posts() ) : $the_query->the_post();
	$desc = '';
	$desc = get_post_meta($post->ID, '_aioseop_description', true);	
	$list[] = array( get_the_title(), get_permalink(), $desc );
endwhile;

  
foreach( $list as $row )  
{  
    fputcsv($outstream, $row, ',', '"');  
}  
  
fclose($outstream);  

?>