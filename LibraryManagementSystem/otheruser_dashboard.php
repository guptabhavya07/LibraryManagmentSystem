<?php
if (isset($_GET['userlogid']) && is_numeric($_GET['userlogid'])) {
    $_SESSION["userid"] = intval($_GET['userlogid']);
    $userloginid = $_SESSION["userid"];
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User Dashboard</title>
    <meta name="description" content="User Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="./js/otheruser_dashboard.js"></script>
    <style>
        .portion {
            display: none;
        }
        .portion.active {
            display: block;
        }
    </style>
</head>
<body class="bg-light">
    <?php include("data_class.php"); ?>
    
    <div class="container py-4">
        <div class="d-flex flex-column align-items-center mb-4">
            <img class="img-fluid mb-4" src="images/logo.png" alt="Logo" style="max-width: 150px;" />

            <div class="row w-100 g-4">
                <div class="col-lg-3 col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <button class="btn btn-primary w-100 mb-2" onclick="openpart('myaccount')">
                                <i class="fas fa-user me-2"></i> My Account
                            </button>
                            <button class="btn btn-primary w-100 mb-2" onclick="openpart('requestbook')">
                                <i class="fas fa-book-open me-2"></i> Request Book
                            </button>
                            <button class="btn btn-primary w-100 mb-2" onclick="openpart('issuereport')">
                                <i class="fas fa-clipboard-list me-2"></i> Book Report
                            </button>
                            <a href="index.php" class="d-block">
                                <button class="btn btn-danger w-100">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-12">
                    <div id="myaccount" class="portion card shadow-sm p-4 active">
                        <h2 class="card-title text-primary mb-4">My Account</h2>
                        <?php
                        $u = new data;
                        $u->setconnection();
                        $recordset = $u->userdetail($userloginid);
                        foreach($recordset as $row) {
                            $id = $row[0];
                            $name = $row[1];
                            $email = $row[2];
                            $pass = $row[3];
                            $type = $row[4];
                        }
                        ?>
                        <p class="lead"><span class="fw-bold">Person Name:</span> <?php echo $name ?></p>
                        <p class="lead"><span class="fw-bold">Person Email:</span> <?php echo $email ?></p>
                        <p class="lead"><span class="fw-bold">Account Type:</span> <?php echo $type ?></p>
                    </div>

                    <div id="issuereport" class="portion card shadow-sm p-4">
                        <h2 class="card-title text-primary mb-4">Book Record</h2>
                        <?php
                        $u = new data;
                        $u->setconnection();
                        $recordset = $u->getissuebook($userloginid);
                        $table = "<div class='table-responsive'><table class='table table-striped table-hover'>
                            <thead class='bg-primary text-white'>
                                <tr>
                                    <th class='p-3'>Name</th>
                                    <th class='p-3'>Book Name</th>
                                    <th class='p-3'>Issue Date</th>
                                    <th class='p-3'>Return Date</th>
                                    <th class='p-3'>Fine</th>
                                    <th class='p-3'>Return</th>
                                </tr>
                            </thead>
                            <tbody>";
                        foreach($recordset as $row) {
                            $table .= "<tr>";
                            $table .= "<td>$row[2]</td>";
                            $table .= "<td>$row[3]</td>";
                            $table .= "<td>$row[6]</td>";
                            $table .= "<td>$row[7]</td>";
                            $table .= "<td>$row[8]</td>";
                            $table .= "<td><a href='otheruser_dashboard.php?returnid=$row[0]&userlogid=$userloginid' class='btn btn-primary'>Return</a></td>";
                            $table .= "</tr>";
                        }
                        $table .= "</tbody></table></div>";
                        echo $table;
                        ?>
                    </div>

                    <div id="return" class="portion card shadow-sm p-4" <?php if(!empty($_REQUEST['returnid'])){ echo 'style="display:block;"'; } ?>>
                        <h2 class="card-title text-primary mb-4">Return Book</h2>
                        <?php
                        if(!empty($_REQUEST['returnid'])){
                            $returnid = $_REQUEST['returnid'];
                            $u = new data;
                            $u->setconnection();
                            $u->returnbook($returnid);
                            echo "<div class='alert alert-success' role='alert'>Book returned successfully.</div>";
                        }
                        ?>
                    </div>

                    <div id="requestbook" class="portion card shadow-sm p-4">
                        <h2 class="card-title text-primary mb-4">Request Book</h2>
                        <?php
                        $u = new data;
                        $u->setconnection();
                        $recordset = $u->getbookissue();
                        $table = "<div class='table-responsive'><table class='table table-striped table-hover'>
                            <thead class='bg-primary text-white'>
                                <tr>
                                    <th class='p-3'>Image</th>
                                    <th class='p-3'>Book Name</th>
                                    <th class='p-3'>Book Author</th>
                                    <th class='p-3'>Branch</th>
                                    <th class='p-3'>Price</th>
                                    <th class='p-3'>Request Book</th>
                                </tr>
                            </thead>
                            <tbody>";
                        foreach($recordset as $row) {
                            $table .= "<tr>";
                            $table .= "<td class='p-3'><img src='uploads/$row[1]' class='img-thumbnail' alt='Book Image' style='width: 64px; height: 64px;'></td>";
                            $table .= "<td class='p-3'>$row[2]</td>";
                            $table .= "<td class='p-3'>$row[4]</td>";
                            $table .= "<td class='p-3'>$row[6]</td>";
                            $table .= "<td class='p-3'>$row[7]</td>";
                            $table .= "<td class='p-3'><a href='./Logic/requestbook.php?bookid=$row[0]&userid=$userloginid'><button class='btn btn-primary'>Request Book</button></a></td>";
                            $table .= "</tr>";
                        }
                        $table .= "</tbody></table></div>";
                        echo $table;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
</body>
</html>