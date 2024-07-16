<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Log in</title>

    <!-- Bootstrap -->
    <link href="<?= base_url() ?>/public/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url() ?>/public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?= base_url() ?>/public/css/custom.min.css" rel="stylesheet">
    <style>
        .login-wrapper {
            background-color: #ffffff;
            border: 1px solid #dddfe2;
            border-radius: 8px;
            padding: 40px;
            max-width: 750px; /* Increased by 0.5 times from 500px to 750px */
            margin: 50px auto;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-header h1 {
            color: #1877f2;
            font-size: 36px;
            font-weight: bold;
        }

        .login-header h2 {
            font-size: 22px;
            margin-bottom: 20px;
            color: #606770;
        }

        .login-form input[type="password"],
        .login-form select {
            margin-bottom: 10px;
            height: 45px;
            font-size: 18px;
            width: 100%; /* Increase width */
        }

        .login-form input[type="submit"] {
            background-color: #1877f2;
            border-color: #1877f2;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            height: 45px;
            width: 100%; /* Increase width */
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
        }

        body {
            background: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-header">
            <h1>Inventori</h1>
            <br>
        </div>
        <form class="login-form" method="post" action="<?= base_url() ?>/login/auth">
            <?php echo session()->getFlashdata('message'); ?>
            <div class="form-group">
                <select class="form-control" id="nama" name="nama" required>
                    <option value="" disabled selected>Select User</option>
                    <?php for ($i = 0; $i < count($user); $i++) : ?>
                        <option value="<?= $user[$i]["id"] ?>"><?= $user[$i]["id"] . ". " . $user[$i]["nama"] ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required />
            </div>
            <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" value="Log in" />
            </div>
        </form>
        <div class="login-footer">
            <p><a href="#">Forgot Password?</a></p>
        </div>
    </div>
</body>

</html>
