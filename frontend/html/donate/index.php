<?php
use \packages\base;
use \packages\base\http;
use \packages\base\frontend\theme;
$this->the_header();
?>

<div class="page-container donate-container">

	<div class="page-content">
		<h1>حمایت مالی</h1>
		<p>ما برای این پروژه و سایر پروژه های رایگانی که جی سرور راه اندازی میکنیم، ساعت ها زمان صرف میکنیم و تمام تلاشمان این است تا بهترین خدماتمان را بدون دریافت هزینه ای بابت آن ها ارائه کنیم؛ اما اگر برنامه نویس باشید حتما میتوانید حدس بزنید که هزینه های ایجاد و توسعه و نگهداری یک پروژه برنامه نویسی چقدر میتواند سنگین باشد.به همین خاطر حمایت های مالی شما برای ما بسیار ارزشمندند.</p>
		<?php
		foreach($this->getErrors() as $error){
			if($error->getCode() == "Zarinpal.MinPayAmountException"){
		?>
		<div class="alert alert-danger">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> خطا!</h4>
			<p>از شما بسیار سپاسگزاریم که تصمیم گرفتید به ما برای ادامه راهمان کمک کنید ولی متاسفانه درگاه پرداخت ما برای مبالغ کمتر از 100 تومان تراکنشی ایجاد نمیکند.</p>
		</div>
		<?php
			}elseif($error->getCode() == "Zarinpal.MerchantException"){
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
		<div class="page-box">
			<section class="strip-container">
				<div class="profile-header black">
					<a class="profile-header-content" href="https://www.jeyserver.com/">
						<div class="profile-image-container">
							<div class="profile-header-img current-profile-img" style="background-image: url(&quot;<?php echo theme::url('assets/images/jslogo6.png'); ?>&quot;);"></div>
						</div>
						<div class="profile-header-details">
							<div class="profile-header-subtitle" dir="ltr"><span>JeyServer</span></div>
							<div class="profile-header-location">خدمات میزبانی وب سایت</div>
						</div>
					</a>
				</div>
			</section>
			<section class="content-container">
				<div class="profile-page content-delayed-fade-in">
					<form class="profile-amount-form" method="POST" action="<?php echo base\url('donate'); ?>">
						<div class="profile-amount-input-container">
							<div class="money-input">
								<div class="amount-container" dir="ltr" style="font-size: 60px;">
									<input placeholder="0" value="<?php echo http::getData('amount'); ?>" name="amount" class="amount-number" type="text">
								</div>
							</div>
						</div>
						<div class="profile-amount-currency-selector-container">
							<div class="dropdown">
								<select name="currency">
									<option value="Toman"<?php echo http::getData('currency') == "Toman" ? " selected" : ""; ?>>تومان</option>
									<option value="BTC"<?php echo http::getData('currency') == "BTC" ? " selected" : ""; ?>>بیت کوین</option>
								</select>
								<span class="dropdown-arrow fa fa-chevron-down " aria-hidden="true"></span>
							</div>
						</div>
						<button class="btn btn-primary btn-lg btn-block profile-amount-submit-button" type="submit">پرداخت</button>
					</form>
				</div>
			</section>
		</div>
	</div>
</div>
<?php $this->the_footer(); ?>