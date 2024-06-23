<h1>Invoicing Software</h1>
<p>This software creates receipts and invoices and tracks customer balances. 
It also tracks business expenses and mileage, and all of it can be viewed as reports 
	within a timeframe.
The coolest part of this project is the instancing, which allows me to deploy this software 
onto various servers. I used templating for things like server-address and passwords.
</p>
<h2>File List</h2>
<ul>
	<li><b>basicLibrary.php</b>: </li>
	<li><b>mailReceipts.php</b>: </li>
	<li><b>MileageReportDetails.php</b>: </li>
	<li><b></b>: </li>
	<li><b></b>: </li>
	<li><b></b>: </li>
	<li><b>instancing (folder)</b>:
		Files for creating different instances of the application.
		<ul>
			<li><b>masterExport</b>: The master exporter. Renders a templated-file with passwords and other tokens left open.</li>
			
		</ul>
	</li>
</ul>
<h3>Retrospective</h3>
<p>
I experimented with chdir in this project, to achieve a pattern where all of the code 
was stored above the document root, and all of the public endpoints just had 
include('-secure-folder-/script-name.php'). Looking back, I don't like it. It was overboard.
</p>