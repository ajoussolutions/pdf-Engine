
PDF Template Management, Visual HTML Template Editor and API to render PDFS by json data

<h1>PDF ENGINE</h1>
<h5>VERSION: development: This is a prerelease version, feel free to play with it and to submit feature requests</h5>
<h3>Planned features until the first release:</h3>
<ul>
<li>User Management</li>
<li>Documentation</li>
<li>Installation guide</li>
<li>Dolibarr Connector</li>
</ul>

<h3>Short installation guide, for those who can't wait.</h3>
<ul>
  <li>1. Copy all the files to your web server.</li>
  <li>2. create a mysql database.</li>
<li>Now navigate to the pdfengine folder (where app, public, etc. are located) where you will find an .env file. In this file you have to adjust the following fields:<br>

DB_CONNECTION=mysql<br>
DB_HOST=127.0.0.1 <--- your database host (or localhost)<br>
DB_PORT=3306<br>
DB_DATABASE=pdfengine <--- database name<br>
DB_USERNAME=root <--- database user<br>
DB_PASSWORD= <--- database password<br>

Further, the following should be adjusted in the .env:<br>
APP_KEY= <--- Enter a base64 encryption key here.<br>
APP_URL=http://localhost <--- Enter the apphost here.<br>
  </li>
<li>Save the .env file and execute the following command in the terminal:<br>
  <strong>php artisan migrate</strong></li>

This command creates the necessary database tables.<br>
Now the PDF engine can already be used http://localhost/templates

