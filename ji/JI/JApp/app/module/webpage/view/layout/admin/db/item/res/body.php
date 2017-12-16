<?php $page->linkStyle() ?>

<?php foreach( $page->item()->adminFields() as $field => $getter ) : ?>

<div class="field">
<div class="level index is-marginless is-paddingless">
	<div class="level-left">
		<div class="level-item is-narrow" ><div class="key"><?= $field ?></div></div>
	</div>

	<div class="level-right">
		<div class="level-item is-narrow" ><div class="editlink"> <a href="<?= $page->item()->editURL($field) ?>"><i class="icon-setting" ></i>Edit</a></div></div>
	</div>
</div>

<div class="value">
<?= $page->item()->$getter() ?>
</div>
</div>

<?php endforeach; ?>

<?php foreach( $page->item()->adminFiles() as $field => $getter ) : ?>

<div class="field">
<div class="level index is-marginless is-paddingless">
	<div class="level-left">
		<div class="level-item is-narrow" ><div class="key"><?= $field ?></div></div>
	</div>

	<div class="level-right">
		<div class="level-item is-narrow" ><div class="editlink"> <a href="<?= $page->item()->editURL($field) ?>"><i class="icon-setting" ></i>Edit</a></div></div>
	</div>
</div>

<div class="value">
<?= $page->item()->$getter() ?>
</div>
</div>

<?php endforeach; ?>

{{form}}
