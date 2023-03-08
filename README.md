# Single Pages (For all Sites you need an Webserver with PHP 7.0 or higher, Putty and an FTP Program)
# If something does not work Write me on Discord: DerMetelGamerYT#7084
 
## darkrp.php - Infos & Installation

Info:
With darkrp.php you can show the TOP 50 players with the most money via mysqloo

Install:
> First you need do download mysqloo(https://github.com/FredyH/MySQLOO)  
> Second you put the .dll in the garrysmod/lua/bin folder (If the bin folder doesn't exist, create it)  
> Third you create a database in e.g phpmyadmin named darkrp or something  
> Fourth you change the mysql login data in the .php file  

## mcloud - Infos & Installation

Info:
MCloud is a simple 1 file upload site where you can upload/download or delete files.
I wanted to save files somewhere to get them back later from other places to work on them. 
So inspiration I had Google-Drive but kept it short and simple with 100 lines.

Install:
> First download mcloud and drag it to the directory "/var/www/html".
> Then in the same folder of the php file create a folder called data
> Then give the data folder and the php file full permissions(777)
> Then open in Putty with e.g. nano the following: nano /etc/apache2/sites-available/auth-basic.conf and paste the following lines into the file and save:

```bash
<Directory /var/www/html/youfolderwheremcloudisinside>
    AuthType Basic
    AuthName "Basic Authentication"
    AuthUserFile /etc/apache2/.htpasswd
    require valid-user
</Directory>```

> Then activate Auth-Basic with the following command: a2ensite auth-basic
> Restart Apache2 with ```bash systemctl restart apache2```
> Create a user with password for basic auth with: ```bash htpasswd -c /etc/apache2/.htpasswd yourusername``
> An Restart Apache2 again.
> Done, now only those who have the password and the user you created will have access to the files.
