{{titlebar}}
<?php
$this->app()->linkScript('jquery');
$this->app()->linkStyle('icons-animation');
$page->linkScript();
$page->linkStyle();
?>

<div class="item">
<div class="article">

		<div class="level is-marginless is-mobile top">


			<div class="level-left">
				<div class="level-item" >
					<div class="time"><?= $page->item()->time(); ?></div>
				</div>
			</div>
			<div class="level-right" >
				<div class="level-item">
					<div class="editButtonWrapper"><?= $page->item()->ui()->editButton() ?></div>
				</div>
			</div>
		</div>


	<div class="article-content">
		<pre><?= $page->item()->content(); ?> </pre>
	</div>


<div class="level is-marginless is-mobile">

	<div class="level-left">
		<div class="level-item">
			<?= $page->item()->ui()->plusButton() ?>
		</div>
		<div class="level-item">
			<?= $page->item()->ui()->minusButton() ?>
		</div>

	</div>

</div>

</div>
</div>


{{pagination}}
