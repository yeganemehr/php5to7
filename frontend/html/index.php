<?php
use \packages\base;
use \themes\php5to7\views;
$this->the_header();
?>
<svg width="0" height="0" class="hidden">
	<defs>
		<clippath id="top-transition-clip-shape" clippathunits="objectBoundingBox">
			<polygon points="0 0, 1 0, 1 1, 0 0.8"/>
		</clippath>

		<clippath id="customization-transition-clip-shape" clippathunits="objectBoundingBox">
			<polygon points="0 0.05, 1 0, 1 1, 0 1"/>
		</clippath>
	</defs>
</svg>

<div class="landing-top">
	<div class="bg"></div>
	<div class="page-container" style="overflow:initial">
		<div class="desc">
			<h2>ابزار مهاجرت به PHP 7</h2>
			<p>این وب سایت ابزاریست برای طراحان و مدیران وب سایت ها تا برنامه های خود را بتوانند با نسخه هفتم زبان PHP هماهنگ کنند.آیا بهتر نیست که به جای هزینه بیشتر برای تامین منابع وب سایتتان، اسکرپتتان را بهینه تر کنید و تا 2 برابر بازدهی بالاتری را دریافت کنید؟
		</div>
		<div class="modal-upload">

			<div class="example-content success show">
				<h3 class="title">سریع، شروع کنید!</h3>
				<p class="text">برنامه های خود را در اینجا آپلود کنید تا برایتان تغییرات لازم را ایجاد کنیم.</p>

				<form action="<?php echo base\url("migration"); ?>" method="POST" role="form" id="upload_form" class="form-horizontal dropzone">
				</form>
			</div>
		</div>
	</div>
</div>
<?php
if($this instanceof views\index){
	foreach($this->getFiles() as $file){
?>
<div class="file-preview">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading" style="overflow:hidden">
				<div class="pull-right">توضیحات و تغییرات</div>
				<div class="pull-left text-left ltr">
					<i class="fa fa-file-text-o"></i> <strong><?php echo $file['name']; ?></strong>
					<a class="btn btn-sm btn-default" href="<?php echo base\url('download/'.$file['file']->md5()); ?>" target="_blank"><i class="fa fa-download"></i></a>
					<a class="btn btn-sm btn-default" href="<?php echo base\url('raw/'.$file['file']->md5()); ?>" target="_blank"><i class="fa fa-file-code-o"></i></a>
					<a class="btn btn-sm btn-default" href="<?php echo base\url('remove/'.$file['file']->md5()); ?>" target="_blank"><i class="fa fa-trash-o"></i></a>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-4">
						<div class="notice">
							<i class="fa fa-info-circle"></i> <a href="#L16">خط 16</a>: نام سازنده کلاس <code>index</code> به <code>__contruct</code> تغییر کرد.
						</div>

					</div>
					<div class="col-lg-8">
						<div class="preview-code">
							<pre><code class="php"><?php echo htmlentities($file['file']->read()); ?></code></pre>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php } ?>
<div class="comparison-container">
	<div class="page-container">
		<h3>چرا PHP 7؟</h3>
		<p>چون سریعتره! هرچقدر یک زبان برنامه نویسی سریعتر عمل کند صرفه اقتصادی بیشتری داره و باعث میشه که شما کمتر هزینه میزبانی وب پرداخت کنید.</p>
		<p>اندازه گیری های ما نشان داده که بازدهی نسخه هفت php از نسخه 5.6 حدود ۲ الی ۳ برابر بیشتر است.این به معنای آن است که اگر بتوانید برنامه های خود را از PHP 5 به 7 بروزرسانی کنید، با منابع سخت افزاری یکسان عملیات را ۲ الی ۳ برابر سریعتر انجام دهید.</p>
		
		<h3>آیا شما مسئولیت کامل ارتقا برنامه من رو قبول میکنید؟</h3>
		<p>بصورت خلاصه: نه! ما حداکثر تلاشمون رو کردیم تا حد ممکن <a href="http://ir2.php.net/manual/en/migration70.incompatible.php" target="_blank">تغییرات اساسی</a> (Breaking changes) رو تشخیص بدیم و نسبت به حلشون اقدام کنیم ولی ما ادعا نمیکنیم که توان شناسایی یا حل تمامی این موارد رو داریم.از طرفی بعضی از موارد هم هنوز بصورت کامل کنترل نشده، برای مثال اگر شما همچنان از توابع <a href="http://php.net/mysql_connect" target="_blank">mysql_connect</a> استفاده میکنید، این افزونه در نسخه 7.0 بصورت کامل حذف شده و ما هم همچنان راه حلی برای آن ارائه ندادیم.</p>
		<p>ولی اگر برای ارتقا مصمم هستید، <a href="https://www.jeyserver.com/fa/contactus">با ما تماس بگیرید</a> تا بصورت ویژه در مورد ارتقای برنامه شما صحبت و برنامه ریزی کنیم.</p>
		
		<h3>آیا شما تضمین میدید که برنامه من بعد از تغییرات شما دچار مشکل نشه؟</h3>
		<p>باز هم نه!راه حل هایی که ما به شما ارائه میدیم کاملا عمومی هستند و هیچ تضمینی وجود ندارد تا حتما با برنامه شما سازگار باشند،</p>
		
		<h3>برنامه من تجاری / محرمانه است و من نگرانم که شما از برنامه من سوء استفاده کنید.</h3>
		<p>نگران نباشید، ما علاقه ای به سورس کد های شما نداریم! و فایل های شما رو نگهداری نمیکنیم ولی اگر میخواید که مطمئن باشید که کد های شما در امانه، میتونید این ابزار رو بر روی سرور یا رایانه شخصی خودتون راه اندازی کنید. برخلاف شما ، برنامه ما تجاری یا محرمانه نیست و بصورت کاملا Open-Source منتشر شده <i class="fa fa-smile-o"></i>.برای جزئیات بیشتر این آموزش رو مطالعه کنید.</p>
		
		<h3>هدفتون از راه اندازی این ابزار چی بود؟</h3>
		<p><a href="#">داستانش مفصله!</a></p>

		<h3>من از ابزارتون استفاده کردم ولی باز هم خطا میگیرم، کمکم کنید؟</h3>
		<p>کدتون + خطایی که دریافت میکنید رو از <a href="#">این صفحه</a> ارسال کنید و ما سعی میکنیم تا در اولین فرصت براتون مشکل رو توضیح بدیم و درصورت امکان با کمک هم حلش کنیم.</p>
		
		<h3>هاست سریع برای php7 سراغ ندارید؟</h3>
		<p><a href="https://www.jeyserver.com">جی سرور</a> رو امتحان کنید، مخصوصا <a href="https://www.jeyserver.com/fa/hosting/linux/professional" title="هاست لینوکس حرفه ای">هاست های دایرکت ادمین</a>شون رو شنیدم خیلی سرعت خوبی داره و PHP7 هم از قبل نصب کردند!</p>
		
		<h3>من از کارتون خوشم اومده و میخوام بهتون کمک کنم.</h3>
		<p>مرسی از محبتتون! لطفا <a href="<?php echo base\url('contributing'); ?>">راهنمای مشارکت</a> رو بخونید.</p>
	</div>
</div>
<?php
}elseif($this instanceof views\remove){
?>
<div class="text-center box-remove">
	<p><i class="fa fa-check-circle"></i></p>
	<p>فایل مورد نظر با موفقیت حذف شد!</p>
</div>
<?php } ?>
<?php $this->the_footer(); ?>