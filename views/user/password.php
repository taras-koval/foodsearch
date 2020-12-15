<?php include_once ROOT.'/views/layouts/header.php' ?>

<main class="page-main">
	<div class="container">

		<?php include_once ROOT.'/views/layouts/user_side_nav.php' ?>

		<section class="content-section">	
			
			<h1>Змінити пароль</h1>

			<div class="content-item">
				
				<div class="content-title">
					<h2>Введіть пароль</h2>
				</div>

				<div class="content-body">

					<?php
						if ($result):
					?>

					<div class="change-success">
						<span>&#10004;</span> Пароль змінено!
					</div>

					<?php 
						else:
					?>
					
					<div class="row">

						<form action="/user/password/" method="post"  
							class="column-half admin-form" autocomplete="off">
						
							<label for="user_password">Старий пароль</label>
							<input type="password" name="password" id="user_password"
								value="<?php echo $password; ?>" required autofocus>
							
							<label for="user_new_password">Новий пароль</label>
							<input type="password" name="new_password" id="user_new_password" value="<?php echo $new_password; ?>" required>
							
							<label for="user_confirm">Новий пароль ще раз</label>
							<input type="password" name="confirm" id="user_confirm"
							value="<?php echo $confirm; ?>" required >

							<?php
								if (isset($errors) && is_array($errors)) {

									echo "<div class='form-text form-error'>";
									echo "- " . $errors[0];
									echo "</div>";
								}
							?>

							<input type="submit" name="submit" value="Зберегти">
						</form>

					</div>
					

					<?php
						endif;
					?>
				</div>
			</div>

		</section>
		

	</div>
</main>

<?php include_once ROOT.'/views/layouts/footer.php' ?>