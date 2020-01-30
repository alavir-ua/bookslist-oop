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
                <div class="product-details"><!--product-details-->
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="view-product">
                                <img src="<?php echo Book::getImage($book['id']); ?>" alt="" />
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="product-information"><!--/product-information-->
                                <?php if ($book['is_new']): ?>
                                    <img src="/template/images/book-details/new.jpg" class="newarrival" alt="" />
                                <?php endif; ?>
                                <h2><?php echo $book['name']; ?></h2>
<!--                                <p>Код товара: --><?php //echo $product['code']; ?><!--</p>-->
                                <span>
                                    <span><?php echo $book['price'].' '; ?>грн</span>
<!--                                    <a href="/order/--><?php //echo $book['id']; ?><!--">Заказать</a>-->
	                                <a class="btn btn-default checkout" href="/order/<?php echo $book['id'];
	                                ?>">Оформить заказ</a>
                                </span>
	                            <h4>Автор:   <?php echo $book['authors']; ?></h4>
	                            <h4>Жанр:   <?php echo $book['genres']; ?></h4>
	                            <h4>Код:   <?php echo $book['code']; ?></h4>
                            </div><!--/product-information-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <br/>
                            <h3>Описание книги</h3>
	                        <p class="desc"><?php echo $book['description']; ?></p>

                        </div>
                    </div>
                </div><!--/product-details-->

            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>
