<?php
use \packages\base;
$this->the_header();
?>
<div class="page-container doc-container">
	<nav class="side-menu">
		<h6 class="title">مشارکت</h6>
		<a href="#ارتباطات">ارتباطات</a>
		<a href="#نصب-راه-اندازی">نصب و راه اندازی</a>
		<a href="#ساختار-پروژه">ساختار پروژه</a>
		<a href="#انجام-تغییرات">انجام تغییرات</a>
	</nav>

	<div class="page-content">
		
		<h1 id="ارتباطات" class="deep-link"><a href="#ارتباطات">ارتباطات</a></h1>
		<p>قبل از اینکه دست به کار شوید و هر مشکلی رو حل کنید یا یک قابلیت جدید به سامانه اضافه کنید، لطفا در <a href="https://github.com/yeganemehr/php5to7">مخزن پروژه</a> یک <a href="https://github.com/yeganemehr/php5to7/issues/new">موضوع ایجاد کنید</a>.</p>
		<p>ممکن است کاری که شما تمایل به انجام به آن دارید، توسط شخص دیگری در حال انجام می باشد یا ممکن است با استراژی های پروژه در تناقض باشد و ما واقعا متنفریم که با ساعت ها زحمات شما مخالفت کنیم!</p>
		<h1 id="نصب-راه-اندازی" class="deep-link"><a href="#نصب-راه-اندازی">نصب و راه اندازی</a></h1>
		<p>ما از <a href="https://github.com/jeyserver/webuilder">Webuilder</a> به عنوان فریم-ورک این پروژه استفاده کردیم.همینطور از دو بسته دیگر <a href="https://github.com/yeganemehr/npm">NPM</a> و <a href="https://github.com/yeganemehr/webpack">Webpack</a> برای مدیریت فایل های قالب استفاده کردیم.</p>
		<h2>نصب Webuilder</h2>
		<p>نصب Webuilder واقعا ساده است، فقط شامل سه مرحله است:</p>
		<h3>آخرین نسخه رو دانلود کنید</h3>
		<p>آخرین نسخه این فریم-ورک رو میتونید همیشه از شاخه اصلی مخزنش دانلود کنید: <a href="https://github.com/jeyserver/webuilder/archive/master.zip">دانلود ZIP</a>
		<p>یا اینکه مخزن رو بصورت کامل کلون کنید:</p>
		<pre>git clone https://github.com/jeyserver/webuilder.git</pre>
		<h3>یک دیتابیس بسازید</h3>
		<p>اگر پروژه رو بر روی رایانه شخصیتون راه اندازی میکنید، از طریق PHPMyAdmin یک دیتابیس جدید بسازید، یا در غیر اینصورت به پنل میزبانیتون مراجعه کنید.سپس دستورات زیر رو در پایگاه داده درون ریزی کنید:</p>
		<pre>CREATE TABLE `base_cache` (
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
</pre>
		<h3>اتصال رو برقرار کنید</h3>
		<p>فایل <code>packages/base/libraries/config/config.php</code> رو با یک ویرایشگر متن باز کنید و در قسمت <code>packages.base.loader.db</code>مشخصات اتصال به دیتابیستون رو وارد کنید.برای مثال:</p>
		<pre>&lt;?php
namespace packages\base;
$options = array(
	'packages.base.loader.db' => array(
		'type' => 'mysql',
		'host' => '127.0.0.1',
		'user' => 'root',
		'pass' => 'yeganemehr',
		'dbname' => 'php5to7'
	)
...</pre>
		<h2>نصب پروژه</h2>
		<p>حالا موقع اون شده که این پروژه رو به فریمورک اضافه کنیم!از طریق Git مخزن رو در شاخه <code>packages</code> کلون کنید:</p>
		<pre>git clone https://github.com/yeganemehr/php5to7.git</pre>
		<h2>نصب پیشنیاز ها</h2>
		<p>دو بسته <a href="https://github.com/yeganemehr/npm">NPM</a> و <a href="https://github.com/yeganemehr/webpack">Webpack</a> هم باید برای کامپایل فایل های قالب وب سایت باید نصب شوند.باز هم در شاخه <code>packages</code> این دو بسته را از مخزن اصلی کلون میکنیم، البته شما میتونید فایل های ZIP رو دانلود کنید و در اون مسیر استخراج کنید.</p>
		<pre>git clone https://github.com/yeganemehr/npm.git
git clone https://github.com/yeganemehr/webpack.git</pre>
		<p>حالا برای اینکه بسته های قالب از <a href="https://www.npmjs.com/">مخزن Nodejs</a> دانلود شوند و فایل های قالب با استفاده از <a href="http://webpack.js.org/">WebPack</a> کامپایل بشوند، به شاخه اصلی فریم-ورک برگردید و دستور زیر رو اجرا کنید.</p>
		<pre>php index.php --process=packages/webpack/processes/webpack@run</pre>
		<p>منتظر باشید تا این روند به پایان برسد و با توجه به سرعت اینترنت و تعداد هسته های پردازشگر این زمان ممکن است طولانی بشود.</p>
		<p>همینطور ما از بسته <a href="https://github.com/yeganemehr/PhpParser">PhpParser</a> هم برای تجزیه و تحلیل کد های php استفاده کردیم که اصالتا به مخزن <a href="https://github.com/nikic/PHP-Parser">niki/PHP-Parser</a> تعلق دارد، ولی چون تحت مجوز MIT منتشر شده بود، با کمی تغییر به جمع بسته های Webuilder وارد شد!</p>
		<pre>git clone https://github.com/yeganemehr/PhpParser.git</pre>
		<h1 id="ساختار-پروژه" class="deep-link"><a href="#ساختار-پروژه">ساختار پروژه</a></h1>
		<p>کل این پروژه در پوشه <a href="https://github.com/jeyserver/webuilder/blob/master/packages"><code>packages</code></a> فریم-ورک <a href="https://github.com/jeyserver/webuilder">Webuilder</a> جای میگیرذ.</p>
		<p><a href="https://github.com/yeganemehr/php5to7/blob/master/package.json"><strong><code>package.json</code></strong></a>: این فایل هویت و پیشنیاز های یک بسته را برای فریم-ورک تعریف میکند.همینطور امکان ذخیره و دسترسی داده ها و تنظیمات بصورت ایستا در این فایل وجود دارد.</p>
		<p><a href="https://github.com/yeganemehr/php5to7/blob/master/routing.json"><strong><code>routing.json</code></strong></a>: این فایل امکان مسیریابی درخواست HTTP را برای فریم-ورک فراهم میکند و اعلام میکند که هر آدرسی میبایست به کدام Controller راه یابد.</p>
		<p><a href="https://github.com/yeganemehr/php5to7/blob/master/autoloader.json"><strong><code>autoloader.json</code></strong></a>: در این فایل مسیریابی کلاس های برنامه نویسی ذخیره میشود و فریم-ورک این قابلیت را فراهم میسازد تا برنامه نویس نیازی به صدا زدن فایل های منبع نداشته باشد.</p>
		<p>شاخه <a href="https://github.com/yeganemehr/php5to7/blob/master/controllers"><strong><code>controllers</code></strong></a>: با توجه به معماری MVC وب سایت پروژه، کنترلر ها در این مسیر قرار میگرند تا درخواست ها را از Router دریافت و مدیریت کنند.</p>
		<p>شاخه <a href="https://github.com/yeganemehr/php5to7/blob/master/views"><strong><code>views</code></strong></a>: کنترلر از این کلاس های این شاخه استفاده میکنند تا یک View را صدا بزنند و از طریق آن ها با قالب ارتباط قرار کنند.</p>
		<p>شاخه <a href="https://github.com/yeganemehr/php5to7/blob/master/library"><strong><code>library</code></strong></a>: در این شاخه، Model ها و سایر کد هایی که در روند پردازش کد ها باید استفاده شود را ذخیره میکنیم.</p>
		<p>شاخه <a href="https://github.com/yeganemehr/php5to7/blob/master/processes"><strong><code>processes</code></strong></a>: شامل روند هایی هستند که از طریق رابط خط-فرمان (CLI) قابلیت اجرا شدن دارند.</p>
		<p>شاخه <a href="https://github.com/yeganemehr/php5to7/blob/master/frontend"><strong><code>frontend</code></strong></a>: </p>
		<p style="padding-right:120px"><a href="https://github.com/yeganemehr/php5to7/blob/master/frontend/theme.json"><strong><code>theme.json</code></strong></a>: هویت یک قالب را برای فریم-ورک را به همراه نحوه ارتباط View های بسته با View های قالب را معرفی میکند.</p>
		<p style="padding-right:120px"><a href="https://github.com/yeganemehr/php5to7/blob/master/frontend/autoloader.json"><strong><code>autoloader.json</code></strong></a>: در این فایل مسیریابی کلاس های برنامه نویسی ذخیره میشود و فریم-ورک این قابلیت را فراهم میسازد تا برنامه نویس نیازی به صدا زدن فایل های منبع نداشته باشد.</p>
		<p style="padding-right:120px"><a href="https://github.com/yeganemehr/php5to7/blob/master/frontend/package.json"><strong><code>package.json</code></strong></a>: بسته های نرم افزاری Nodejs را معرفی میکند و به شما اجازه میدهد تا درصورتی که تمایل داشتید خودتان و فارغ از بسته NPM آن ها را نصب کنید.</p>
		<p style="padding-right:120px"><a href="https://github.com/yeganemehr/php5to7/blob/master/frontend/tsconfig.json"><strong><code>tsconfig.json</code></strong></a>: تنظیمات پایه مربوط به مترجم Typescript را در خود نگهداری میکند.</p>
		<p style="padding-right:120px">شاخه <a href="https://github.com/yeganemehr/php5to7/blob/master/frontend/assets"><strong><code>assets</code></strong></a>: فایل های ایستا مانند تصاویر، Less و یا TS در این شاخه نگهداری میشوند.</p>
		<p style="padding-right:120px">شاخه <a href="https://github.com/yeganemehr/php5to7/blob/master/frontend/html"><strong><code>html</code></strong></a>: فایل هایی که شامل کد های نهایی HTML هستند در این شاخه نگهداری میشوند.</p>
		<p style="padding-right:120px">شاخه <a href="https://github.com/yeganemehr/php5to7/blob/master/frontend/libraries"><strong><code>libraries</code></strong></a>: برنامه و کد هایی که در حین اجرای قالب لازم به فراخوانی هستند در این شاخه ذخیره میشوند.</p>
		<p style="padding-right:120px">شاخه <a href="https://github.com/yeganemehr/php5to7/blob/master/frontend/views"><strong><code>views</code></strong></a>: به ازای هر View از بسته اصلی، یک View دیگر در این شاخه ذخیره میشود تا به برنامه نویس و پروژه انعطاف پذیری بیشتر بدهد.</p>

		<h1 id="انجام-تغییرات" class="deep-link"><a href="#انجام-تغییرات">انجام تغییرات</a></h1>
		<p>پس اینکه از طریق Github <a href="#ارتباطات">به ما اطلاع دادید</a> که قصد چه تغییراتی را در پروژه دارید، از مخزن اصلی <a href="https://github.com/yeganemehr/php5to7/fork">یک انشعاب</a> به نام خودتان بسازید.سپس تغییراتتان را در مخزن جدیدتان ارسال کنید و در نهایت تغییرات را به عنوان یک Pull-Request برای ما ارسال کنید.لطفا موارد زیر را در حین کارتان در نظر بگیرید:</p>
		<ul>
			<li>Commit هایتان را در حد ممکن کوچک ثبت کنید و از ارسال Commit هایی که شامل تعداد زیادی تغییر در فایل های مختلف هستند پرهیز کنید.</li
			<li>عنوان Commit هایتان را انگلیسی و با عبارت بامفهوم و مرتبط با آن تغییرات انتخاب کنید.</li>
			<li>در توضیحات Commit و Pull-request خود به موضوعی که از قبل ایجاد کردید، اشاره کنید.</li>
			<li>برای قابلیت های جدید، لطفا تست های واحد ارائه کنید.</li>
		</ul>
	</div>
</div>
<?php $this->the_footer(); ?>