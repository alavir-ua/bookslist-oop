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
					<div class="col-sm-5">

						<p>Для оформления заказа заполните форму. Наш менеджер свяжется с Вами.</p>
						<div class="login-form">
							<form action="#" method="post">
								<p>Ваш адрес</p>
								<input type="text" name="address" placeholder=""/>
								<p>Ваше ФИО</p>
								<input type="text" name="fullName" placeholder=""/>
								<p>Количество екземпляров</p>
								<input type="text" name="quantity" placeholder=""/>
								<br/>
								<br/>
								<input type="submit" name="submit" class="btn btn-default add-to-cart" value="Оформить"/>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>
