# Blunderbuss
A small utility for sending out dummy emails.

## Installation
This package requires the following:
* Apache webserver 2.4 or greater
* PHP 7.0 or greater
* Composer 1.0 or greater
* A connection to the internet

Once you have these prerequisites met, the rest is fairly easy. Clone the repository to a location of your choice. Then execute 
`composer install`
to download and install dependent packages. (Feel free to ignore any dependency recommendations.) After `composer` is finished, you'll need to configure Apache to host the index script for this repo. Here's a simple Apache config that can be used:
```
<VirtualHost *:80>
    DocumentRoot /path/to/Blunderbuss
    ErrorLog ${APACHE_LOG_DIR}/blunderbuss_error.log
    CustomLog ${APACHE_LOG_DIR}/blunderbuss_access.log combined
</VirtualHost>
```

Alternatively if you already have a document root you can create an alias.
```
<IfModule alias_module>
    Alias /blunderbuss/ "/path/to/Blunderbuss/"
</IfModule>
```

This assumes you've configured Apache to handle PHP. Make sure you do that. 


## Usage
Load up the Blunderbuss form using your web browser. Supply the relay mail server host (and a username/password if applicable). If you need to use a separate port for your mail server, put it after the host name/IP, separated by a colon (e.g. `smtp.gmail.com:587`). 

Edit the JSON data to provide your message template, default replacement fields, and recipient list. Then click send. Assuming everything works, you'll receive a report showing recipients and response codes from the relay mail server.

