<?php include_once ROOT.'/views/layouts/header.php' ?>

<main class="page-main">
	<div class="container">

		<?php include_once ROOT.'/views/layouts/user_side_nav.php' ?>

		<section class="content-section">	
			
			<h1>Заклад</h1>

			<div class="content-item">
				<div class="content-title">
					<h2>Редагувати</h2>
					<a href="/admin/object/"><button>Скасувати</button></a>
				</div>

				<div class="content-body">
					
					<?php
						if (isset($result) && $result):
					?>

					<div class="row">
						<div class="change-success">
							<span>&#10004;</span> Дані збережено!
						</div>
					</div>

					<?php
						endif;
					?>

					<div class="row">	
						
						<form method="post" class="column-half admin-form" autocomplete="off" enctype="multipart/form-data">
							
							<!-- Name -->
							<label for="object_name">Назва закладу</label>
							<input type="text" name="name" id="object_name" 
							value="<?php echo $form['name']; ?>" required autofocus>
							
							<!-- Type -->
							<label for="object_type">Тип закладу</label>
							<select name="type" id="object_type" required>
							<?php foreach ($typesList as $type): ?>

								<option value="<?php echo $type['id']; ?>" 
									<?php echo ($form['type'] == $type['id'])? 'selected' : ''; ?>
									><?php echo $type['name']; ?></option>
							
							<?php endforeach; ?>
							</select>
							
							<!-- Kitchen -->
							<label for="object_kitchens">Кухня</label>
							<div class="checkbox-group">
							<?php
								foreach ($kitchensList as $kitchen): 

								$id = $kitchen['id'];
								$name = $kitchen['name'];
							?>
								<p class="checkbox-item">
									<input type="checkbox" id="<?php echo 'kitchen'.$id ?>" 
										name="kitchen[]" value="<?php echo $id; ?>"
										<?php
											if (isset($form['kitchen']) || !empty($form['kitchen']))
												foreach ($form['kitchen'] as $item)
													if ($item == $id)
														echo 'checked';
										?>>
									<label for="<?php echo 'kitchen'.$id ?>" 
										class="checkbox-label"><?php echo $name; ?></label>
								</p>

							<?php 
								endforeach; 
							?>
							</div>

							<!-- Services -->
							<label for="object_services">Додаткові послуги</label>
							<div class="checkbox-group">
							<?php 
								foreach ($servicesList as $service): 

								$id = $service['id'];
								$name = $service['name'];
							?>
								<p class="checkbox-item">
									<input type="checkbox" id="<?php echo 'service'.$id ?>" 
										name="service[]" value="<?php echo $id; ?>"
										<?php
											if (isset($form['service']) || !empty($form['service']))
												foreach ($form['service'] as $item)
													if ($item == $id)
														echo 'checked';
										?>>
									<label for="<?php echo 'service'.$id ?>" 
										class="checkbox-label"><?php echo $name; ?></label>
								</p>
							<?php 
								endforeach; 
							?>
							</div>
							
							<!-- Address -->
							<label for="object_address">Адреса <span>(Не обов'язково)</span></label>
							<input type="text" name="address" id="object_address" 
							value="<?php echo $form['address']; ?>">

							<!-- Phone -->
							<label for="object_phone">Телефон <span>(Не обов'язково)</span></label>
							<input type="text" name="phone" id="object_phone" 
							value="<?php echo $form['phone']; ?>">

							<!-- Hours -->
							<label for="object_hours">Години роботи <span>(Не обов'язково)</span></label>
							<input type="text" name="hours" id="object_hours" 
							value="<?php echo $form['hours']; ?>">

							<!-- Link -->
							<label for="object_link">Сайт заклау <span>(Не обов'язково)</span></label>
							<input type="text" name="link" id="object_link" 
							value="<?php echo $form['link']; ?>">

							<!-- Description -->
							<label for="object_description">Опис <span>(Не обов'язково)</span></label>
							<textarea name="description" id="object_description" rows="5"><?php echo $form['description'] ?></textarea>

							<!-- Photo -->
							<label for="object_photo">Фото <span>(Не обов'язково)</span>
							<img src="<?php echo Object_::getImage($form['id']); ?>" class="selected-image" alt="object photo">
							</label>
							<input type="file" name="photo" id="object_photo">

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

		</section>
		

	</div>
</main>

<?php include_once ROOT.'/views/layouts/footer.php' ?>