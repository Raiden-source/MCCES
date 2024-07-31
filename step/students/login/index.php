<?php
                                
        require '../../../database/config.php';

        $querys = "SELECT * FROM academic GROUP BY status";
        $querys_run = mysqli_query ($conn, $querys);

        if (mysqli_num_rows($querys_run)>0) {
            
            foreach($querys_run as $rows)
                ?><?php
        }
                                
        ?>
        <?php
                                
        require '../../../database/config.php';

        $querys1 = "SELECT * FROM semester GROUP BY sem_status";
        $querys_run1 = mysqli_query ($conn, $querys1);

        if (mysqli_num_rows($querys_run1)>0) {
            foreach($querys_run1 as $rows1)
                ?><?php
        }
                                
        ?>

                <?php
                                
        require '../../../database/config.php';

        $querys11 = "SELECT * FROM academic WHERE status='1'";
        $querys_run11 = mysqli_query ($conn, $querys11);

        if (mysqli_num_rows($querys_run11)>0) {
            
            foreach($querys_run11 as $rows11)
                ?><?php
        }
                                
        ?>
        <?php
                                
        require '../../../database/config.php';
        $querys111 = "SELECT * FROM semester WHERE sem_status='1'";
        $querys_run111 = mysqli_query ($conn, $querys111);

        if (mysqli_num_rows($querys_run111)>0) {
            foreach($querys_run111 as $rows111)
                ?><?php
        }
                                
        ?>
        

                                
<?php
    session_start();
    // if (isset($_SESSION['SESSION_STUDENTS'])) {
    //     header("Location: ../index.php");
    //     die();
    // }

    include '../../../database/config.php';
    $msg = "";

    

    if (isset($_GET['verify']) && $_GET['verify']) {
        $ver = $_GET['verify'];
        $query = mysqli_query($conn, "UPDATE new_user SET verified_status = '1' WHERE verified_status='$ver'");
        if ($query) {
            $msg = "<div class='alert alert-success'>Account verification has been successfully completed.</div>";
        }
        else{
            $msg = "<div class='alert alert-danger'>Account has not been verified.</div>";
        }
    }

    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = mysqli_real_escape_string($conn, $_POST['password']);

        $password = $password = md5($pass);

        $sql = "SELECT * FROM new_user n LEFT JOIN students s ON n.Id = s.new_user_id WHERE n.email = '$email' AND n.password = '$password' OR s.id_number = '$email' AND n.password = '$password' ";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                if($row['verified_status'] != '1'){
                    $msg = "<div class='alert alert-info'>Account is not yet verified, Please check you email to verified your account.</div>";
                }
                else{
                    $USER_ID = $row['Id'];
                    $_SESSION['SESSION_STUDENTS'] = $email;
    
                    $_SESSION['USER_ID'] = $USER_ID;
    
                    // header("Location: ../index.php?id_number=$id");
                    header("Location: ../../../enroll-now/index.php");
                }
                
            } else {
                $msg = "<div class='alert alert-info'>ID Number Is Not Yet Enroll In This Semester</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>ID Number/Email Account Not Found OR Invalid</div>";
        }
    }
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login | Students</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image" href="../../../icon.png">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>
<div class="loader-wrapper" id="preloader">
      <span class="loader"><span class="loader-inner"></span></span>
    </div>
   <link rel="stylesheet" type="text/css" href="../../../loader/styles.css" />
    <script>
        var loader = document.getElementById("preloader");
        window.addEventListener("load", function(){
          loader.style.display = "none"
        }) 
    </script>

    <!-- form section start -->
    <img class="wave" src="img/wave.png">
    
    <!-- form section start -->
    
    <section class="w3l-mockup-form">
        

        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/mcc2.png" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Login Now | Students</h2>
                        <p>Madridejos Community College </p>
                        
                        <?php echo $msg; ?>
                        
                        <form action="" method="post">
                            <input type="text" class="email" name="email" placeholder="Enter Your ID Number / Email" required>

                            <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
                            
                            
                            <p style="float: left;"><a href="../../../index.php" style="margin-bottom: 15px; display: block; text-align: right;">Back Home</a></p>
                            <p style="float: right ;"><a href="forgot-password.php" style="margin-bottom: 15px; display: block; text-align: left;">Forgot Password</a></p>
                            <button name="submit" name="submit" class="btn" type="submit">Login</button>
                        </form>
                        
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>

</body>

</html>