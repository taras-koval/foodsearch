<?php include_once ROOT.'/views/layouts/header.php' ?>

<main class="page-main">
	<div class="container">

		<section class="content-section recommendations">	
			<div class="title-ber">
				<h1>Шукаєте нових вражень, <br>Але не знаєте куди піти у Львові?</h1>
			</div>

			<?php
				if (!empty($liked)):
			?>

			<div class="content-item">
				<div class="content-title">
					<h2>Ми підшукаємо заклад харчування за вашими вподобаннями</h2>
				</div>
				<div class="content-body objects-list center">
					
					<?php
						foreach ($liked as $item):
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
				else:
			?>

			<div class="content-item">
				<div class="content-title">
					<h2>Щоб получити рекомендації оцініть заклад</h2>
				</div>
			</div>

			<?php
				endif;
			?>

			<?php
				if (!isset($_POST['submit']) && empty($recommendations) && !empty($liked)):
			?>

			<div class="content-item">
				<div class="content-body objects-list center">
					<form action="/recommendations/" method="post" autocomplete="off">
						<input type="submit" name="submit" value="Рекомендувати">
						<!-- <button>Рекомендувати</button> -->
					</form>	
				</div>
			</div>

			<?php
				endif;
			?>

			<?php
				if (isset($_POST['submit']) && empty($recommendations) && !empty($liked)):
			?>

			<div class="content-item">
				<div class="content-title">
					<h2>Заклади, які можуть Вам сподобатись</h2>
				</div>
				<div class="content-body objects-list center">
					<span>(Рекомендацій не знайдено)</span>
				</div>
			</div>

			<?php
				endif;
			?>

			<?php
				if (!empty($recommendations)):
			?>

			<div class="content-item">
				<div class="content-title">
					<h2>Заклади, які можуть Вам сподобатись</h2>
				</div>
				<div class="content-body objects-list center">
					
					<?php
						foreach ($recommendations as $item):
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