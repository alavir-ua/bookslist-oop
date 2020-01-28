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
				<div class="features_items"><!--features_items-->
					<h2 class="title text-center">Последние книги</h2>

			<?php foreach ($latestBooks as $book): ?>
				<div class="col-sm-4">
					<div class="product-image-wrapper">
						<div class="single-products">
							<div class="productinfo text-center">
								<img src="<?php echo Book::getImage($book['id']); ?>"
								     alt=""/>
								<h2><?php echo $book['price'] .' '; ?>грн</h2><!--Цена книги-->
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

				<div class="recommended_items"><!--recommended_items-->
					<h2 class="title text-center">Рекомендуемые гниги</h2>

					<div class="cycle-slideshow"
					     data-cycle-fx=carousel
					     data-cycle-timeout=5000
					     data-cycle-carousel-visible=3
					     data-cycle-carousel-fluid=true
					     data-cycle-slides="div.item"
					     data-cycle-prev="#prev"
					     data-cycle-next="#next"
					>
			  <?php foreach ($sliderBooks as $sliderBook): ?>
								<div class="item">
									<div class="product-image-wrapper">
										<div class="single-products">
											<a class="productinfo text-center" <a href="/book/<?php echo $sliderBook['id']; ?>">
												<img src="<?php echo Book::getImage($sliderBook['id']); ?>"  alt=""/>
											</a>
						<?php if ($sliderBook['is_new']): ?>
													<img src="/template/images/home/new.png" class="new" alt=""/>
						<?php endif; ?>
										</div>
									</div>
								</div>
			  <?php endforeach; ?>
					</div>

					<a class="left recommended-item-control" id="prev" href="#recommended-item-carousel" data-slide="prev">
						<i class="fa fa-angle-left"></i>
					</a>
					<a class="right recommended-item-control" id="next" href="#recommended-item-carousel" data-slide="next">
						<i class="fa fa-angle-right"></i>
					</a>

				</div>
			</div><!--/recommended_items-->

		</div>
	</div>

</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>
