<?php
$this->layout('template', ['title' => 'User Profile']) ?>

<?php $this->start('comments') ?>
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>Комментарии</h3>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-success<?php if ($addedComment != 'true') echo ' d-none'; ?>"
                             role="alert">
                            Комментарий успешно добавлен
                        </div>

                        <?php foreach ($comments as $key => $comment): ?>
                            <div class="media">
                                <img src="../app/images/user.jpg" class="mr-3" alt="..." width="64" height="64">
                                <div class="media-body">
                                    <h5 class="mt-0"><?php echo $comment[login]; ?></h5>
                                    <span><small><?php echo $comment[date_comment]; ?></small></span>
                                    <p>
                                        <?php echo $comment[comment]; ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>


            <div class="card-body">
                <div class="alert alert-primary<?php if ($do_auth != 'true') echo ' d-none'; ?>" role="alert">
                    Чтобы оставить комментарий, <a href="login.php">авторизуйтесь</a> или <a href="registerpage.php">зарегистрируйтесь</a>
                </div>
            </div>


            <div class="col-md-12" style="margin-top: 20px;">
                <div class="card">
                    <div class="card-header"><h3>Оставить комментарий</h3>
                    </div>

                    <div class="card-body">

                        <form action="addComment" method="post">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Сообщение</label>
                                <textarea name="comment" class="form-control" id="exampleFormControlTextarea1"
                                          rows="3"><?php echo $newComment; ?></textarea>
                            </div>

                            <div class="alert alert-success<?php if ($emptyComment != 'true') echo ' d-none'; ?>"
                                 role="alert">
                                Введите комментарий
                            </div>

                            <button type="submit" class="btn btn-success">Отправить</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $this->stop() ?>
