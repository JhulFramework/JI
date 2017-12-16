
<?php $page->linkStyle() ?>

<?php foreach( $page->items() as $item ) : ?>

<div class="level index is-mobile is-marginless is-paddingless">
	<div class="level-left">
		<div class="level-item" ><div class="key"><?= $item->key() ?></div></div>
		<div class="level-item" ><div class="name"><?= $item->name() ?></div></div>
	</div>

	<div class="level-right">
		<div class="level-item" ><div class="editlink"> <a href="<?= $item->editURL() ?>"><i class="icon-setting" ></i>Edit</a></div></div>
	</div>
</div>

<?php endforeach; ?>
