<?php include_once ROOT.'/views/layouts/header.php' ?>

<main class="page-main">
	<div class="container">

		<?php include_once ROOT.'/views/layouts/user_side_nav.php' ?>

		<section class="content-section">	
			
			<h1>Заклад</h1>

			<div class="content-item">
				<div class="content-title">
					<h2>Список</h2>
					<a href="/admin/object/add/"><button>Додати заклад</button></a>
				</div>

				<div class="content-body">

					<div class="admin-search">
						<form action="/admin/object/" method="post" autocomplete="off">
							<input type="text" name="query" placeholder="Назва"
								value="<?php echo $query; ?>">
							<input type="submit" name="search" value="Пошук">
						</form>
					</div>

					<?php
						if (!isset($objects) || !$objects):
							echo "(Пусто)";
						else:
					?>

					<table>
						<tr>
							<th>№</th>
							<th>ID</th>
							<th>Назва</th>
							<th></th>
							<th></th>
						</tr>
						<?php
							$i = 1 + ($page * $count) - $count;

							foreach ($objects as $item):
						?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $item['id']; ?></td>
							<td>
								<a href="/object/<?php echo $item['id']; ?>" 
									class="table-link">
									<?php echo $item['name']; ?>
								</a>
							</td>
							<td>
								<a href="/admin/object/edit/<?php echo $item['id']; ?>" 
								class="color-edit">Редагувати</a>
							</td>
							<td>
								<a href="/admin/object-del/<?php echo $item['id']; ?>" 
								class="color-delete">Видалити</a>
							</td>
						</tr>
						<?php
							endforeach;
						?>
					</table>

					<?php 
						endif; 
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