<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li class="active">Управление книгами</li>
                </ol>
            </div>

            <a href="/admin/book/create" class="btn btn-default back"><i class="fa fa-plus"></i> Добавить книгу</a>

            <h4>Список книг</h4>

            <br/>

            <table class="table-bordered table-striped table">
                <tr>
                    <th>ID</th>
                    <th>Код</th>
                    <th>Название</th>
                    <th>Стоимость</th>
                    <th>Жанр</th>
                    <th>Авторы</th>
                    <th>Новая</th>
                    <th>Рекомендуемая</th>
                    <th>Статус отображения</th>
                    <th></th>
                    <th></th>
                </tr>

                <?php foreach ($allBooks as $book): ?>
                    <tr>
                        <td><?php echo $book['id']; ?></td>
                        <td><?php echo $book['code']; ?></td>
                        <td><?php echo $book['name']; ?></td>
                        <td><?php echo $book['price']; ?></td>
	                    <td><?php echo $book['genres']; ?></td>
	                    <td><?php echo $book['authors']; ?></td>
                        <td><?php if($book['is_new'] == 1){echo 'да';} else {echo 'нет';} ?></td>
	                    <td><?php if($book['is_recommended'] == 1){echo 'да';} else {echo 'нет';} ?></td>
	                    <td><?php if($book['status'] == 1){echo 'да';} else {echo 'нет';} ?></td>
                        <td><a href="/admin/book/update/<?php echo $book['id']; ?>" title="Редактировать"><i
				                        class="fa fa-pencil-square-o"></i></a></td>
                        <td><a href="/admin/product/delete/<?php echo $book['id']; ?>" title="Удалить"><i class="fa
                        fa-times"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
	        <!-- Постраничная навигация -->
	        <?php echo $pagination->get(); ?>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

