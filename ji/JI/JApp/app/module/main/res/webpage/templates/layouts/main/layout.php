<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html">
		<meta name="Content-Language" content="en" >
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
		<style>
		<?= file_get_contents( __DIR__.'/my_reset.css' ) ?>
		<?= file_get_contents( __DIR__.'/height100.css' ) ?>
		<?= file_get_contents( __DIR__.'/form.css' ) ?>
		<?= file_get_contents( __DIR__.'/color.css' ) ?>
		</style>
		<?= $head ;?>
	</head>

	<body>

	<div class="_body">
		<div class="_header">
		<?= $body->get('header') ; ?>
		</div>

		<div class="_content">
		<?= $body->get('content') ; ?>
		</div>

		<div class="_footer">
	
		</div>
	</div>
	<?= $body->script() ; ?>
	</body>
</html>
