<?php
ini_set('memory_limit', '2048M');
include 'array_column.php';

$n = $argv[1];
$n = intval( $n );
if( $n > 3 || $n < 1)
{
	echo "Please Input Between 1 and 3";
}
else
{
	$files = glob( "saved/corpus/*.txt" );
	$tf_inv_index = array();
	//$tf_inv_index["Records"] = array();
	$final_output = "";
	$flag = 0;
	for( $i=0;$i<count( $files );$i++ )
	{
		echo "Processing File ".$files[$i]."\n";
		$file_content = file_get_contents( $files[$i] );
		$file_content = strtolower( $file_content );
		$content_words = explode( " ",$file_content );
		$cnt_values = array_count_values( $content_words );
		$limit = count( $content_words )-$n;
		//$ngram_index = array();
		$ngram_str = '';
		$filename = $files[$i];
		$filename = str_replace( ".txt","",$filename );
		$filename = str_replace( "saved/corpus/","",$filename );
		$docid = $filename;
		for( $j=0;$j<=$limit;$j++ )
		{
			$ngram_arr = array_slice( $content_words,$j,$n );
			$ngram = implode( ' ',$ngram_arr );
			if( !isset( $tf_inv_index[$ngram] ) && empty( $tf_inv_index[$ngram] ) )
			{
				$tf_inv_index[$ngram] = array();
				$tf_inv_index[$ngram]['index'] = array();
			}
			$pos = strpos( $ngram_str,$ngram );
			//$match = array_search( $docid,array_column( $tf_inv_index[$ngram]['index'],'docid' ) );
			//if( !isset( $ngram_index[$ngram] ) && empty( $ngram_index[$ngram] ) )
			if( !$pos )
			{
				$ngram_count = substr_count( $file_content,$ngram );
				if( $n == 1 )
				{
					$ngram_count = $cnt_values[$ngram];
				}
				//$ngram_index[$ngram] = $ngram_count;
				$ngram_str = $ngram_str.':'.$ngram;
				/*if( $flag == 1 )
				{
					$final_output = $final_output."\r\n";
				}
				$op = $ngram.' '.$docid.' '.$ngram_count;
				$final_output = $final_output.$op;
				$flag = 1;*/
				$obj = array(
					'docid'	=>	$docid,
					'tf'	=>	$ngram_count
				);
				$tf_inv_index[$ngram]['index'][] = $obj;
			}
		}
	}
	unset( $ngram_str );
	unset( $cnt_values );
	$file_arr = array( 'inverted_index_unigram.txt','inverted_index_bigram.txt','inverted_index_trigram.txt' );
	/*$final_output = "";
	for( $i=0;$i<count( $tf_inv_index["Records"] );$i++ )
	{
		if( $i > 0 )
		{
			$final_output = $final_output."\r\n";
		}
		$term = $tf_inv_index["Records"][$i]["term"];
		$docid = $tf_inv_index["Records"][$i]["docid"];
		$tf = $tf_inv_index["Records"][$i]["tf"];
		$op = $term." ".$docid." ".$tf;
		$final_output = $final_output.$op;
	}*/
	$arr_index = $n-1;
	file_put_contents( $file_arr[$arr_index],json_encode( $tf_inv_index ) );
	//file_put_contents( $file_arr[$arr_index],$final_output );
	echo "Index Generated";
}
?>