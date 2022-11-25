<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Login</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="<?= base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>/assets/css/style.css" rel="stylesheet" type="text/css">

</head>


<body>


    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">

        <div class="card">
            <div class="card-body">

                <h3 class="text-center mt-0 m-b-15">
                    <a href="index.html" class="logo logo-admin"><img src="<?= base_url() ?>/assets/images/logo.png" height="24" alt="logo"></a>
                </h3>

                <div class="p-3">

                    <?= form_open('auth/auth/cekuser', ['class' => 'formlogin']); ?>
                    <?= csrf_field(); ?>
                    <form class="form-horizontal m-t-20" action="index.html">

                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" type="text" placeholder="Username" name="username" id="username" autofocus>
                                <div class="invalid-feedback errorUsername">

                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" type="password" placeholder="Password" name="password" id="password">
                                <div class="invalid-feedback errorPassword">

                                </div>
                            </div>
                        </div>



                        <div class="form-group text-center row m-t-20">
                            <div class="col-12">
                                <button class="btn btn-danger btn-block waves-effect waves-light btnlogin" type="submit">Log In</button>
                            </div>
                        </div>

                        <div class="form-group m-t-10 mb-0 row">
                        </div>
                    </form>
                </div>
                <?= form_close(); ?>

            </div>
        </div>
    </div>



    <!-- jQuery  -->
    <script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/popper.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/modernizr.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/waves.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery.slimscroll.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery.nicescroll.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery.scrollTo.min.js"></script>

    <!-- App js -->
    <script>
        $(document).ready(function() {
            $('.formlogin').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $('.btnlogin').prop('disabled', true);
                        $('.btnlogin').html('<i class="fa fa-spin fa-spinner"></i>')
                    },
                    complete: function() {
                        $('.btnlogin').prop('disabled', false);
                        $('.btnlogin').html('Login')
                    },
                    success: function(response) {
                        if (response.error) {
                            if (response.error.username) {
                                $('#username').addClass('is-invalid');
                                $('.errorUsername').html(response.error.username);
                            } else {
                                $('#username').removeClass('is-invalid');
                                $('.errorUsername').html('');
                            }
                            if (response.error.password) {
                                $('#password').addClass('is-invalid');
                                $('.errorPassword').html(response.error.password);
                            } else {
                                $('#password').removeClass('is-invalid');
                                $('.errorPassword').html('');
                            }
                        }
                        if (response.sukses) {
                            window.location = response.sukses.link;
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
                return false;
            });
        });
    </script>

</body>

</html>