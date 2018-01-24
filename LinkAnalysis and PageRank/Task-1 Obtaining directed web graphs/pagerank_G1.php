<?php
$inlink_array = array();
$outlink_array  = array();
$init_page_rank_dict = array();
$new_page_rank_dict = array();
$page_list = array();
$sink_pages = array();
$d=0.85;

function parse_graph()
{
	$file = fopen( "G1.txt","r" );
	while( !feof( $file ) )
	{
		$line = fgets( $file );
		$words = explode( " ",$line );
		populate_inlinks( $words );
		populate_pages( $words );
	}
	populate_outlinks();
}
function populate_inlinks( $words )
{
	global $inlink_array ;
	$key = $words[0];
	$values = array_slice( $words,1 );
	for( $i=0;$i<count( $values );$i++ )
	{
		$values[$i] = trim( $values[$i] );
	}
	$inlink_array [$key] = $values;
	
}
function populate_pages( $words )
{
	global $page_list;
	$words[0] = trim( $words[0] );
	$page_list[] = trim( $words[0] );
}
function populate_outlinks()
{
	global $inlink_array ,$outlink_array ;
	foreach( $inlink_array  as $links )
	{
		foreach( $links as $link )
		{
			$link = trim( $link );
			if( !isset( $outlink_array [$link] ) && empty( $outlink_array [$link] ) )
			{
				$outlink_array [$link] = 0;
			}
			$outlink_array [$link] = $outlink_array [$link]+1;
		}
	}
}
function start_pr()
{
	global $page_list;
	$number_of_pages = count( $page_list );
	foreach( $page_list as $page )
	{
		$page = trim( $page );
		$init_page_rank_dict[$page] = 1/$number_of_pages;
	}
	initiate_sink_pagelist();

}
function initiate_sink_pagelist()
{
	global $page_list,$sink_pages,$outlink_array ;
	foreach( $page_list as $page )
	{
		//$page = trim( $page );
		if( !isset( $outlink_array[$page] ) && empty( $outlink_array[$page] ) )
		{
			$sink_pages[] = $page;
		}
		
	}
	//$sink_pages = array();
	echo count($sink_pages);
}
function perplexity_calculation( $dict )
{
	global $page_list;
	$entropy = 0;
	foreach( $page_list as $page )
	{
		$entropy += $dict[$page]*log( 1.0/$dict[$page],2 );
	}
	return pow( 2,$entropy );
}
function calculate_pr()
{
	global $init_page_rank_dict,$new_page_rank_dict,$sink_pages,$page_list,$inlink_array,$outlink_array,$d;
	$counter = 0;
	$perplexity = 0;
	$iteration = 0;
	echo "Calculating Page-Rank \r\n";
	start_pr();
	while( $counter < 4 )
	{
		$sink_page_rank = 0;
		foreach( $sink_pages as $page )
		{
			//$page = trim( $page );
			$sink_page_rank += $init_page_rank_dict[$page];
		}
		foreach( $page_list as $page )
		{
			$new_page_rank_dict[$page] = (1-$d)/count($page_list);         
			$new_page_rank_dict[$page] += $d*($sink_page_rank/count($page_list));
			foreach( $inlink_array[$page] as $inlink_page )
			{
				$inlink_page = trim( $inlink_page );
				//echo $new_page_rank_dict[$page]."\r\n";
				$new_page_rank_dict[$page] = $new_page_rank_dict[$page] + ($d*($init_page_rank_dict[$inlink_page])/($outlink_array[$inlink_page]));
			}
		}
		foreach( $page_list as $page )
		{
			$init_page_rank_dict[$page] = $new_page_rank_dict[$page];
		}
		$perplexity_new = perplexity_calculation($init_page_rank_dict);
		if( abs( $perplexity_new - $perplexity ) < 1 )
		{
			$counter++;
		}
		else
		{
			$counter = 0;
		}
		$perplexity = $perplexity_new;
		$iteration++;
		echo "Perplexity for iteration #".$iteration." is: ".$perplexity_new."\r\n";
	}
}
function sort_page_rank( $dict )
{
	arsort( $dict );
	$count = 0;
	foreach( $dict as $key=>$value )
	{
		if( $count == 50 )
		{
			break;
		}
		echo $key." = ".$value."\r\n";
		$count++;
	}
}
function sort_in_links( $dict )
{
	$new_dict = array();
	foreach( $dict as $key=>$values )
	{
		$new_dict[$key] = count( $values );
	}
	arsort( $new_dict );
	echo "\r\nTop 10 pages based on their In-Links.... \r\n\r\n\r\n";
	$counter = 0;
	foreach( $new_dict as $key=>$value )
	{
		if( $counter==10)
		{
			break;
		}
		echo $key." = ".$value."\r\n";
		$counter++;
	}
}


parse_graph();
echo "\r\nInitiating Program.... \r\n";
calculate_pr();
echo "\r\n===================================================== \r\n";
echo "\r\nTop 50 Pages based on their pagerank scores are : \r\n\r\n";
sort_page_rank($new_page_rank_dict);
echo "\r\n===================================================== \r\n";
sort_in_links( $inlink_array);
echo "\r\ntotal number of pages in the graph are : \r\n";
echo count($page_list);
echo "\r\npages in the graph with no out-links (sinks) are : \r\n";
echo count($sink_pages);
echo "\r\npages in the graph with no in-links (sources) are : \r\n";
echo count($inlink_array)-count($page_list);

//echo json_encode( $sink_pages );
?>