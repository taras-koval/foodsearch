<!DOCTYPE html>
<html lang="zxx">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">

	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">

	<title><?php echo $this->title; ?></title>
	
	<link rel="stylesheet" href="/template/styles/fonts.css">
	<link rel="stylesheet" href="/template/styles/common.css">
	<link rel="stylesheet" href="/template/styles/main.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

</head>
<body>

<header class="page-header">
	<div class="container">

		<a href="/" class="logo">Food factory</a>

		<nav class="page-nav">
			<a href="/objects/">Заклади</a>
			<a href="/selection/">Підбір</a>
			<a href="/recommendations/">Рекомендації</a>
			
			<?php
				if (!User::issetSession()):
			?>

			<a href="/login/">Вхід</a>

			<?php
				else:
			?>

			<a href="/user/" class="user-border">
				<?php echo $_SESSION['user']['username']; ?>
			</a>

			<?php
				endif;
			?>

		</nav>

	</div>
</header>