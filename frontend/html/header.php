<?php
use \packages\base;
use \packages\base\{translator, frontend\theme};
?>
<!doctype html>
<html lang="<?php echo translator::getShortCodeLang(); ?>" dir="rtl">
<head>
	<meta charset="utf-8">
	<title><?php echo $this->getTitle(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php
	$description = $this->getDescription();
	if($description){
		echo("<meta content=\"{$description}\" name=\"description\" />");
	}
	$this->loadCSS();
	?>
	<link rel="canonical" href="<?php echo base\url('', array(), true); ?>" />
</head>
<body class="<?php echo $this->genBodyClasses(); ?>">
	<header class="global-header">
		<div class="page-container">
			<a href="<?php echo base\url(); ?>" class="logo">
				<svg height="60" width="60">
					<text fill="#fec34d" font-family="Arial" font-size="50" y="42" x="37">7</text>
					<ellipse cx="25" cy="25" rx="18" ry="9" fill="#fff" stroke="#fec34d" stroke-width="1"></ellipse>
					<text fill="#fec34d" font-family="Tahoma" font-style="italic" font-weight="bold" font-size="11" y="28" x="35">php</text>
				</svg>
			</a>
			<nav>
				<ul>
					<li><a href="<?php echo base\url('contributing'); ?>">مشارکت</a></li>
					<li><a href="<?php echo base\url('donate'); ?>">حمایت</a></li>
					<li><a href="https://github.com/yeganemehr/php5to7" target="_blank"><i class="fa fa-github"></i></a></li>
				</ul>
			</nav>
		</div>
	</header>
