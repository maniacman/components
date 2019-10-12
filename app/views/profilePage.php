<?php

$this->layout('template', ['title' => 'User Profile']) ?>

<?php $this->start('dataUser') ?>
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><h3>Профиль пользователя</h3></div>

                        <div class="card-body">
                            <div class="alert alert-success<?php if ($updatedUser != 'true') echo ' d-none'; ?>"
                                 role="alert">
                                Профиль успешно обновлен
                            </div>

                            <form action="updateUser" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Name</label>
                                            <input type="text"
                                                   class="form-control<?php if ($error_login) echo ' @error(\'name\') is-invalid @enderror'; ?>"
                                                   name="login" id="name"
                                                   value="<?php echo $_SESSION['auth_username']; ?>" disabled>
                                            <span class="invalid-feedback" role="alert">
                                            <strong><?php echo $error_login; ?></strong>
                                        </span>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Email</label>
                                            <input type="email"
                                                   class="form-control<?php if ($error_email) echo ' @error(\'email\') is-invalid @enderror'; ?>"
                                                   name="email" id="email"
                                                   value="<?php echo $_SESSION['auth_email']; ?>">
                                            <span class="invalid-feedback" role="alert">
                                            <strong><?php echo $error_email; ?></strong>
                                        </span>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Аватар</label>
                                            <input type="file" class="form-control" name="image"
                                                   id="exampleFormControlInput1">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="../images/<?php echo $_SESSION['user_photo']; ?>" alt=""
                                             class="img-fluid">
                                    </div>

                                    <div class="col-md-12">
                                        <button class="btn btn-warning">Edit profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-header"><h3>Безопасность</h3></div>

                        <div class="card-body">
                            <div class="alert alert-success<?php if ($updatedPassword != 'true') echo ' d-none'; ?>"
                                 role="alert">
                                Пароль успешно обновлен
                            </div>

                            <form action="updatePassword" method="post">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="password">Current password</label>
                                            <input type="password" name="oldPassword"
                                                   class="form-control<?php if ($error_password) echo ' @error(\'password\') is-invalid @enderror'; ?>"
                                                   id="password">
                                            <span class="invalid-feedback" role="alert">
                                            <strong><?php echo $error_password; ?></strong>
                                        </span>
                                        </div>

                                        <div class="form-group">
                                            <label for="new_password">New password</label>
                                            <input type="password" name="newPassword"
                                                   class="form-control<?php if ($error_new_password) echo ' @error(\'new_password\') is-invalid @enderror'; ?>"
                                                   id="new_password">
                                            <span class="invalid-feedback" role="alert">
                                            <strong><?php echo $error_new_password; ?></strong>
                                        </span>
                                        </div>

                                        <button class="btn btn-success">Change password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $this->stop() ?>