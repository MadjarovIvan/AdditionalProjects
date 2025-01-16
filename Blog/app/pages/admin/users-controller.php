<?php 
$query = "SELECT * FROM users WHERE id=:id";
$row = query_row($query, ['id'=>$id]);
//ADD NEW
if($action == 'add')
{
    if(!empty($_POST))
    {
        $errors = [];
        if (empty($_POST['username'])) {
            $errors['username']= "A username is required";
        } else if (!preg_match("/^[a-zA-Z]+$/",     $_POST['username'])) {
        $errors['username'] = "Username can only have letters and no numbers";
        }

        $query = "SELECT id FROM users WHERE email = :email limit 1";
        $email = query($query, ['email' => $_POST['email']]);
        
        if (empty($_POST['email'])) {
            $errors['email']= "A email is required";
        } else if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "That email is already in use";
        }
        
        if (empty($_POST['password'])) {
            $errors['password']= "A password is required";
        } else if (strlen($_POST['password'] < 8)) {
            $errors['password'] = "Password must be at least 8 characters";
        } 
        else if ($_POST['password'] !== $_POST['retype_password']) {
            $errors['password'] = "Passwords do not match";
        }

        //INSERT IN TO DATABASE
        if (empty($errors)) {
            $data = [];
            $data['username'] = $_POST['username'];
            $data['email']    = $_POST['email'];
            $data['role']     = "user";
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $query = "INSERT INTO users (username,email,password,role) VALUES (:username,:email,:password,:role)";
            query($query, $data);

            redirect('admin/users');
        }
    }
} else
//EDIT
if($action == 'edit')
{
$query = "SELECT * FROM users WHERE id=:id LIMIT 1";
$row = query_row($query, ['id'=>$id]);
//validate
if($row)
{
    if(!empty($_POST))
    {
    $errors = [];
    //username
    if (empty($_POST['username'])) {
        $errors['username']= "A username is required";
    } else if (!preg_match("/^[a-zA-Z]+$/", $_POST['username'])) {
        $errors['username'] = "Username can only have letters and no numbers";
    }
    //email
    $query = "SELECT id FROM users WHERE email = :email && id != :id limit 1";
    $email = query($query, ['email' => $_POST['email'], 'id'=>$id]);
    if (empty($_POST['email'])) {
        $errors['email']= "A email is required";
    } else if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "That email is already in use";
    }
    //password
    // if (strlen($_POST['password'] < 8)) {
    //   $errors['password'] = "Password must be at least 8 characters";
    // } 
    // else if ($_POST['password'] !== $_POST['retype_password']) {
    //   $errors['password'] = "Passwords do not match";
    // }

    $allowed = ['image/jpeg', 'image/png','image/webp'];
    if(!empty($_FILES['image']['name'])){
        $destination = "";
        if(in_array($_FILES['image']['type'], $allowed)){
            $errors['image'] = "Image format not supported";
        } else
        {
            $folder = "uploads/";
            if(!file_exists($folder)){
                mkdir($folder, 077, true);
            }
            $destination = $folder . time() . $_FILES['image']['name'];
            move_uploaded_file(['image']['tmp_name'], $destination); 
        }
    }
    //INSERT IN TO DATABASE
    if (empty($errors)) {
        $data = [];
        $data['username'] = $_POST['username'];
        $data['email']    = $_POST['email'];
        $data['role']     = $row['role'];
        $data['id']     = $id;
        if (empty($_POST['password'])) {
        $query = "UPDATE users SET username = :username, email = :email, role = :role WHERE id=:id";
        } else {
        
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "UPDATE users SET username = :username, email = :email, password = :password, role = :role WHERE id=:id";
        }
        query($query, $data);

        redirect('admin/users');
    }
    }
}
}else
//DELETE
if($action == 'delete')
{
$query = "SELECT * FROM users WHERE id=:id LIMIT 1";
$row = query_row($query, ['id'=>$id]);
// echo "<pre>";
// print_r($_SERVER['REQUEST_METHOD']);
//validate
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($row)
    {
    $errors = [];
    if (empty($errors)) {
        $data = [];
        $data['id'] = $id;

        $query = "DELETE FROM users WHERE id=:id";
        query($query, $data);

        redirect('admin/users');
    }
    }
}
}
?>