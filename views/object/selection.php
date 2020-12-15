<?php include_once ROOT.'/views/layouts/header.php' ?>

<main class="page-main page-selection">
	<div class="container">

		<section class="full-content-section">

			<div class="content-item">

				<div class="content-body">	
					<div class="row center">
						<form action="/selection/" method="post" 
							class="admin-form column-half" autocomplete="off">

							<h1>Підберіть заклад, який вас цікавить</h1>

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
							<label for="object_kitchens">Страви якої кухні вам до вподоби?</label>
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
							<label for="object_services">Виберіть додаткові послуги</label>
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

							<input type="submit" class="short-button" name="submit" value="Підібрати">

						</form>
					</div>
				</div>
			</div>
			
			<?php if (isset($_POST['submit'])): ?>
			<div class="content-item selection-list">
				<div class="content-title">
					<h2>Результат підбору</h2>
				</div>

				<div class="content-body objects-list center">
					
					<?php if (!empty($objects)): ?>
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
					<?php else: ?>
						<?php echo "(Пусто)"; ?>
					<?php endif; ?>

				</div>
			</div>
			<?php endif; ?>

		</section>
		

	</div>
</main>

<?php include_once ROOT.'/views/layouts/footer.php' ?>