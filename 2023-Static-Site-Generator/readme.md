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
</ul>