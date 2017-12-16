<?php $page->linkStyle(); ?>
<div class="grid">

<?php foreach( $items as $name => $param  ): ?>
<div class="item">

	<div class="tile" style="">

			<div class="icon"><i class="<?= $param['icon'] ?>" ></i></div>

			<div class="bottom" >
				<div class="label"><?= $param['label'] ?></div>


					<a href="<?= $param['url'] ?>">
						<i class='icon-right'></i>
					</a>
			</div>
	</div>

</div>

<?php endforeach; ?>

</div>
