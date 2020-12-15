<?php include_once ROOT.'/views/layouts/header.php' ?>

<main class="page-main object-view">
	<div class="container">

		<section class="full-content-section">

			<div class="header-object">
				<div class="title-object">
					<h1><?php echo $object['name']; ?></h1>

					<?php if ($isFavorite): ?>

					<a href="/user/favorite-del/<?php echo $object['id']; ?>">
						<button>Видалити з обраних</button>
					</a>

					<?php else: ?>

					<a href="/user/favorite-add/<?php echo $object['id']; ?>">
						<button>➕ Додати в обрані</button>
					</a>

					<?php endif; ?>

				</div>
			</div>
		
			<div class="content-item">
				<div class="content-body">
					
					<div class="foto">
						<a href="<?php echo Object_::getImage($object['id']); ?>" target="_blank">
							<img src="<?php echo Object_::getImage($object['id']); ?>">
						</a>
					</div>

				</div>
			</div>

			<div class="content-item">
				<div class="content-body">
					
					<div class="description">
						<h2>Опис</h2>
						<p><?php echo $object['description']; ?></p>
					</div>

					<div class="main-info">

						<div class="main-info-line">
							<div class="main-info-title">Тип:</div>

							<div class="main-info-content">
								<span><?php echo $object['type']; ?></span>
							</div>
						</div>

						<div class="main-info-line">
							<div class="main-info-title">Кухня:</div>

							<div class="main-info-content">
								<span><?php echo $object['kitchen']; ?></span>
							</div>
						</div>

						<div class="main-info-line">
							<div class="main-info-title">Послуги:</div>

							<div class="main-info-content">
								<span><?php echo $object['service']; ?></span>
							</div>
						</div>

						<div class="main-info-line">
							<div class="main-info-title">Адреса:</div>

							<div class="main-info-content">
								<span><?php echo $object['address']; ?></span>
							</div>
						</div>

						<div class="main-info-line">
							<div class="main-info-title">Телефон:</div>

							<div class="main-info-content">	
								<span><?php echo $object['phone']; ?></span>
							</div>
						</div>

						<div class="main-info-line">
							<div class="main-info-title">Години роботи:</div>

							<div class="main-info-content">	
								<span><?php echo $object['hours']; ?></span>
							</div>
						</div>

						<div class="main-info-line">
							<div class="main-info-title">Сайт:</div>

							<div class="main-info-content">
								<a href="<?php echo $object['link']; ?>" target="_blank">
									<span><?php echo $object['link']; ?></span>
								</a>
							</div>
						</div>

					</div>
					
				</div>
			</div>
			
			<div class="content-item comment">
				<div class="content-body">

				<?php
					if (!$userComment) :
				?>

					<h2>Залишити відгук</h2>

					<form action="/object/<?php echo $objectId; ?>" method="post" autocomplete="off">
						
						<div class="gray-block">
							<strong>Ваша оцінка:</strong>

							<div class="rating-radio">

								<?php
									for ($i = 1; $i <= 5; $i++):
								?>

								<input type="radio" name="rating" 
									value="<?php echo $i; ?>" 
									id="rating<?php echo $i; ?>"
									<?php
										echo ($form['rating'] == $i)? 'checked' : '' 
									?> >
								<label for="rating<?php echo $i; ?>"></label>

								<?php
									endfor;
								?>
							</div>

						</div>

						<textarea name="comment" placeholder="Напишіть відгук..." rows="3"
							required><?php echo $form['comment']; ?></textarea>

							<?php
								if (isset($errors) && is_array($errors)) {

									echo "<div class='form-text form-error'>";
									echo "- " . $errors[0];
									echo "</div>";
								}
							?>

						<input type="submit" name="submit" value="Опублікувати">
					</form>

				<?php
					else:
				?>

					<h2>Ваш відгук</h2>
						
					<div class="gray-block">
						<strong>Ваша оцінка:</strong>

						<div class="author-rating">
							<div class="rating">
								<ul>
								<?php for ($i = 1; $i <= 5; $i++): ?>

								<?php if ($i <= $userComment['rating']): ?>
									<li><a><i class="fa fa-star"></i></a></li>
								<?php else: ?>
									<li><a><i class="fa fa-star gray"></i></a></li>
								<?php endif; ?>

								<?php endfor; ?>
								</ul>
							</div>
						</div>
					</div>

					<div class="content-text"><?php echo $userComment['text']; ?></div>
					
					<?php
						$deleteLink = "/object/$objectId/del-com-$userComment[id]"; 
					?>

					<a href="<?php echo $deleteLink; ?>"><button>Видалити</button></a>

				<?php
					endif;
				?>
					
				</div>
			</div>

			<div class="content-item comment">
				<div class="content-body">
					
					<div class="comments-title">
						<h2>Відгуки користувачів</h2>
						<span class="comments-count"> (<?php echo $total; 
							if (isset($object['rating']))
								echo ", рейтинг: " . $object['rating'];
						?>)</span>
					</div>
					
					<div class="comments-list">

						<?php
							foreach ($comments as $item):
						?>

						<div class="comment-item">

							<div class="comment-header">
								<div class="author-info">

									<div class="author-name"><?php echo $item['username'] ?></div>

									<div class="author-rating">
										<div class="rating">
											<ul>
											<?php for ($i = 1; $i <= 5; $i++): ?>

											<?php if ($i <= $item['rating']): ?>
												<li><a href="#"><i class="fa fa-star"></i></a></li>
											<?php else: ?>
												<li><a href="#"><i class="fa fa-star gray"></i></a></li>
											<?php endif; ?>

											<?php endfor; ?>
											</ul>
										</div>
									</div>

								</div>

								<div class="comment-actions">
								<?php
									if (User::issetSession())
										if ($item['user_id'] == $_SESSION['user']['id'] ||
											User::isAdmin($_SESSION['user']['id'])): 
											$deleteLink = "/object/$objectId/del-com-$item[id]";
								?>

									<a href="<?php echo $deleteLink; ?>">✘ Видалити</a>

								<?php 
									endif; 
								?>

									<div class="comment-date"><?php
										$date = new DateTime($item['date']);
										echo $date->format('d.m.Y');
									?></div>
								</div>

							</div>

							<div class="content-text"><?php echo $item['text']; ?></div>
						</div>

						<?php
							endforeach;
						?>

					</div>
					
				</div>
			</div>

			<div class="content-item">
				<div class="content-body">
					<?php echo $pagination->get(); ?>
				</div>
			</div>

		</section>
			
	</div>
</main>

<?php include_once ROOT.'/views/layouts/footer.php' ?>