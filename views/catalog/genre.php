<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<div class="left-sidebar">
					<h2>Жанры</h2>
					<div class="panel-group category-products">
			  <?php foreach ($genres as $genre): ?>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a href="/genre/<?php echo $genre['id']; ?>" class="<?php if ($genreId ==
						  $genre['id']) echo 'active'; ?>">
						  <?php echo $genre['name']; ?>
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
				<div class="features_items"><!--features_items-->
					<h2 class="title text-center">Каталог по жанру</h2>

			<?php foreach ($genreBooks as $book): ?>
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<img src="<?php echo Book::getImage($book['id']); ?>"
											     alt=""/>
											<h2><?php echo $book['price'] . ' '; ?>грн</h2><!--Цена книги-->
											<a href="/book/<?php echo $book['id']; ?>"><span>
																<?php echo $book['name']; ?></span><!--Название книги-->
											</a>
											<h2><span><?php echo $book['authors']; ?></span></h2><!--Автора книги-->
										</div>
					  <?php if ($book['is_new']): ?>
												<img src="/template/images/home/new.png" class="new" alt=""/>
					  <?php endif; ?>
									</div>
								</div>
							</div>
			<?php endforeach; ?>

				</div><!--features_items-->

				<!-- Постраничная навигация -->
		  <?php echo $pagination->get(); ?>

			</div>
		</div>
	</div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>
