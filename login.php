<?php
  session_start();

  if (isset($_SESSION['usuario'])) {
    header('Location: /gym/');
  }
  $hostname = "sql112.epizy.com";
  $user = "epiz_28718908";
  $password = "weqmXe12345";

  $conn = mysqli_connect($hostname, $user, $password,"epiz_28718908_diario");
  $conn -> set_charset("utf8");

  if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $user_id = $_POST['username'];
    $query_user = "SELECT * FROM login WHERE user = '$user_id'";
    $result_user = $conn->query($query_user);
    //$stmt = $conn->prepare('SELECT user, pass FROM login WHERE user = $user_id');
    //$stmt->bind_param('s', $_SESSION['user_id']); // 's' specifies the variable type => 'string'
    //$stmt->execute();
    //$result_user = $stmt->get_result();
    //print_r($result_user);
    $row_user = mysqli_num_rows($result_user);
    //print_r($row_user);
    if ($row_user > 0) {
        $user_row = mysqli_fetch_array($result_user);
        $user_nr = $user_row[0];
        $user_name= $user_row[1];
        $user_pass = $user_row[2];
    
        $message = '';

        if ($_POST['password']==$user_pass) {
            $_SESSION['usuario'] = $user_name;
            header("Location: /gym/");
        } 
        else {
            $message = 'Sorry, those credentials do not match';
          }
    }
    else {
      $message = 'Sorry, those credentials do not match';
    }
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
     <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     
    <title>Minimalist Zen Blog</title>
</head>
<body> 
<div>
    <div >
        <div >
            <div >
                <div>
                <?php if(!empty($message)): ?>
                <p> <?= $message ?></p>
                <?php endif; ?>
                    <!-- form card login -->
                    <div >
                        <div >
                            <h3 >Login</h3>
                        </div>
                        <div>
                            <form role="form" autocomplete="new-user" id="formLogin" novalidate="" method="POST">
                                <div >
                                    <label for="username">Username</label>
                                    <input type="text"  name="username" id="username" required="">
                                    
                                </div>
                                <div >
                                    <label for="password">Password</label>
                                    <input type="password"  name="password" id="password" required="" autocomplete="new-password">
                                    
                                </div>
                                
                                <button type="submit" id="btnLogin">Login</button>
                            </form>
                        </div>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->

                </div>


            </div>
            <!--/row-->

        </div>
        <!--/col-->
    </div>
    <!--/row-->
</div>
<!--/container-->

</body>
</html>