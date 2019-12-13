- Entries API

<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule api/(. * )$ index.php?request=$1 [QSA,NC,L]
</IfModule>

- Means any url that has a slug of ....com/api/entries should run the index.php file and pass the query string
- We may change the begining to just api\$, but let's wait

- This will open index.php and check to make sure the correct method and arguemnts are passed.
- It will then perform a query.

- You will need to add the database config values in index.php where the mysql connection is made.
