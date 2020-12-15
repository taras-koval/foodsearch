<?php include_once ROOT.'/views/layouts/header.php' ?>

<main class="page-main">
	<div class="container">

		<?php include_once ROOT.'/views/layouts/user_side_nav.php' ?>

		<section class="content-section">	
			
			<h1>Огляд облікового запису</h1>

			<div class="content-item">
				<div class="content-title">
					<h2>Персональні дані</h2>
					<a href="/user/edit/" class="color-edit"><span>✎</span> Змінити</a>
				</div>

				<div class="content-body">

					<div class="row">
						<div class="column-small label">Ім'я</div>
						<div class="column-full">
							<?php echo $_SESSION["user"]["username"] ?>
						</div>
					</div>
					<div class="row">
						<div class="column-small label">Електронна пошта</div>
						<div class="column-full">
							<?php echo $_SESSION["user"]["email"] ?>
						</div>
					</div>
				</div>
			</div>

		</section>
		

	</div>
</main>

<?php include_once ROOT.'/views/layouts/footer.php' ?>