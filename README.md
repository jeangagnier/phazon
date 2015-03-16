# Unflare - Untorch clone

Untorch referral tool open-source clone based on Laravel (PHP) & Bootstrap3.  
Screenshots: [Landing Page](https://github.com/younes0/unflare/blob/master/data/docs/unflare-step1.png), [Form submitted](https://github.com/younes0/unflare/blob/master/data/docs/unflare-step2.png)

## Unflare vs Untorch 

Untorch's cost per referred email is $0.50. I'd say that's an **expensive CPA** (cost per action), especially when your product doesn't make money yet.

## Requirements

- a [Dedicated Server](http://www.kimsufi.com/us/en/) or a [VPS hosting](https://www.digitalocean.com/pricing/) or anything that allows you to setup the required services (PostgreSQL, Memcached, Node.js).
- a [Mandrill account](Mandrillapp.com) (free up to 12 000 emails per month) to send & track emails

## Do you need help to deploy?

Send me your request at <younes.elbiache@gmail.com>, I'd be glad to help you!

## Setup

- Setup apache/nginx conf and don't forget to specifiy an environment variable (PRODUCTION or DEVELOPEMENT): 

```shell
<VirtualHost *:80>
	ServerName www.unflare.com
	DocumentRoot "/www/unflr/public/"
	SetEnv ENVIRONMENT development

	<Directory "/www/unflr/public/">
		<IfModule mod_negotiation.c>
			Options -MultiViews
		</IfModule>

		Options +FollowSymLinks
		RewriteEngine On
		
		# Redirect Trailing Slashes...
		RewriteRule ^(.*)/$ /$1 [L,R=301]
		
		# Handle Front Controller...
		RewriteCond %{REQUEST_FILENAME} !-d
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteRule ^ index.php [L]
	</Directory>
</VirtualHost>
```

- Edit constants defined in the following files:
```shell
# postgresql, google analytics params etc.
config\constants.development.php
config\constants.production.php
# smtp, mandrill
config\constants.all.php
# marketing params
config\unflr.php 
```

- Dependencies
```shell
php unflr\application\config\composer install
cd unflr\assets\grunt\ 
npm install -g grunt && npm install && grunt
```

- Create new database and execute table creations with `data\unflr_schema.sql`

- Troubleshoots? Please refer to <http://laravel.com/docs/4.2/installation>

## Personalize Views

All pages & emails views are stored in `unflr\application\` and use the Blade templating system and Gettext. You can change the copywriting by editing PO files stored in `lang`. 

According to Springsheld explanations video, it is advised to keep the same layout structure and copywriting length.

## Other

- Logo by logoinstant: http://www.logoinstant.com/modern-flow-logo/
- TODO:
	* make facebook sharing optional
	* decouple from Memcached
