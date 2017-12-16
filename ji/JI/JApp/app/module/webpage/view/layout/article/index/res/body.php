{{titlebar}}
<?php
$this->app()->linkScript('jquery');
$this->app()->linkStyle('icons-animation');
$page->linkScript();
$page->linkStyle();
?>

<div class="rgrid">
<?php foreach ( $page->items() as $item ):?>
<div class="item">
<div class="articlePreview">
	<div>
		<span class="title"><?= $item->title() ?></span>
	</div>

	<div class="row2" >
		<span class="time"><?= $item->time() ?></span><span> <a style="color:#70869b;" class="author" href="<?= $item->author()->url() ?>"><?= $item->author()->name() ?></a> </span>
	</div>

	<div class="leftquote"><i class="icon-quote-left"></i></div>

	<div class="preview">
		<?= $item->preview(); ?> . . .
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

	<div class="level-right">
		<div class="level-item">
			<?= $item->ui()->readButton() ?>
		</div>
	</div>
</div>

</div>
</div>

<?php endforeach; ?>

</div>

{{pagination}}
