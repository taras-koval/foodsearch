<?php include_once ROOT.'/views/layouts/header.php' ?>

<main class="page-main page-auth">
	<div class="container">
		
		<div class="auth-block">

			<div class="auth-title logo">Food Factory</div>
			
			<form action="/login" method="post">
				<input type="email" name="email" value="<?php echo $email; ?>" placeholder="E-mail" required autofocus>
				<input type="password" name="password" value="<?php echo $password; ?>" placeholder="Пароль" required>
				<?php
					if (isset($errors) && is_array($errors)) {

						echo "<div class='form-text form-error'>";
						echo "- " . $errors[0];
						echo "</div>";
					}
				?>
				<input type="submit" name="submit" value="Авторизація">
			</form>
			
			<ul class="help-links">
				<li><a href="/register">Створити новий аккаунт</a></li>
				<!-- <li><a href="">Забули пароль?</a></li> -->
			</ul>

		</div>

	</div>
</main>

<?php include_once ROOT.'/views/layouts/footer.php' ?>