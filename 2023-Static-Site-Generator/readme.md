<h1>The Static Site Generator</h1>
<p>
This is the cleanest code I've made in my personal code base. 
They are generation-files and are meant to generate secure code.
Some of the files are dev-files and are not meant to be secure. 
I'm also including examples of the secure files that they generate.
</p>
<h2>File List</h2>
<ul>
	<li><b>Generator Dev Files</b>:
		<ul>
			<li><b>projectLibrary.php</b>: 
				This file contains the main bread-and-butter for the site generator. 
				It's a pretty large file, that maybe could be split into a couple of files. 
				However, the longes function is the main rendering function, and that process is just a long process.</li>
			<li><b>adminRenderers.php</b>: 
				This file has the meat-and-potatoes of the admin renderer. 
				The project library calls these functions at the end of the rendering funciton. </li>
			<li><b>compressExport.php</b>:
				Compresses the exported files.</li>
			<li><b>removeCompression.php</b>:
				Removes the compression of an export</li>
			<li><b>htmlRenderFunctions.php</b>:
				Various functions to aid in the generation of HTML</li>
			<li><b>lessSupplement.php</b>:
				Various functions to aid in using the LESS.php library.</li>
			<li><b>saveProject.php</b>:
				Saves the form-state project</li>
		</ul>
	</li>
	<li><b>Secure Rendered Files</b>:
		These files are rendered for public consumption. 
		They are meant to be secure.
		Some information is redacted: such as the name of the folder I store outside of the document root.
		Changing this name is trivial, but I would have to re-render everything... it was just as easy just to redact with 'grep w/ sed'.
		I've eliminated some of the organizational structure of the folders, and these should be treated as excerpt-examples.
			<ul>
				
				<li><b>blog-news.php</b>: AJAX file for getting the most recent blog news stories. It may seem strange for 'blog-news' to be hard-coded in this file, but that is a side-effect of the meta-programming process, and dynamic sections like this are generalized to all dynamic sections.</li>
				<li><b>Contact.php</b>: AJAX file to submit a contact form.</li>
				<li><b>Admin (Folder)</b>: Various files for admin functionality
					<ul>
						<li><b>archiveSubmission.php</b>: Archives contact form submissions.</li>
						<li><b>getFormList.php</b>: Gets a list of contact forms </li>
						<li><b>getList.php</b>: Gets a list of contact form submissions. </li>
						<li><b>publishArticle.php</b>: Publishes a blog post</li>
						<li><b>saveArticleInfo.php</b>: Saves a blog post (as draft or live).</li>
						<li><b>saveCategories.php</b>: Saves a list of blog categories.</li>
					</ul>
				</li>
				<li><b>Sec-Lib (folder outside document root)</b>: A folder of files that are stored outside of the document root
					<ul>
						<li><b>adminLibrary.php</b>: From the blog render. Coantains function for overwriting the live article. </li>
						<li><b>onlySuper.php</b>: PHP to secure endpoints to only super admins.</li>
						<li><b>ajaxOnlySuper.php</b>: PHP to secure an ajax enpoint only to super admins</li>
						<li><b>dynamicSectionDefinitions.php</b>: Rendered file that contains the definition of all the dynamic sections (including blog-news).</li>
						<li><b>lib.php</b>: An example of rendered prepared statements. Concatins a function for adding extended information to an blog article result.</li>
						<li><b>lib-contact.php</b>: Rendered files that contains the functions to encrypt and decript the information going into the db for the contact form (with redactions).</li>
						<li><b>lib-RMF.php</b>: An example of the PHP library rendered by the API generator that targets SQLite.</li>
					</ul>
				</li>
			</ul>
	</li>
</ul>