<!DOCTYPE html>
<html>
<head></head>
<body>
<h2>Project List</h2>
<ul>
<li><b>Static Site Generator (2023)</b>: A program that takes a very large and complex form, and passes the result to a script that renders out an operational file-cluster that is the whole website.</li>
<li><b>GGHire Me Site Form (2023)</b>: This program was a complex form that took information about my experience and allowed me to tie everything together via a GUI. Then, the result is passed to a script that fills out the form in the site generator, to be rendered and then published.</li>
<li><b>Incvoice to Inbox (2022)</b>: Invoicing software. </li>
<li><b>API Renderer (2019-2020)</b>: A program that automatically renders an interface for a database. There is a static type system that defines type information from over
the front end, the backend and the database, and the program uses a table editor to tie that type information to columns. Then, there is a configuration editor
that lets you select the type of function you want to generate and for what columns, and it generates code as to your specifications. You can target MySQL stored procedures,
or PHP regular expressions for SQLite or MySQL. The front end it targets is a custom library called RMF.js</li>
</ul>
<h1>Real Proof</h1>
<p>
Before this repository, my GitHub had very little PHP on it... yet, I've written over 100 thousand lines of it! This repository is an attempt to fix that. 
</p>
<p>
I can't share the vast majority of the work I've done for other people (for obvious reasons), but I can share is code out of my own codebase. 
When reading these excerpts, please be conscious that they were coded in the context of a solo developer, and are lacking things like comments, and name-spacing. 
When working with others, my coding style is different: being <b>considerate of my peers and future developers</b> is important to me. 
</p>
<p>
Most of the PHP written in my personal code base is functional. 
I have written some OO PHP in other projects, and there are some classes on my GitHub to demonstrate that.
</p>
<p>
Also, some of these are dev tools only (input generated by a trusted user: myself)... 
Some of the security in these files (like prepared statements) would be inappropriate for public-facing production.
A lot of the meta-programming, like the creation of tables, could not be accomplished with prepared statements (I ran into the limits of MySQL). 
</p>
<h2>Lastly</h2>
<p>
Lastly, I realize a technical manager may would want to see more of the architecture of how some of these excerpts would work together...
However, please understand that this is my life's work, and I'm not totally comfortable of just giving every bit of it away.
Also, it could very well be a security issue to just give all of the structure away like that: 
it would take carful consideration and a considerable amount of time to clear it for that.
</p>
</body>
</html>