<?php $page->linkStyle(); ?>
<div class="level profile is-marginless" >

<div class="level-item is-marginless">

	<div class="left-section">

			<img src="<?= $this->app()->user()->avatar() ?>">
	</div>
</div>

<div class="level-item is-marginless">

	<div class="right-section">

		<div class="name">
	      	<?= $this->app()->user()->name() ?>
		</div>

		<div class="quote">
			<div class="left" ><i class="icon-quote-left"></i></div>
			<div class="content"><?= $this->app()->user()->tagline() ?></div>
			<div class="right"><i class="icon-quote-right"></i></div>
		</div>

		<div class="social" >
			<?php foreach (  $this->app()->user()->dao()->profile()->social()->fields() as  $value ) : ?>
				<?= $this->app()->user()->dao()->profile()->socialHTML()->makeURL($value) ?>
			<?php endforeach; ?>
		</div>
	</div>
</div>

</div>
