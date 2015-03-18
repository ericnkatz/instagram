# instagram

## installation

requires composer, to install composer globally:
```Shell 
curl -sS https://getcomposer.org/installer | php 
mv composer.phar /usr/local/bin/composer
```

to install application run:
```Shell 
composer install
```
this will install additional project packages in a vendor folder as well as create the *autoload.php* that is included in the *index.php*

## running
navigate to your project directory in terminal and type:
````Shell
php -S localhost:1234
`````
this will run a php webserver in your directory that you can then navigate to http://localhost:1234 to see the 404 page for this application.
currently the only functionality is when you hit [http://localhost:1234/tag/**cbus**](http://localhost:1234/tag/cbus) you should see it return formatted json of instagram images with the hashtag **cbus**, the application currently accepts any hashtag in the route so feel free to visit as many as you like. The app will cache any pages using doctrine's file cache driver for 5 seconds


## deployment
to run in php 5.4 web host, after running ````composer install```` copy all files in project directory to your webhost and navigate to the directory or index.php or domain if in root of domain directory.
Live preview of this application is visible [here](http://instagram.katz.ninja/tag/civichacks).

## gotchas
if you run into an issue warning you to set a default php timezone you can do this by editing your */etc/php.ini.default* 
````date.timezone = America/New_York```` or by adding : ````date_default_timezone_set('America/New_York');```` to the top of your *index.php* file, related issue: https://github.com/slimphp/Slim-Skeleton/issues/14
