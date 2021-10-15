## Running project locally
1. Copy all files to your web servers root directory
2. Create mysql database and table. Command for creating the table:
```
CREATE TABLE subscriptions (id INT NOT NULL AUTO_INCREMENT, 
       email VARCHAR(40),
	   subscribe_date DATE,
	   PRIMARY KEY( id )
);
```
3. Fill in information for connecting to mysql server in "/classes/dbh.class.php (host, username, password and name of the database you created).

4. After some subscriptions are created they can be found on http://localhost/subscriptions.php page (Host name may vary depending on your setup).
 