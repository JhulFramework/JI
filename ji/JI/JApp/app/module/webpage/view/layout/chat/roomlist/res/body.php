<?php $page->linkStyle(); ?>
<div class='res320'>
	<div class="left-section">
		<div class="roomlist">

			<div class="container">
			<?php foreach ($page->rooms() as $room): ?>
				<div class="room">
					<span class="icon"><i class="icon-vert" ></i></span>
					<span class="name" ><?= $room->name() ?></span>
					<a href="<?= $room->url() ?>"><i class="icon-right"></i></a>
					</div>
			<?php endforeach ; ?>
			</div>
		</div>
	</div>

	<div class="right-section">
		<div class="rules" >
			<?= $page->rules() ?>
		</div>
	</div>
</div>
