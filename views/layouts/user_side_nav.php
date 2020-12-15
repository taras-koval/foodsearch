<section class="side-navigation-section">
	<div class="side-navigation">
		<ul class="nav-list">
			<li><a href="/user/">Огляд облікового запису</a></li>
			<!-- <li><a href="/user/edit/">Редагування особистих даних</a></li> -->
			<li><a href="/user/password/">Змінити пароль</a></li>
			<li><a href="/user/favorite/">Улюблені заклади</a></li>
			<li><a href="/logout/">Вихід</a></li>
		</ul>
	</div>
	
	<?php
		if (User::isAdmin($_SESSION['user']['id'])):
	?>

	<div class="side-navigation">
		<ul class="nav-list">
			<li><a href="/admin/object/">Заклад</a></li>
			<li><a href="/admin/kitchen/">Кухня</a></li>
			<li><a href="/admin/service/">Додаткові послуги</a></li>
			<li><a href="/admin/type/">Тип закладу</a></li>
		</ul>
	</div>

	<?php
		endif;
	?>

</section>