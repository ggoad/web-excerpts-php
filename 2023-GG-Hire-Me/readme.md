<h1>My Hire-Me Site!</h1>
<p> 
This project is actually complete, and the file structure has been 
adjusted to function in this isolated folder. You can copy this onto a PHP server, and then visit it.
I made this tool in about a day, and used it to develop ggHireMe.com, 
which is a search-engine-optimized SPA with over 100+ views.

</p> 
<h2>File List</h2>
<ul>
	<li><b>index.html</b>: The main application. It's rendered inline, to be portable.</li>
	<li><b>get.php</b>: An AJAX file to get the saved state of the form.</li>
	<li><b>save.php</b>: An AJAX file to save the state of the form.</li>
	<li><b>render.php</b>: This file fires the render operation. In pracitce it would have been filling out the page list of the ggHireMe project in the site generator.</li>
	<li><b>saved.json</b>: The saved state of the form.</li>
	<li><b>pageExample.json</b>: A template for a page in the site generator.</li>
	<li><b>appdatanew.json</b>: This is an adjusted file. The main save file for the site generator.</li>
	<li><b>js_core/rmfDevRender.js</b>: This is a generated file from dev environment of the API generator. 
	It's necessary because I used some of the static types defined in the RMF type system in the development of this form.
	I removed the types that were associated with tables... because it wouldn't be good to advertise every table I've made with the API (this is a development file).</li>
	<li><b>php_library (folder)</b>: A collection of supplemental utililties in PHP.</li>
</ul>
<h2>Known Performance Issues</h2>
<p>
	As the form grows in size, there becomes a noticable lag when the page is refreshed (while the form is being initialized). 
	For every item added to the form, a place is made in every other item for it to be indicated they are related, and a text area to add a small blurb describing the relation.
	So, if there are 100 different items (differnt jobs, projects, languages, project types, etc.), that's 100x100 (10,000) text areas.
	This by itself isn't the only issue. The main issue is that the text areas have event listeners connected to them that syncs its sister text area on change. 
	The sorce of the lag is the initialization of all of these listeners. 
	
</p>
<h3>The Fix</h3>
<p>
	The fix would be a single event listener on the body, 
	that checked event.target to see if it was one of the text areas. However,
	this would be an engineering task, because the listeners currently rely on closure in the family constructors.
	That, combined with the application already having served its purpose as a development tool, 
	leads me to leave it as it is, and if I want to add to it, I'll just wait for the form to initialize.
	
</p>
<h3>Truncated for the Demo</h3>
<p>
	I've trucated the size of the dataset in this demo to avert this performance issue. 
	You can add as much as you want, and it will remain responsive, 
	but if you save and reload, you may experience sluggishness on startup.
</p>
