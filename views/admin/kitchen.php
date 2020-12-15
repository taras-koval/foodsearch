<?php include_once ROOT.'/views/layouts/header.php' ?>

<main class="page-main">
	<div class="container">

		<?php include_once ROOT.'/views/layouts/user_side_nav.php' ?>

		<section class="content-section">	
			
			<h1>Кухня</h1>

			<div class="content-item">
				<div class="content-title">
					<h2>Додати</h2>
				</div>

				<div class="content-body">

					<div class="row">
						<?php
							if (isset($result) && $result):
						?>

						<div class="change-success">
							<span>&#10004;</span> Дані збережено!
						</div>

						<?php
							endif;
						?>
					</div>

					<div class="row">
						
						<form action="/admin/kitchen/" method="post" 
							class="column-half admin-form" autocomplete="off">
							
							<label for="kitchen_name">Назва кухні</label>
							<input type="text" name="name" id="kitchen_name" autofocus
								value="<?php echo $name; ?>" required>

							<?php
								if (isset($errors) && is_array($errors)) {

									echo "<div class='form-text form-error'>";
									echo "- " . $errors[0];
									echo "</div>";
								}
							?>

							<input type="submit" name="submit" value="Зберегти дані">
						</form>

					</div>

				</div>
			</div>

			<div class="content-item">
				<div class="content-title">
					<h2>Список</h2>
				</div>

				<div class="content-body">

					<table>
						<tr>
							<th>№</th>
							<th>ID</th>
							<th>Назва</th>
							<th></th>
						</tr>
						<?php
							$i = 1;

							foreach ($kitchens as $item):
						?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $item['id']; ?></td>
							<td><?php echo $item['name']; ?></td>
							<td>
								<a href="/admin/kitchen-del/<?php echo $item['id']; ?>"
									class="color-delete">Видалити</a>
							</td>
						</tr>
						<?php
							endforeach;
						?>
					</table>

				</div>
			</div>

		</section>
		

	</div>
</main>

<?php include_once ROOT.'/views/layouts/footer.php' ?>