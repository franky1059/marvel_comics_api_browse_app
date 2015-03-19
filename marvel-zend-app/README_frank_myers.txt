
Here's my code for the example assignment.  Deploy it live any zend framework app and it'll work.  A live version of it is located here - http://marvel.frank-myers.com/marvel.  

One issue I noticed is that the digital comics marvel api call never seems to return more than 20 records.  I made a script to demonstrate this problem here - http://www.frank-myers.com/marvel/poc/find_comics_count_20.php - it matches all characters that have more than 19 returned digital comics.  But as you can see all the matches max out at 20  This is a problem because it prevents accurate pagination. 



LIVE VERSION
Live version of this code is here - http://marvel.frank-myers.com/marvel


HOST CONFIGURATION
To configure hosting for this code you need to setup a Virtual Host to the zend public folder.  An example setup is below...

<VirtualHost *:80>
	ServerName marvel.frank-myers.com
	ServerAdmin frank@frank-myers.com

	CustomLog /var/log/httpd/marvel.frank-myers.com-access.log combined
	ErrorLog /var/log/httpd/marvel.frank-myers.com-error.log

	DocumentRoot /var/www/html/marvel/zend/marvel-zend-app/public
	<Directory /var/www/html/marvel/zend/marvel-zend-app/public>
		Options Indexes FollowSymLinks Includes ExecCGI
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
	</Directory>
</VirtualHost>


APPLICATION SPEC DETAILS
This archive contains all code to run a web application with the following specs:

-- SPECS START ----

Marvel Digital Coding Exercise
For this exercise, you will create a mini-site implementing two pages, listed below. Under each page are the requirements for that page. The data source for these pages will be a public API hosted at marvel.com.
Use of frameworks and libraries (jQuery for javascript, CakePHP/Zend/others for PHP) is encouraged but not required. 
Your submission should include all the PHP and JS code you created, and any framework or library files you developed against. The site does not have to be hosted on a public URL, but we will execute the code when reviewing it, so it should be debugged and tested. Please make sure to include any special instructions or configuration we may need to run the project along with your submission.
This exercise is not focused on visual design. It should be clear what information is being displayed, but there is no need to spend any time or effort making the page pretty.
-	Browse Menu
o	Display a list of the letters in the alphabet.
o	Upon click of a letter, initiate an AJAX call to the URL below to load a list of characters with names starting with the clicked letter. The URL for this request will be in the following format, where [LETTER] is the letter clicked: 
http://api.marvel.com/browse/characters?startsWith=[LETTER]&byType=digital-comics&limit=100 (Data is returned in JSON format.)
o	Provide the user with a list of links to the Digital Comics by Character page using the data in this list. This list should be populated client-side using javascript, without refreshing the page.
o	Upon click of name, load the “Digital Comics by Character” page, passing in id of the character.
-	Digital Comics by Chararacter
o	Use a server-side (not AJAX this time) HTTP call (such as php/cURL) to load a list of digital comics featuring character whose id was passed from the browse page. The URL for this request will be in the following format, where [CHARACTER_ID] is the id passed in from the Browse Menu page:
o	http://api.marvel.com/browse/digitalcomics/print?byType=character&byId=[CHARACTER_ID]&offset=0 (Again, data is returned in JSON format.)
o	NOTE that this request will return a large amount of data not relevant to your requirement. The relevant data is in the array at: data.results[]
o	Display a list of the digital comics featuring the character chosen on the Browse page. List items should contain:
	title
	id
	release_date
	issue_number: only if issue_number > 0
o	If more than 20 results are turned, display pagination elements
	Include links for “previous”, “next”, and numeric jump links to navigate paginated results
	Current page number should not be clickable. “previous” should not be clickable for first page, “next” should not be clickable for last page. 
	Results should paginate using AJAX, NOT a new page refresh. 
	To get paginated results, Use the same call to api.marvel.com as above. The offset parameter should be changed to reflect the number of the first item that should be returned in the list. E.G., for the third page of results, the offset is 40, since items 40-59 will be displayed: http://api.marvel.com/browse/digitalcomics/print?byType=character&byId=[CHARACTER_ID]&offset=40


--SPECS END --



