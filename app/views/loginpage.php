<?php
$this->layout('template', ['title' => 'User Profile']) ?>
<?php $this->start('loginform') ?>
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Login</div>

                        <div class="card-body">
                            <form method="POST" action="loginUser">

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail
                                        Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                               class="form-control<?php if ($error_email) echo ' @error(\'email\') is-invalid @enderror'; ?>"
                                               name="email" autocomplete="email" autofocus>
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
                                               name="password" autocomplete="current-password">
                                        <span class="invalid-feedback" role="alert">
                                                <strong><?php echo $error_password; ?></strong>
                                            </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                   id="remember">

                                            <label class="form-check-label" for="remember">
                                                Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Login
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