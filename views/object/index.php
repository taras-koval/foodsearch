<?php include_once ROOT.'/views/layouts/header.php' ?>

<main class="page-main">
	<div class="container">

		<!-- <section class="side-navigation-section">
			<div class="side-navigation">
				<ul class="nav-list">
					<li><a href=""></a></li>
				</ul>
			</div>
		</section> -->

		<section class="full-content-section">	
			<div class="title-bar center">
				<h1>Каталог закладів у місті Львів</h1>
			</div>

			<div class="content-item">
				<div class="content-body objects-list center">
					
					<?php
						if (!isset($objects) || !$objects)
							echo "(Пусто)";
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

			<div class="content-item">
				<div class="content-body">
					<?php echo $pagination->get(); ?>
				</div>
			</div>

		</section>
		

	</div>
</main>

<?php include_once ROOT.'/views/layouts/footer.php' ?>