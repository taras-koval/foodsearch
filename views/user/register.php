<?php include_once ROOT.'/views/layouts/header.php' ?>

<main class="page-main page-auth">
	<div class="container">
		
		<div class="auth-block">

			<div class="auth-title logo">Food Factory</div>
			
			<form action="/register/" method="post" autocomplete="off">
				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Ім'я" required>
				<input type="email" name="email" value="<?php echo $email; ?>" placeholder="E-mail" required>
				<input type="password" name="password" value="<?php echo $password; ?>" placeholder="Пароль" required>
				<input type="password" name="confirm" value="<?php echo $confirm; ?>" placeholder="Пароль ще раз" required>
				<?php
					if (isset($errors) && is_array($errors)) {

						echo "<div class='form-text form-error'>";
						echo "- " . $errors[0];
						echo "</div>";
					}
				?>
				<input type="submit" name="submit" value="Реєстрація">
			</form>
			
			<ul class="help-links">
				<li><a href="/login/">Вже є аккаунт? Увійти</a></li>
			</ul>

		</div>

	</div>
</main>

<?php include_once ROOT.'/views/layouts/footer.php' ?>