<?php

$this->layout('template', ['title' => 'User Profile']) ?>

<?php $this->start('registerform') ?>
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Register</div>

                        <div class="card-body">
                            <form method="POST" action="registerUser">

                                <div class="form-group row">
                                    <label for="username" class="col-md-4 col-form-label text-md-right">Name</label>

                                    <div class="col-md-6">
                                        <input id="username" type="text"
                                               class="form-control<?php if ($error_login) echo ' @error(\'name\') is-invalid @enderror'; ?>"
                                               name="username" autofocus>

                                        <span class="invalid-feedback" role="alert">
                                                <strong><?php echo $error_login; ?></strong>
                                            </span>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                               class="form-control<?php if ($error_email) echo ' @error(\'email\') is-invalid @enderror'; ?>"
                                               name="email">
                                        <span class="invalid-feedback" role="alert">
                                                <strong><?php echo $error_email; ?></strong>
                                            </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                               class="form-control<?php if ($error_password) echo ' @error(\'password\') is-invalid @enderror'; ?>"
                                               name="password" autocomplete="new-password">
                                        <span class="invalid-feedback" role="alert">
                                                <strong><?php echo $error_password; ?></strong>
                                            </span>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Register
                                        </button>
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