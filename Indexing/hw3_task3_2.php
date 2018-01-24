<?php
ini_set('memory_limit', '2048M');
include 'array_column.php';
$n = $argv[1];
if( $n > 3 || $n < 1 )
{
	echo 'Please enter between 1 and 3';
}
else
{
	$file_arr = array( 'inverted_index_unigram.txt','inverted_index_bigram.txt','inverted_index_trigram.txt' );
	$file_index = $n-1;
	$output_arr = array( 'doc_freq_unigram.txt','doc_freq_bigram.txt','doc_freq_trigram.txt' );
	$file_read = $file_arr[$file_index];
	$file_content = file_get_contents( $file_read );
	$file_obj = json_decode( $file_content,true );
	foreach( $file_obj as $key=>$value )
	{
		$obj = $file_obj[$key];
		echo "Processing ".$key."\n";
		$df = count( $obj['index'] );
		$docid = implode( ',',array_column( $obj['index'],'docid' ) );
		$docid = sprintf( '[%s]',$docid );
		$file_obj[$key]['output'] = $key.' '.$docid.' '.$df;
	}
	ksort( $file_obj,SORT_STRING );
	$data = implode( "\r\n",array_column( $file_obj,'output' ) );
	file_put_contents( $output_arr[$file_index],$data );
	echo 'Done';
}
?>