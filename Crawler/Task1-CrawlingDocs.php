<?php
set_time_limit( 0 );
error_reporting(E_ALL);
ini_set("display_errors", 1);
include 'simple_html_dom.php';
$links_index = array();
$links_queue = array();
$depth_queue = array();
$front = 0;
$rear = 0;
$links_queue[$rear] = '/wiki/Tropical_cyclone';
$depth_queue[$rear] = 1;
$links_index['/wiki/Tropical_cyclone'] = 1;
$rear++;
$url_processed = 0;
$links_str = '';
$final_obj = array();
$final_obj["Links"] = array();
while( $front <= $rear )
{
	$url = $links_queue[$front];
	$depth = $depth_queue[$front];
	if( $depth >= 7 )
	{
		break;
	}
	$front++;
	$url_src = file_get_contents( 'https://en.wikipedia.org'.$url );
	$url_obj = str_get_html( $url_src );
	if( !is_object( $url_obj ) )
	{
		continue;
	}
	$re_from = $url_obj->find( 'span.mw-redirectedfrom' );
	if( count( $re_from ) > 0 )
	{
		continue;
	}
	echo "Processing Link (".$url_processed.") : ".$url." ......\n";
	$main_content = $url_obj->find( '#mw-content-text',0 );
	$heading = $url_obj->find( '#firstHeading',0 )->plaintext;
	$content = $main_content->plaintext;
	$main_links = $main_content->find( 'a[href^="/wiki/"]' );
	foreach( $main_links as $link )
	{
		$link_href = $link->href;
		$link_class = $link->class;
		if( isset( $link_class ) && !empty( $link_class ) && $link_class == 'mw-disambig' )
		{
			continue;
		}
		if( strpos( $link_href,':' ) > 0 )
		{
			continue;
		}
		if( !isset( $links_index[$link_href] ) && empty( $links_index[$link_href] ) )
		{
			$links_queue[$rear] = $link_href;
			$depth_queue[$rear] = $depth+1;
			$links_index[$link_href] = $rear;
			$rear++;
			//echo "Adding URL : ".$link_href." to queue...\n";
		}
	}
	$url_processed++;
	$links_str = $links_str.'https://en.wikipedia.org'.$url.'\n';
	$url_src = str_replace( '/wiki/','https://en.wikipedia.org/wiki/',$url_src );
	$file_title = str_replace( ' ','_',$heading );
	file_put_contents( 'saved/'.$file_title.'.html',$url_src );
	$obj = array(
		'heading'	=>	$heading,
		'depth'		=>	$depth,
		'url_no'	=>	$url_processed,
		'content'	=>	$content
	);
	$final_obj['Links'][] = $obj;
	if( $url_processed >= 1000 )
	{
		break;
	}
	sleep( 2 );
}
//print_r( $links_queue );
file_put_contents( 'links.txt',$links_str );
echo "Done Crawling.. Have A Nice Day";
?>