<?php $page->linkStyle(); ?>

<div class="vindex">
<div class="items">
<?php foreach( $items as $name => $param  ): ?>

<div class="item">

	<div class="tile" style="">

			<div class="icon"><i class="<?= $param['icon'] ?>" ></i></div>

			<div class="bottom" >
				<div class="level">
					<div class="level-item">
						<span class="label"><?= $param['label'] ?></span>
						<a href="<?= $param['url'] ?>">
							<i class='icon-right'></i>
						</a>
					</div>
				</div>
			</div>
	</div>

</div>

<?php endforeach; ?>
</div>
</div>
