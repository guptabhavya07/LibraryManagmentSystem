<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Portal</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/index_style.css" rel="stylesheet">
  
</head>
<body>
    <?php
    $emailmsg = "";
    $pasdmsg = "";
    $msg = "";
    $ademailmsg = "";
    $adpasdmsg = "";

    if (!empty($_REQUEST['ademailmsg'])) {
        $ademailmsg = $_REQUEST['ademailmsg'];
    }

    if (!empty($_REQUEST['adpasdmsg'])) {
        $adpasdmsg = $_REQUEST['adpasdmsg'];
    }

    if (!empty($_REQUEST['emailmsg'])) {
        $emailmsg = $_REQUEST['emailmsg'];
    }

    if (!empty($_REQUEST['pasdmsg'])) {
        $pasdmsg = $_REQUEST['pasdmsg'];
    }

    if (!empty($_REQUEST['msg'])) {
        $msg = $_REQUEST['msg'];
    }
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="login-container">
                <!-- Main Title Screen -->
                <div id="titleScreen">
                    <h1 class="main-title">Welcome to Login Portal</h1>
                    <!-- for giving invalid credentials -->
                    <?php if ($msg): ?>
                        <div class="alert alert-info"><?php echo $msg; ?></div>
                    <?php endif; ?>
                    <div class="d-flex flex-column">
                        <button class="login-option admin-option" onclick="showLogin('admin')">
                            Admin Login
                        </button>
                        <button class="login-option student-option" onclick="showLogin('student')">
                            User Login
                        </button>
                    </div>
                </div>

                <!-- Admin Login Form -->
                <div id="adminLogin" class="login-form">
                    <button class="back-btn" onclick="showTitle()">← Back</button>
                    <h3>Admin Login</h3>
                    <form action="./Logic/loginadmin_server_page.php" method="get" autocomplete="off">
                        <div class="form-group">
                            <input type="text" class="form-control" name="login_email" 
                                   placeholder="Your Email *" value=""  />
                            <?php if ($ademailmsg): ?>
                                <div class="error-msg">*<?php echo $ademailmsg; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="login_pasword" 
                                   placeholder="Your Password *" value=""  />
                            <?php if ($adpasdmsg): ?>
                                <div class="error-msg">*<?php echo $adpasdmsg; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btnSubmit" value="Login" />
                        </div>
                    </form>
                </div>

                <!-- Student Login Form -->
                <div id="studentLogin" class="login-form">
                    <button class="back-btn" onclick="showTitle()">← Back</button>
                    <h3>User Login</h3>
                    <form action="./Logic/login_server_page.php" method="get">
                        <div class="form-group">
                            <input type="text" class="form-control" name="login_email" 
                                   placeholder="Your Email *" value=""  />
                            <?php if ($emailmsg): ?>
                                <div class="error-msg">*<?php echo $emailmsg; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="login_pasword" 
                                   placeholder="Your Password *" value=""  />
                            <?php if ($pasdmsg): ?>
                                <div class="error-msg">*<?php echo $pasdmsg; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btnSubmit" value="Login" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showLogin(type) {
            document.getElementById('titleScreen').style.display = 'none';
            if (type === 'admin') {
                document.getElementById('adminLogin').style.display = 'block';
                document.getElementById('studentLogin').style.display = 'none';
            } else {
                document.getElementById('studentLogin').style.display = 'block';
                document.getElementById('adminLogin').style.display = 'none';
            }
        }

        function showTitle() {
            document.getElementById('titleScreen').style.display = 'block';
            document.getElementById('adminLogin').style.display = 'none';
            document.getElementById('studentLogin').style.display = 'none';
        }

        // Show appropriate form if there are error messages
        <?php if ($ademailmsg || $adpasdmsg): ?>
            showLogin('admin');
        <?php elseif ($emailmsg || $pasdmsg): ?>
            showLogin('student');
        <?php endif; ?>
    </script>
</body>
</html>