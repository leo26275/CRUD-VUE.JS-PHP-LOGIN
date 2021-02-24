<?php

    include '../config/Connection.php';
    session_start();

    $resul = array('error'=> false);
    $action = '';

    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }

    if($action == 'read'){
        $sql = $conn->query("SELECT * FROM user");
        $users = array();
        while($row = $sql-> fetch_assoc()){
            array_push($users,$row);
        }
        $resul['users']=$users;
    }

    if($action == 'create'){
        $user = $_POST['user'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = $conn->query("INSERT INTO user (user, password, email) VALUES ('$user', '$password', '$email')");
        
        if($sql){
            $resul['message'] = "User added successfully!";
        }else{
            $resul['error'] = true;
            $resul['message'] = "Username or email already exists!";
        }
    }

    if($action == 'update'){
        $iduser = $_POST['iduser'];
        $user = $_POST['user'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = $conn->query("UPDATE user SET user = '$user', password = '$password', email = '$email' WHERE iduser = '$iduser'");
        
        if($sql){
            $resul['message'] = "User updated successfully!";
        }else{
            $resul['error'] = true;
            $resul['message'] = "Failed to update user!";
        }
    }

    if($action == 'activate'){
        $iduser = $_POST['iduser'];

        $sql = $conn->query("UPDATE user SET state = 0 WHERE iduser = '$iduser'");
        
        if($sql){
            $resul['message'] = "User deactivated successfully!";
        }else{
            $resul['error'] = true;
            $resul['message'] = "Failed to deactivated user!";
        }
    }

    if($action == 'inactivate'){
        $iduser = $_POST['iduser'];

        $sql = $conn->query("UPDATE user SET state = 1 WHERE iduser = '$iduser'");
        
        if($sql){
            $resul['message'] = "User activated successfully!";
        }else{
            $resul['error'] = true;
            $resul['message'] = "Failed to activated user!";
        }
    }

     if($action == 'login'){
        $user = $_POST['user'];
        $password = $_POST['password'];

        $sql = $conn->query("SELECT * FROM user WHERE usuario = '$user' AND clave = '$password'");
        $selectUser = $sql->fetch_row();

        if($selectUser > 0){
            $resul['login'] = $selectUser;
            $resul['message'] = "Welcome! " . $resul['login'][1];
             $_SESSION['user'] = $selectUser;
        }else{
            $resul['error'] = true;
            $resul['message'] = "Incorrect username or password!";
        }
    }

    $conn->close();
    echo json_encode($resul);
?>