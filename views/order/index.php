<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<div class="left-sidebar">
					<h2>Жанры</h2>
					<div class="panel-group category-products">
			  <?php foreach ($genres as $genreItem): ?>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a href="/genre/<?php echo $genreItem['id']; ?>">
						  <?php echo $genreItem['name']; ?>
											</a>
										</h4>
									</div>
								</div>
			  <?php endforeach; ?>
					</div>
					<h2>Авторы</h2>
					<div class="panel-group category-products">
			  <?php foreach ($authors as $author): ?>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a href="/author/<?php echo $author['id']; ?>">
						  <?php echo $author['name']; ?>
											</a>
										</h4>
									</div>
								</div>
			  <?php endforeach; ?>
					</div>
				</div>
			</div>

	<div class="col-sm-9 padding-right">
		<div class="features_items">
			<h2 class="title text-center">ОФОРМЛЕНИЕ ЗАКАЗА</h2>

		<?php if ($result): ?>
					<h3>Заказ успешно оформлен.</h3>
		<?php else: ?>

			<?php if (!$result): ?>

						<div class="col-sm-4">
				<?php if (isset($errors) && is_array($errors)): ?>
									<ul>
					  <?php foreach ($errors as $error): ?>
												<li style="color: red; font-weight: bold"> - <?php echo $error; ?></li>
					  <?php endforeach; ?>
									</ul>
				<?php endif; ?>

							<p>Для оформления заказа заполните форму. Наш менеджер свяжется с Вами.</p>

							<div class="login-form">
								<form action="/order/checkout" method="post">
									<p>Название книги</p>
									<input type="text" name="book_name" placeholder="<?php echo $book['name']; ?>" value="<?php echo $book['name']; ?>" readonly>
									<p>Код книги</p>
									<input type="text" name="book_code" placeholder="<?php echo $book['code']; ?>" value="<?php echo $book['code']; ?>" readonly>
									<p>Ваш адрес</p>
									<input type="text" name="address" placeholder="" required>
									<p>Ваше ФИО</p>
									<input type="text" name="full_name" placeholder="" required>
									<p>Количество екземпляров</p>
									<input type="number" name="book_quant" placeholder="" required>
									<input type="hidden" name="book_price" placeholder="" value="<?php echo $book['price']; ?>">
									<br/>
									<br/>
									<input type="submit" name="submit" class="btn btn-default" value="Оформить" />
								</form>
							</div>
						</div>

			<?php endif; ?>

		<?php endif; ?>

		</div>
	</div>

</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>
