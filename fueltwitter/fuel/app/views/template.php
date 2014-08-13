<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css('share.css'); ?>
</head>
<body>
	<div id="wrapper">
		<h1><?php echo $title; ?></h1>
		<?php if (Session::get_flash('notice')): ?>
			<div class="notice"><p><?php echo implode('</p><p>', (array) Session::get_flash('notice')); ?></div></p>
		<?php endif; ?>

		<?php echo $content; ?>

		<p class="footer">
			<a href="http://fuelphp.com">Fuel</a> is released under the MIT license.<br />Page rendered in {exec_time}s using {mem_usage}mb of memory.
		</p>
	</div>
</body>
</html>
