The tasks are discussed below in brief:



-- Task1: Obtaining directed web graphs
		A. BFS Graph: Build a graph for the 1000 URLs that we have crawled in HW1-Task1 'G1.txt'
		B. DFS Graph: Build a graph of 1000 URLs crawled using DFS algorithm 'G2.txt'

-- Task2: Implementing and running PageRank 
		A. Implementation of the PageRank algorithm using the pseudo code provided. 
		B. Execution of the iterative version of the PageRank algorithms on the two 
		   above-mentioned graphs respectively until their PageRank values "converge".
 
-- Task3: Qualitative Analysis 
		Examination of the top 10 pages by PageRank and Top 10 by in-link counts for the above-mentioned graphs.
		Detailed speculation regarding why these pages have high PageRank values.
===============================================================================================================================================================
-- Installation for Windows:
	Step1: Download Install Xampp 7.1.9 from www.apachefriends.org
	Step2: Extract all the files from zip and place ALL the files from the folder "~\Assignment-2\Task-1" inside "C:\xampp\php\"

===============================================================================================================================================================
-- INSTRUCTIONS TO RUN THE PROGRAM:

	Step1: Now press Start button and run command Prompt and navigate to "C:\xampp\php" folder inside cmd prompt.
	Step2: To execute pagerank algorithm for G1 graph, type : php.exe pagerank_G1.php
	Step3: To execute pagerank algorithm for G2 graph, type : php.exe pagerank_G2.php

===============================================================================================================================================================
-- DESIRED RESULTS:

   -- The program prints in the console the following things in order:
	1. The perplexity values for each iteration
	2. The top 50 pages by their DOC ID and PageRank Score for the graph provided
	3. The top 10 pages as per their in-link counts for the graph provided
	4. Overall statistics for the graph displaying the total number of pages, total number of sinks and total number of sources for 
	the input graph.

