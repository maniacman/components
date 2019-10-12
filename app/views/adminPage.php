<?php
$this->layout('template', ['title' => 'User Profile']) ?>
<?php $this->start('adminComments') ?>
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>Админ панель</h3></div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Аватар</th>
                                <th>Имя</th>
                                <th>Дата</th>
                                <th>Комментарий</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($comments as $key => $comment): ?>
                                <tr>
                                    <td>
                                        <img src="../images/<?php echo $comment['user_photo']; ?>" class="mr-3" alt="..."
                                             width="64" height="64">
                                    </td>
                                    <td><?php echo $comment['username']?></td>
                                    <td><?php echo $comment['date_comment']?></td>
                                    <td><?php echo $comment['comment']?></td>
                                    <td>
                                        <a href="changeAccessComment?id=<?php echo $comment['id']?>&access=<?php echo $comment['access']?>" class="btn btn-warning<?php if ($comment['access'] == 1) echo ' d-none';?>">Разрешить</a>

                                        <a href="changeAccessComment?id=<?php echo $comment['id']?>&access=<?php echo $comment['access']?>" class="btn btn-success<?php if ($comment['access'] != 1) echo ' d-none';?>">Запретить</a>

                                        <a href="deleteComment?id=<?php echo $comment['id']?>" onclick="return confirm('are you sure?')" class="btn btn-danger">Удалить</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $this->stop() ?>