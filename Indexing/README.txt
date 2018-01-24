Assignment 2:
Goal: Implementing your own inverted index. Text processing and corpus statistics.

####################################################################################################

	TASK1: 	Generating the corpus

	Generating	the	corpus: In this task you will be using the raw Wikipedia articles that you
	downloaded in HW1 Task 1 to generate the clean corpus following the instructions below:
	1-  Parse and tokenize each article and generate a text file per article that	contains
		only the title(s) and plain textual content of the article. Ignore/remove ALL markup
		notation (HTML tags), URLs, references to images, tables, formulas, and	navigational
		components.	
	2-  Each text file will correspond to one Wikipedia article. The file name is the same
		as the article title, e.g. http://en.wikipedia.org/wiki/Green_Energy -> Green_Energy.txt
		(file	names	must	be	unique).
	3-  Your parser should provide options for case-folding and punctuation handling.
        The default setup should perform both. The punctuation handler is expected to remove
        punctuation from text but preserve hyphens, and retain punctuation within	digits
        (mainly	“,”, “.”, and any other symbols	you	deem necessary).

####################################################################################################
    TASK2:: Implementing an inverted indexer and creating inverted indexes:


    Implementing an inverted indexer and creating inverted indexes:
 	Implement a simple inverted indexer	that consumes the corpus in	Task 1 as input	
	and	produces an inverted index as an output.
		- Term frequencies (tf) are stored in inverted lists:
		TERM -> (docID,	tf), (docID, tf),...
	
	Important: See TERM	definition below
		- For this assignment, you don't need to consider term positions within	documents.	
		- Store	the	number	of	tokens	in	each	document	in	a	separate	data	structure.	
		- You may employ any concrete data structures convenient for the programming language
		  you are using, as	long as	you	can	write them to disk and read	them back in when you
		  want to run some queries.	
		TERM is	defined as a word n-gram, and n	= 1, 2, and	3. Therefore,you will have three
		inverted indexes, one for each value of	n.

####################################################################################################
	TASK 3:	Corpus	statistics:

		1- For each	inverted index in Task 2, generate a term frequency	table comprising 
		   of two columns: term and	tf.	Sort from most to least	frequent 
		2- For each	inverted index in Task 2, generate a document frequency	table 
		   comprising of three columns:	term, docID, and df. Sort lexicographically	based
		   on term. Therefore you will generate	six	tables in total: Two tables	for	singleword
		   terms (word	unigrams), two	tables	for	word choice	and	comment	on	the	stoplist content.	

####################################################################################################

-- Installation for Windows:
	Step1: Download Install Xampp 7.1.9 from www.apachefriends.org
	Step2: Extract all the files from zip and place ALL the files from the folder "~\Assignment-3\" 
	inside "C:\xampp\php\"

####################################################################################################
-- INSTRUCTIONS TO RUN THE PROGRAM:

	Step 1: Now press Start button and run command Prompt and navigate to "C:\xampp\php" folder 
	inside cmd prompt.
	Step 2: Put all the raw text files having the downloaded web pages inside the folder 'saved'. 
			The downloaded web pages are already provided in the same folder. 
	Step 3: Run hw3_task1.php to generate the corpus inside the folder 'corpus' which will be 
	 		inside the 'saved' folder.
	Step 4: Run hw3_task2.php to generate the uni-gram or bi-gram or tri-gram by using the following
			command line arguement

			Example : for Unigram, type: php hw3_task2.php 1
					  for Bigram, type: php hw3_task2.php 2
					  for Trigram, type: php hw3_task2.php 3

		 	Expected Output:
					  inverted_index_unigram.txt
					  inverted_index_bigram.txt
					  inverted_index_trigram.txt

	Step 5: Run hw3_task3_1.php for generating the term frequency again with the help of command 
	 		line arguement.

	 		Example : for Unigram, type: php hw3_task3_1.php 1
					  for Bigram, type: php hw3_task3_1.php 2
					  for Trigram, type: php hw3_task3_1.php 3

			Expected Output:
					term_freq_unigram.txt
					term_freq_bigram.txt
					term_freq_trigram.txt

	Step 6: Run hw3_task3_2.php for generating the document frequency again with the help of command 
	 		line arguement.

	 		Example : for Unigram, type: php hw3_task3_2.php 1
					  for Bigram, type: php hw3_task3_2.php 2
					  for Trigram, type: php hw3_task3_2.php 3

			Expected Output:
					doc_freq_unigram.txt
					doc_freq_bigram.txt 
					doc_freq_trigram.txt


FILES HANDED IN: 
		>Source code for all the tasks
		>Readme file
		>Output files of Task2
		>Output files of Task3
		>Stoplist and explanation from Task3





