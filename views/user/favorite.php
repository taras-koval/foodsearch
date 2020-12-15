<?php include_once ROOT.'/views/layouts/header.php' ?>

<main class="page-main">
	<div class="container">

		<?php include_once ROOT.'/views/layouts/user_side_nav.php' ?>

		<section class="content-section">	
			<div class="title-ber">
				<h1>Улюблені заклади</h1>
			</div>

			<div class="content-item">

				<div class="content-body">

					<?php
						if (!isset($favorites) || !$favorites)
							echo "(Пусто)";
					?>

					<?php
						foreach ($favorites as $item):
					?>

					<div class="object-item">
						<div class="object-header">
							<a href="/object/<?php echo $item['id']; ?>" class="object-title">
								<h2><?php echo $item['name']; ?></h2>
							</a>
							<div class="object-rating">
								<span>4.5</span>
							</div>
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

			<div class="content-item">
				<div class="content-body">
					<?php echo $pagination->get(); ?>
				</div>
			</div>

		</section>
		

	</div>
</main>

<?php include_once ROOT.'/views/layouts/footer.php' ?>