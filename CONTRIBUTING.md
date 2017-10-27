Contribute
==========

Communicate
-----------

Before you start implementing new features or fixing any issue, please create an issue about it first and discuss your intent.

It might be something that someone else is already implementing or that goes against the concepts of Dropzone, and I really hate rejecting pull requests others spent hours writing on.

Installtion
-----------

We use [Webuilder](https://github.com/jeyserver/webuilder) as frame-work for this project.also [NPM](https://github.com/yeganemehr/npm) and [WebPack](https://github.com/yeganemehr/webpack) used for front-end assets management.

## Webuilder installtion

It's really easy.follow these 3 steps:

### Get latest version

You can always get latest version from It's repository [by zip](https://github.com/jeyserver/webuilder/archive/master.zip) or simply clone It:
```
git clone https://github.com/jeyserver/webuilder.git
```
### Create Database

If you want to install this project on your localhost create a new database with PhpMyAdmin otherwise you should create one in your hosting control panel.

Then run these commands to create require tables:

```sql
CREATE TABLE `base_cache` (
	`name` varchar(255) NOT NULL,
	`value` text NOT NULL,
	`expire_at` int(10) unsigned NOT NULL,
	PRIMARY KEY (`name`),
	KEY `expire_at` (`expire_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `base_processes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
	`pid` int(11) DEFAULT NULL,
	`start` int(11) DEFAULT NULL,
	`end` int(11) DEFAULT NULL,
	`parameters` text COLLATE utf8_persian_ci,
	`response` text COLLATE utf8_persian_ci,
	`progress` int(11) DEFAULT NULL,
	`status` tinyint(4) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

CREATE TABLE `options` (
	`name` varchar(255) NOT NULL,
	`value` text NOT NULL,
	`autoload` tinyint(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `options` (`name`, `value`, `autoload`) VALUES
('packages.base.routing.www', 'nowww', 1),
('packages.base.routing.scheme', 'http', 1);
```

### Configuration

edit `packages/base/libraries/config/config.php` by your favorite text editor and put your database connection info in `packages.base.loader.db` section.For example:

```php
<?php
namespace packages\base;
$options = array(
	'packages.base.loader.db' => array(
		'type' => 'mysql',
		'host' => '127.0.0.1',
		'user' => 'root',
		'pass' => 'yeganemehr',
		'dbname' => 'php5to7'
	)
...
```

## Install Project

Now It's time to install this project on framework.Clone Its [git repository](https://github.com/yeganemehr/php5to7) into `packages` directory:

```
git clone https://github.com/yeganemehr/php5to7.git
```

## Install Dependencies

[NPM](https://github.com/yeganemehr/npm) and [Webpack](https://github.com/yeganemehr/webpack) are required for front-end assets compiling.We are going to clone them into `packages` directory too.You can download them by zip and extract them on this directory, of course.

```
git clone https://github.com/yeganemehr/npm.git
git clone https://github.com/yeganemehr/webpack.git
```
For download [NPM](https://www.npmjs.com/) packages and compiling them by [webpack](http://webpack.js.org/) go back to root directory and run this command:

```
php index.php --process=packages/webpack/processes/webpack@run
```

Wait until It's done. depend on internet quality and number of CPU's cores, It might be long.

Also we use [PhpParser](https://github.com/yeganemehr/PhpParser) for parsing and analyzing php codes which forked from [niki/PHP-parser](https://github.com/nikic/PHP-Parser).

```
git clone https://github.com/yeganemehr/PhpParser.git
```

## Project Structer

All of the project placed on `packages` directory of [Webuilder](https://github.com/jeyserver/webuilder) frame-work.

[**package.json**](/package.json): define package for framework also capable of storing static data for runtime.

[**routing.json**](/routing.json): Holds routering rules for http requests.

[**autoloader.json**](/autoloader.json): Define a map which help to locate classes on files.

[**controllers**](/controllers) directory: Keep controllers for handle request from router and pass data to views.

[**views**](/views) directory: Keep abstract views which used by controllers to connact with frontend views.

[**library**](/library) directory: Data models are saved in this directory.

[**processes**](/processes) directory: Include the processes which run in CLI.

[**frontend**](/frontend) directory: Include the processes which run in CLI.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[**theme.json**](/frontend/theme.json): Define a frontend source and Its views to framework.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[**autoloader.json**](/frontend/autoloader.json): Define a map which help to locate classes on files.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[**package.json**](/frontend/package.json): Define NPM dependencies which can be installed by yarn or npm itself.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[**tsconfig.json**](/frontend/tsconfig.json): Holds typescript basic configration.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[**assets**](/frontend/assets) directory: Keep static files like less stylesheets, typescripts, etc.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[**html**](/frontend/html) directory: Keep html files.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[**libraries**](/frontend/libraries) directory: keep needed classes and functions.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[**views**](/frontend/views) directory: There is a view for each back-end-view in this directory to brings flexibility to programmer.

## Apply changes

After create a [new issue on github](https://github.com/yeganemehr/php5to7/issues/new) to inform us about your intent, [fork the repository](https://github.com/yeganemehr/php5to7/fork) and then commit your changes on it.finally you'll send a PR for us and we will check it out.Please consider these terms:

* Make your commits as tiny as possible and avoid big commits which includes change on many files.
* Write your commit's titles in english and describe your commit blow it.
* Please refer to related issues.
* Please write unit tests for new features.






