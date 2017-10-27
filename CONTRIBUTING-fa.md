مشارکت
==========

ارتباطات
-----------
قبل از اینکه دست به کار شوید و هر مشکلی رو حل کنید یا یک قابلیت جدید به سامانه اضافه کنید، لطفا در مخزن پروژه یک موضوع ایجاد کنید.

ممکن است کاری که شما تمایل به انجام به آن دارید، توسط شخص دیگری در حال انجام می باشد یا ممکن است با استراژی های پروژه در تناقض باشد و ما واقعا متنفریم که با ساعت ها زحمات شما مخالفت کنیم!


نصب و راه اندازی
-----------
ما از [Webuilder](https://github.com/jeyserver/webuilder) به عنوان فریم-ورک این پروژه استفاده کردیم.همینطور از دو بسته دیگر [NPM](https://github.com/yeganemehr/npm) و [Webpack](https://github.com/yeganemehr/webpack) برای مدیریت فایل های قالب استفاده کردیم.

## نصب Webuilder

نصب Webuilder واقعا ساده است، فقط شامل سه مرحله است:

### آخرین نسخه رو دانلود کنید

آخرین نسخه این فریم-ورک رو میتونید همیشه از شاخه اصلی مخزنش دانلود کنید: [دانلود ZIP](https://github.com/jeyserver/webuilder/archive/master.zip)

یا اینکه مخزن رو بصورت کامل کلون کنید:

```
git clone https://github.com/jeyserver/webuilder.git
```

### یک دیتابیس بسازید

اگر پروژه رو بر روی رایانه شخصیتون راه اندازی میکنید، از طریق PHPMyAdmin یک دیتابیس جدید بسازید، یا در غیر اینصورت به پنل میزبانیتون مراجعه کنید.سپس دستورات زیر رو در پایگاه داده درون ریزی کنید:

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

### اتصال رو برقرار کنید

فایل `packages/base/libraries/config/config.php` رو با یک ویرایشگر متن باز کنید و در قسمت `packages.base.loader.db`مشخصات اتصال به دیتابیستون رو وارد کنید.برای مثال:

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

## نصب پروژه

حالا موقع اون شده که این پروژه رو به فریمورک اضافه کنیم!از طریق Git مخزن رو در شاخه `packages` کلون کنید:

```
git clone https://github.com/yeganemehr/php5to7.git
```

## نصب پیشنیاز ها

دو بسته [NPM](https://github.com/yeganemehr/npm) و [Webpack](https://github.com/yeganemehr/webpack) هم باید برای کامپایل فایل های قالب وب سایت باید نصب شوند.باز هم در شاخه `packages` این دو بسته را از مخزن اصلی کلون میکنیم، البته شما میتونید فایل های ZIP رو دانلود کنید و در اون مسیر استخراج کنید.

```
git clone https://github.com/yeganemehr/npm.git
git clone https://github.com/yeganemehr/webpack.git
```

حالا برای اینکه بسته های قالب از [مخزن Nodejs](https://www.npmjs.com/) دانلود شوند و فایل های قالب با استفاده از [WebPack](http://webpack.js.org/) کامپایل بشوند، به شاخه اصلی فریم-ورک برگردید و دستور زیر رو اجرا کنید.

```
php index.php --process=packages/webpack/processes/webpack@run
```

منتظر باشید تا این روند به پایان برسد و با توجه به سرعت اینترنت و تعداد هسته های پردازشگر این زمان ممکن است طولانی بشود.

همینطور ما از بسته [PhpParser](https://github.com/yeganemehr/PhpParser) هم برای تجزیه و تحلیل کد های php استفاده کردیم که اصالتا به مخزن [niki/PHP-Parser](https://github.com/nikic/PHP-Parser) تعلق دارد، ولی چون تحت مجوز MIT منتشر شده بود، با کمی تغییر به جمع بسته های Webuilder وارد شد!

```
git clone https://github.com/yeganemehr/PhpParser.git
```

ساختار پروژه
-----------

کل این پروژه در پوشه [`packages`](/packages) فریم-ورک [Webuilder](https://github.com/jeyserver/webuilder) جای میگیرذ.

[**`package.json`**](/package.json): این فایل هویت و پیشنیاز های یک بسته را برای فریم-ورک تعریف میکند.همینطور امکان ذخیره و دسترسی داده ها و تنظیمات بصورت ایستا در این فایل وجود دارد.

[**`routing.json`**](/routing.json): این فایل امکان مسیریابی درخواست HTTP را برای فریم-ورک فراهم میکند و اعلام میکند که هر آدرسی میبایست به کدام Controller راه یابد.

[**`autoloader.json`**](/autoloader.json): در این فایل مسیریابی کلاس های برنامه نویسی ذخیره میشود و فریم-ورک این قابلیت را فراهم میسازد تا برنامه نویس نیازی به صدا زدن فایل های منبع نداشته باشد.

شاخه [**`controllers`**](/controllers): با توجه به معماری MVC وب سایت پروژه، کنترلر ها در این مسیر قرار میگرند تا درخواست ها را از Router دریافت و مدیریت کنند.

شاخه [**`views`**](/views): کنترلر از این کلاس های این شاخه استفاده میکنند تا یک View را صدا بزنند و از طریق آن ها با قالب ارتباط قرار کنند.

شاخه [**`library`**](/library): در این شاخه، Model ها و سایر کد هایی که در روند پردازش کد ها باید استفاده شود را ذخیره میکنیم.

شاخه [**`processes`**](/processes): شامل روند هایی هستند که از طریق رابط خط-فرمان (CLI) قابلیت اجرا شدن دارند.

شاخه [**`frontend`**](/frontend):

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[**`theme.json`**](/frontend/theme.json): هویت یک قالب را برای فریم-ورک را به همراه نحوه ارتباط View های بسته با View های قالب را معرفی میکند.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[**`autoloader.json`**](/frontend/autoloader.json): در این فایل مسیریابی کلاس های برنامه نویسی ذخیره میشود و فریم-ورک این قابلیت را فراهم میسازد تا برنامه نویس نیازی به صدا زدن فایل های منبع نداشته باشد.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[**`package.json`**](/frontend/package.json): بسته های نرم افزاری Nodejs را معرفی میکند و به شما اجازه میدهد تا درصورتی که تمایل داشتید خودتان و فارغ از بسته NPM آن ها را نصب کنید.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[**`tsconfig.json`**](/frontend/tsconfig.json): تنظیمات پایه مربوط به مترجم Typescript را در خود نگهداری میکند.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;شاخه [**`assets`**](/frontend/assets): فایل های ایستا مانند تصاویر، Less و یا TS در این شاخه نگهداری میشوند.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;شاخه [**`html`**](/frontend/html): فایل هایی که شامل کد های نهایی HTML هستند در این شاخه نگهداری میشوند.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;شاخه [**`libraries`**](/frontend/libraries): برنامه و کد هایی که در حین اجرای قالب لازم به فراخوانی هستند در این شاخه ذخیره میشوند.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;شاخه [**`views`**](/frontend/views): به ازای هر View از بسته اصلی، یک View دیگر در این شاخه ذخیره میشود تا به برنامه نویس و پروژه انعطاف پذیری بیشتر بدهد.

انجام تغییرات
----------

پس اینکه از طریق Github [به ما اطلاع دادید](#ارتباطات) که قصد چه تغییراتی را در پروژه دارید، از مخزن اصلی [یک انشعاب](https://github.com/yeganemehr/php5to7/fork) به نام خودتان بسازید.سپس تغییراتتان را در مخزن جدیدتان ارسال کنید و در نهایت تغییرات را به عنوان یک Pull-Request برای ما ارسال کنید.لطفا موارد زیر را در حین کارتان در نظر بگیرید:

*   Commit هایتان را در حد ممکن کوچک ثبت کنید و از ارسال Commit هایی که شامل تعداد زیادی تغییر در فایل های مختلف هستند پرهیز کنید.

*   در توضیحات Commit و Pull-request خود به موضوعی که از قبل ایجاد کردید، اشاره کنید.
*   برای قابلیت های جدید، لطفا تست های واحد ارائه کنید.