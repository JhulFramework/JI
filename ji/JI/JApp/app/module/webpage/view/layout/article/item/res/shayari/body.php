{{titlebar}}
<?php
$this->app()->linkScript('jquery');
$this->app()->linkStyle('icons-animation');
$page->linkScript();
$page->linkStyle();
?>

<div class="item">
<div class="article">

		<div class="level is-mobile">

			<div class="level-left">
				<div class="level-item time" >
					<?= $item->time(); ?>
				</div>
			</div>
			<div class="level-right" >
				<div class="level-item">
					<?= $item->ui()->editButton() ?>
				</div>
			</div>

		</div>

	<div class="leftquote"><i class="icon-quote-left"></i></div>

	<div class="article-content">
		<pre><?= $item->content(); ?> </pre>
	</div>

	<div class="rightquote"><i class="icon-quote-right"></i></div>

<div class="level is-mobile">

	<div class="level-left">
		<div class="level-item">
			<?= $item->ui()->plusButton() ?>
		</div>
		<div class="level-item">
			<?= $item->ui()->minusButton() ?>
		</div>

	</div>

</div>

</div>
</div>


{{pagination}}
