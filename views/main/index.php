<?php include_once ROOT.'/views/layouts/main-page-header.php' ?>

<main class="page-main home-page">
	<div class="container">

		<section class="full-content-section recommendations">	

			<h1>Пошук закладів харчування</h1>

			<div class="content-item">
				<div class="content-body">
					<div class="row">
						<form action="/" method="post" 
							class="admin-form column-half" autocomplete="off">
							<input type="text" name="query" placeholder="Введіть назву..."
								value="<?php echo $query; ?>">
							<input type="submit" name="search" value="Пошук">
						</form>
					</div>
				</div>
			</div>

			<?php
				if (!empty($query)):
			?>

			<div class="content-item">
				<div class="content-title">
					<h2>Результати пошуку</h2>
				</div>

				<div class="content-body objects-list center">

					<?php
						if (empty($objects))
							echo "(На запит '". $query ."' не знайдено жодного закладу)";
					?>

					<?php
						foreach ($objects as $item):
					?>

					<div class="object-item small-object">
						<div class="object-header">
							<a href="/object/<?php echo $item['id']; ?>" class="object-title">
								<h2><?php echo $item['name']; ?></h2>
							</a>
							
							<?php if (isset($item['rating'])): ?>
							<div class="object-rating">
								<span><?php echo $item['rating']; ?></span>
							</div>
							<?php endif; ?>
						</div>

						<div class="object-image">
							<a href="/object/<?php echo $item['id']; ?>" class="object-title">
								<img src="<?php echo Object_::getImage($item['id']); ?>" alt="object">
							</a>
						</div>

						<div class="object-description">
							<div class="row">
								<div class="column-small">Тип:</div>
								<div class="column-full"><?php echo $item['type']; ?></div>
							</div>
							<div class="row">
								<div class="column-small">Кухня:</div>
								<div class="column-full"><?php echo $item['kitchen']; ?></div>
							</div>
							<div class="row">
								<div class="column-small">Адреса:</div>
								<div class="column-full"><?php echo $item['address']; ?></div>
							</div>
							<div class="row">
								<div class="column-small">Робочі години:</div>
								<div class="column-full"><?php echo $item['hours']; ?></div>
							</div>
						</div>
					</div>

					<?php 
						endforeach;
					?>

				</div>
			</div>

		<?php
			endif;
		?>

		</section>
		

	</div>
</main>

<?php include_once ROOT.'/views/layouts/footer.php' ?>