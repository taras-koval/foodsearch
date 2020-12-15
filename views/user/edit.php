<?php include_once ROOT.'/views/layouts/header.php' ?>

<main class="page-main">
	<div class="container">

		<?php include_once ROOT.'/views/layouts/user_side_nav.php' ?>

		<section class="content-section">	
			
			<h1>Редагування особистих даних</h1>

			<div class="content-item">
				<div class="content-title">
					<h2>Персональні дані</h2>
					<a href="/user/"><button>Скасувати</button></a>
				</div>

				<div class="content-body">

					<?php
						if ($result):
					?>

					<div class="change-success">
						<span>&#10004;</span> Дані збережено!
					</div>

					<?php 
						else:
					?>
					
					<form action="/user/edit/" method="post">
						<div class="row">
							<div class="column-small label">Ім'я</div>
							<div class="column-half">
								<input type="text" name="username" value="<?php echo $form['username']; ?>">
							</div>
						</div>
						<div class="row">
							<div class="column-small label">Електронна пошта</div>
							<div class="column-half">
								<input type="email" name="email" value="<?php echo $form['email']; ?>">
							</div>
						</div>
						<div class="row">
						<?php
							if (isset($errors) && is_array($errors)) {

								echo "<div class='form-text form-error'>";
								echo "- " . $errors[0];
								echo "</div>";
							}
						?>
						</div>
						<div class="row">
							<div class="column-small label">
								<input type="submit" name="submit" value="Зберегти">
							</div>
						</div>
					</form>

					<?php
						endif;
					?>	
				</div>
			</div>

		</section>
		

	</div>
</main>

<?php include_once ROOT.'/views/layouts/footer.php' ?>