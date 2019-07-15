<?php
    session_start();
    require "functions.php";

    if(isset($_COOKIE['card']) && isset($_COOKIE['key'])){
        $id = $_COOKIE['card'];
        $key = $_COOKIE['key'];

        //ambil username berdasarkan id
        $result = mysqli_query($conn, "SELECT username FROM users WHERE id = $id");
        $row = mysqli_fetch_assoc($result);

        //cek cookie dan username
        if($key === hash('sha256', $row['username'])){
            $_SESSION['login'] = true;
        }
    }

    if(isset($_SESSION['login'])){
        header("Location: index.php");
    }

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        //cek username
        if(mysqli_num_rows($result) === 1){
            //cek password
            $row = mysqli_fetch_assoc($result); 
            //mencocokan password dengan hash
            if(password_verify($password, $row['password'])){
                //set session
                $_SESSION['login'] = true;

                //cek remember me
                if(isset($_POST['remember'])){
                    //buat cookie
                    setcookie('card', $row['id'], time()+60);
                    setcookie('key', hash('sha256', $row['username']), time()+60);
                }
                
                header("Location: index.php");
                exit;
            }

        }

        $error = true;
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Login</title>
</head>
<body>
    
    <h1>Halaman Login</h1>

    <?php if(isset($error)){?>
        <p style="color:red; font-style:italic;">Username/password salah!</p>
    <?php } ?>

    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username : </label>
                <input type="text" name="username" id="username">
            </li>
        </ul>
        <ul>
            <li>
                <label for="password">Password : </label>
                <input type="password" name="password" id="password">
            </li>
        </ul>
        <ul>
            <li>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember</label>
            </li>
        </ul>
        <ul>
            <li>
                <button type="submit" name="login">Login</button>
            </li>
        </ul>
    </form>

</body>
</html>