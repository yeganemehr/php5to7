<?php
use \packages\base;
$this->the_header();
?>

<div class="page-container donate-container">

	<div class="page-content">
		<h1>حمایت مالی</h1>
		<p>ما برای این پروژه و سایر پروژه های رایگانی که جی سرور راه اندازی میکنیم، ساعت ها زمان صرف میکنیم و تمام تلاشمان این است تا بهترین خدماتمان را بدون دریافت هزینه ای بابت آن ها ارائه کنیم؛ اما اگر برنامه نویس باشید حتما میتوانید حدس بزنید که هزینه های ایجاد و توسعه و نگهداری یک پروژه برنامه نویسی چقدر میتواند سنگین باشد.به همین خاطر حمایت های مالی شما برای ما بسیار ارزشمندند.</p>
		<?php
		foreach($this->getErrors() as $error){
			if($error->getCode() == "Zarinpal.MerchantException"){
		?>
		<div class="alert alert-danger">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> خطا!</h4>
			<p>به نظر میرسد که صاحب این سایت هنوز شناسه فروشنده زرین پال خود را در فایل <code>package.json</code> وارد نکرده و به همین دلیل شما فعلا نمیتوانید پرداختی داشته باشید.</p>
		</div>
		<?php
			}elseif($error->getCode() == "Zarinpal.RequestStatusException"){
		?>
		<div class="alert alert-danger">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> خطا!</h4>
			<p>از شما بسیار سپاسگزاریم که تصمیم گرفتید به ما برای ادامه راهمان کمک کنید ولی متاسفانه درگاه پرداخت برای ایجاد یک تراکنش جدید به ما پاسخ نامفهومی ارسال میکند.لطفا دقیقای دیگر مجددا امتحان کنید.</p>
		</div>
		<?php
			}
		}
		?>
		<div class="result">
			<div class="circle">
				<i class="fa fa-<?php echo $this->getPayStatus() ? 'check' : 'times'; ?>"></i>
			</div>
			<?php if($this->getPayStatus()){ ?>
			<h3>از کمک شما بسیار سپاسگزاریم!</h3>
			<p>همه تلاشمان را میکنم پول شما برای هدف ارزشمندی هزینه شود.</p>
			<?php }else{ ?>
			<h3>تراکنش شما با خطا روبرو شد!</h3>
			<p>از نیت خوبتان تشکر میکنیم ولیکن ما پول شما را دریافت نکردیم.اگر مبلغی از حساب بانکی شما برداشت شده به زودی به حساب شما مرجوع خواهد شد.</p>
			<?php } ?>
		</div>
		<?php
		if($this->getPayStatus()){}
		?>
	</div>
</div>
<?php $this->the_footer(); ?>