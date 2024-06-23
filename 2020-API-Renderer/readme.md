<h1>API Generator</h1>
<p>There are a lot of things I would change about this program, now that I'm older. But I'm still very proud that it works and solves the problem that it solves. It renders APIs targeting RMF.js on the front end, PHP on the backend, and MySQL or SQlite for the DB.</p>
<h2>File List</h2>
<ul>
	<li><b>add.php</b> An example of the actual file that meta codes the 'add' stored procedure.</li>
	<li><b>macroRenderHelpers.php</b>: A library of functions to aid in the rendering of the API procedures.</li>
	<li><b>exampleProcedure.sql</b>: Here is an example of an add procedure</li>
	<li><b>addTable.php</b>: The script for creating a table with the abstract types connected to the columns.</li>
	<li><b>dbCredz.php</b>: Not really credentials (I am more careful now about naming). A variety of helper functions.</li>
	<li><b>edittype_tableReference.php</b>: Edits the type signature of a table in the static type system.</li>
	<li><b>actionProcedureCreators.php</b>: Helpers for rendering the actual API endpoints. </li>
</ul>