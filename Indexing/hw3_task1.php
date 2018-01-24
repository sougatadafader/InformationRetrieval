<?php
ini_set('memory_limit', '2048M');
include 'simple_html_dom.php';
$files = glob( "saved/*.html" );
for( $i=0;$i<count( $files );$i++ )
{
	$file = $files[$i];
	$content = file_get_contents( $file );
	echo "Processing file ".$file."\n";
	$dom = str_get_html( $content );
	if( !$dom )
	{
		continue;
	}
	//if( isset( $dom->find( 'table,ul,ol' ) ) && !empty( $dom->find( 'table,ul,ol' ) ) )
	//{
		foreach( $dom->find( 'table,ul,ol' ) as $table )
		{
			$table->outertext = '';
		}
		$dom->load( $dom->save() );
	//}
	//if( isset( $dom->find( '#toc' ) ) && !empty( $dom->find( '#toc' ) ) )
	//{
		$toc = $dom->find( '#toc',0 );
		$toc->outertext = '';
		$dom->load( $dom->save() );
	//}
	foreach( $dom->find( '.mw-parser-output div' ) as $div )
	{
		$div->outertext = '';
	}
	$dom->load( $dom->save() );
	foreach( $dom->find( 'span.mwe-math-element' ) as $math )
	{
		$math->outertext = '';
	}
	$dom->load( $dom->save() );
	$content_dom = $dom->find( '.mw-parser-output',0 );
	$stripped_content = $content_dom->plaintext;
	$clean_content = preg_replace("/[^a-zA-Z0-9\/\s.,-]/", '', $stripped_content);
	$re = '/(?<!\d)[.,](?!\d)/';
	$subst = '';
	$final_content = preg_replace( $re, $subst, $clean_content );
	$final_content = trim( preg_replace( '/\s+/', ' ', $final_content ) );
	$corpus_file_name = str_replace( '.html','.txt',$file );
	$corpus_file_name = str_replace( 'saved/','saved/corpus/',$corpus_file_name );
	file_put_contents( $corpus_file_name,$final_content );
}
echo "Corpus Generated...";
?>