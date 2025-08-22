<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Dashboard</title>
    <meta name="description" content="Library Management Admin Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="./css/admin_style.css" rel="stylesheet">
   
</head>
<body>
    <!-- Alert Messages -->
    <?php
    include("data_class.php");
    $msg = "";
    if (!empty($_REQUEST['msg'])) {
        $msg = $_REQUEST['msg'];
    }

    if ($msg == "done"|| $msg=="New Add done") {
        echo "<div class='alert alert-success' role='alert'>Successfully Done</div>";
    } elseif ($msg == "fail" || $msg=="Register Fail") {
        echo "<div class='alert alert-danger' role='alert'>Failed</div>";
    }
    ?>

    <div class="dashboard-container">
        <div class="header">
            <img class="logo" src="images/logo.png" alt="Library Logo"/>
        </div>

        <button class="mobile-menu-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i> Menu
        </button>

        <div class="dashboard-layout">
            <!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <button class="close-sidebar" onclick="closeSidebar()">&times;</button>
                
                <button class="nav-button" onclick="openSection('addbook',event)">
                    <i class="fas fa-book"></i> ADD BOOK
                </button>
                <button class="nav-button" onclick="openSection('bookreport',event)">
                    <i class="fas fa-book-open"></i> BOOK REPORT
                </button>
                <button class="nav-button" onclick="openSection('bookrequestapprove',event)">
                    <i class="fas fa-clipboard-check"></i> BOOK REQUESTS
                </button>
                <button class="nav-button" onclick="openSection('addperson',event)">
                    <i class="fas fa-user-plus"></i> ADD PERSON
                </button>
                <button class="nav-button" onclick="openSection('studentrecord',event)">
                    <i class="fas fa-users"></i> PERSON RECORD
                </button>
                <button class="nav-button" onclick="openSection('issuebook',event)">
                    <i class="fas fa-hand-holding"></i> ISSUE BOOK
                </button>
                <button class="nav-button" onclick="openSection('issuebookreport',event)">
                    <i class="fas fa-list-check"></i> ISSUE REPORT
                </button>
                <a href="index.php">
                    <button class="nav-button">
                        <i class="fas fa-sign-out-alt"></i> LOGOUT
                    </button>
                </a>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Add Book Section -->
                <div id="addbook" class="content-section <?php if(empty($_REQUEST['viewid'])) echo 'active'; ?>">
                    <div class="section-title">ADD NEW BOOK</div>
                    <form action="./Logic/addbookserver_page.php" method="post" enctype="multipart/form-data" class="form-container">
                        <div class="form-group">
                            <label>Book Name:</label>
                            <input type="text" name="bookname" class="form-control" required/>
                        </div>
                        
                        <div class="form-group">
                            <label>Detail:</label>
                            <input type="text" name="bookdetail" class="form-control"/>
                        </div>
                        
                        <div class="form-group">
                            <label>Author:</label>
                            <input type="text" name="bookauthor" class="form-control"/>
                        </div>
                        
                        <div class="form-group">
                            <label>Publication:</label>
                            <input type="text" name="bookpub" class="form-control"/>
                        </div>
                        
                        <div class="form-group">
                            <label>Branch:</label>
                            <div class="radio-group">
                                <div class="radio-item">
                                    <input type="radio" name="branch" value="other" id="other"/>
                                    <label for="other">Other</label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" name="branch" value="IT" id="it"/>
                                    <label for="it">IT</label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" name="branch" value="CS" id="cs"/>
                                    <label for="cs">CS</label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" name="branch" value="CSIT" id="csit"/>
                                    <label for="csit">CSIT</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Price:</label>
                            <input type="number" name="bookprice" class="form-control"/>
                        </div>
                        
                        <div class="form-group">
                            <label>Quantity:</label>
                            <input type="number" name="bookquantity" class="form-control"/>
                        </div>
                        
                        <div class="form-group">
                            <label>Book Photo:</label>
                            <input type="file" name="bookphoto" class="form-control" accept="image/*"/>
                        </div>
                        
                        <button type="submit" class="submit-btn">SUBMIT</button>
                    </form>
                </div>

                <!-- Book Report Section -->
                <div id="bookreport" class="content-section ">
                    <div class="section-title">BOOK REPORT</div>
                    <div class="table-responsive">
                        <?php
                        $u = new data;
                        $u->setconnection();
                        $recordset = $u->getbook();

                        echo "<table class='custom-table'>";
                        echo "<tr><th>Book Name</th><th>Price</th><th>Quantity</th><th>Available</th><th>Rented</th><th>Action</th></tr>";
                        
                        foreach($recordset as $row){
                            echo "<tr>";
                            echo "<td>$row[2]</td>";
                            echo "<td>$row[7]</td>";
                            echo "<td>$row[8]</td>";
                            echo "<td>$row[9]</td>";
                            echo "<td>$row[10]</td>";
                            echo "<td><a href='admin_service_dashboard.php?viewid=$row[0]' class='btn-action btn-primary'>View Book</a></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        ?>
                    </div>
                </div>

                <!-- Book Request Approve Section -->
                <div id="bookrequestapprove" class="content-section">
                    <div class="section-title">BOOK REQUEST APPROVAL</div>
                    <div class="table-responsive">
                        <?php
                        $u = new data;
                        $u->setconnection();
                        $recordset = $u->requestbookdata();

                        echo "<table class='custom-table'>";
                        echo "<tr><th>Person Name</th><th>Person Type</th><th>Book Name</th><th>Days</th><th>Action</th></tr>";
                        
                        foreach($recordset as $row){
                            echo "<tr>";
                            echo "<td>$row[3]</td>";
                            echo "<td>$row[4]</td>";
                            echo "<td>$row[5]</td>";
                            echo "<td>$row[6]</td>";
                            echo "<td><a href='./Logic/approvebookrequest.php?reqid=$row[0]&book=$row[5]&userselect=$row[3]&days=$row[6]' class='btn-action btn-primary'>Approve</a></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        ?>
                    </div>
                </div>

                <!-- Add Person Section -->
                <div id="addperson" class="content-section">
                    <div class="section-title">ADD PERSON</div>
                    <form action="./Logic/addpersonserver_page.php" method="post" class="form-container">
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" name="addname" class="form-control" required/>
                        </div>
                        
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" name="addpass" class="form-control" required/>
                        </div>
                        
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="addemail" class="form-control" required/>
                        </div>
                        
                        <div class="form-group">
                            <label>Choose Type:</label>
                            <select name="type" class="form-control">
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="submit-btn">SUBMIT</button>
                    </form>
                </div>

                <!-- Person Record Section -->
                <div id="studentrecord" class="content-section">
                    <div class="section-title">PERSON RECORD</div>
                    <div class="table-responsive">
                        <?php
                        $u = new data;
                        $u->setconnection();
                        $recordset = $u->userdata();

                        echo "<table class='custom-table'>";
                        echo "<tr><th>Name</th><th>Email</th><th>Type</th></tr>";
                        
                        foreach($recordset as $row){
                            echo "<tr>";
                            echo "<td>$row[1]</td>";
                            echo "<td>$row[2]</td>";
                            echo "<td>$row[4]</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        ?>
                    </div>
                </div>

                <!-- Issue Book Section -->
                <div id="issuebook" class="content-section">
                    <div class="section-title">ISSUE BOOK</div>
                    <form action="./Logic/issuebook_server.php" method="post" class="form-container">
                        <div class="form-group">
                            <label>Choose Book:</label>
                            <select name="book" class="form-control">
                                <?php
                                $u = new data;
                                $u->setconnection();
                                $recordset = $u->getbookissue();
                                foreach($recordset as $row){
                                    echo "<option value='$row[2]'>$row[2]</option>";
                                }            
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Select Person:</label>
                            <select name="userselect" class="form-control">
                                <?php
                                $u = new data;
                                $u->setconnection();
                                $recordset = $u->userdata();
                                foreach($recordset as $row){
                                    echo "<option value='$row[1]'>$row[1]</option>";
                                }            
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Days:</label>
                            <input type="number" name="days" class="form-control" required/>
                        </div>
                        
                        <button type="submit" class="submit-btn">SUBMIT</button>
                    </form>
                </div>

                <!-- Issue Book Report Section -->
                <div id="issuebookreport" class="content-section">
                    <div class="section-title">ISSUE BOOK RECORD</div>
                    <div class="table-responsive">
                        <?php
                        $u = new data;
                        $u->setconnection();
                        $recordset = $u->issuereport();

                        echo "<table class='custom-table'>";
                        echo "<tr><th>Issue Name</th><th>Book Name</th><th>Issue Date</th><th>Return Date</th><th>Fine</th><th>Issue Type</th></tr>";
                        
                        foreach($recordset as $row){
                            echo "<tr>";
                            echo "<td>$row[2]</td>";
                            echo "<td>$row[3]</td>";
                            echo "<td>$row[6]</td>";
                            echo "<td>$row[7]</td>";
                            echo "<td>$row[8]</td>";
                            echo "<td>$row[4]</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        ?>
                    </div>
                </div>

                <!-- Book Detail Section -->
                <div id="bookdetail" class="content-section <?php if(!empty($_REQUEST['viewid'])) echo 'active'; ?>">
                    <div class="section-title">BOOK DETAIL</div>
                    <?php
                    if(!empty($_REQUEST['viewid'])){
                        $viewid = $_REQUEST['viewid'];
                        $u = new data;
                        $u->setconnection();
                        $recordset = $u->getbookdetail($viewid);
                        foreach($recordset as $row){
                            $bookimg = $row[1];
                            $bookname = $row[2];
                            $bookdetail = $row[3];
                            $bookauthor = $row[4];
                            $bookpub = $row[5];
                            $branch = $row[6];
                            $bookprice = $row[7];
                            $bookquantity = $row[8];
                            $bookava = $row[9];
                            $bookrent = $row[10];
                        }
                        
                        echo "<div class='book-detail'>";
                        echo "<div>";
                        echo "<img class='book-image' src='uploads/$bookimg' alt='Book Cover'/>";
                        echo "</div>";
                        echo "<div class='book-info'>";
                        echo "<p><u>Book Name:</u> $bookname</p>";
                        echo "<p><u>Book Detail:</u> $bookdetail</p>";
                        echo "<p><u>Book Author:</u> $bookauthor</p>";
                        echo "<p><u>Book Publisher:</u> $bookpub</p>";
                        echo "<p><u>Book Branch:</u> $branch</p>";
                        echo "<p><u>Book Price:</u> $bookprice</p>";
                        echo "<p><u>Book Available:</u> $bookava</p>";
                        echo "<p><u>Book Rent:</u> $bookrent</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="./js/admin_service_dashboard_script.js" ></script>
</body>
</html>