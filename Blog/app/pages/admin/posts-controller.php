<?php 
$query = "SELECT * FROM posts WHERE id=:id";
$row = query_row($query, ['id'=>$id]);
//ADD NEW
if($action == 'add')
{
    if(!empty($_POST))
    {
        $errors = [];
        if (empty($_POST['title'])) 
        {
            $errors['title']= "A title is required";
        }

        if(empty($_POST['category_id']))
        {
            $errors['category_id'] = "A category is required";
        }

        // validate image
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        if(!empty($_FILES['image']['type']))
        {
            $destination="";
            if(!in_array($_FILES['image']['type'], $allowed))
            {
                $errors['image'] = "Image format not supported";
            }else
            {
                $folder = "uploads/";
                if(!file_exists($folder))
                {
                    mkdir($folder, 0777, true);
                }
                $destination = $folder .time() . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                resize_image($destination);
            }
        }else{
            $errors['image'] = "Image is required";
        }

        $slug = str_to_url($_POST['title']);
        $query = "SELECT id FROM posts WHERE slug = :slug limit 1";
        $slug_row = query($query, ['slug' => $slug]);

        if($slug)
        {
            $slug .= rand(1000,9999);
        }

        //INSERT IN TO DATABASE
        if (empty($errors)) {
            $data = [];
            $data['title'] = $_POST['title'];
            $data['content']    = $_POST['content'];
            $data['slug']       = $slug;
            $data['category_id']   = $_POST['category_id'];
            $data['user_id']    = user('id');

            $query = "INSERT INTO posts (title,content,slug,category_id, user_id) VALUES (:title,:content,:slug, :category_id, :user_id)";
            
            if(!empty($destination))
            {
                $data['image'] = $destination;
                $query = "INSERT INTO posts (title,content,slug,category_id, user_id, image) VALUES (:title,:content,:slug, :category_id, :user_id, :image)";
            }

            query($query, $data);
            redirect('admin/posts');
        }
    }
} else
//EDIT
if($action == 'edit')
{
    $query = "SELECT * FROM posts WHERE id=:id LIMIT 1";
    $row = query_row($query, ['id'=>$id]);
    //validate
    if($row)
    {
        if(!empty($_POST))
        {
            $errors = [];
            if (empty($_POST['title'])) 
            {
                $errors['title']= "A title is required";
            }

            if(empty($_POST['category_id']))
            {
                $errors['category_id'] = "A category is required";
            }

            // validate image
            $allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if(!empty($_FILES['image']['type']))
            {
                $destination="";
                if(!in_array($_FILES['image']['type'], $allowed))
                {
                    $errors['image'] = "Image format not supported";
                }else
                {
                    $folder = "uploads/";
                    if(!file_exists($folder))
                    {
                        mkdir($folder, 0777, true);
                    }
                    $destination = $folder .time() . $_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                    resize_image($destination);
                }
            }
            //INSERT IN TO DATABASE
            if (empty($errors)) 
            {
                $data = [];
                $data['title'] = $_POST['title'];
                $data['content']    = $_POST['content'];
                $data['category_id']     = $_POST['category_id'];
                $data['id']     = $id;
                
                $query = "INSERT INTO posts (title, content, category_id) VALUES (:title,:content,:category_id)";

                $image_str = "";
                
                if(!empty($destination))
                {
                    $image_str= "image = :image, ";
                    $data['image'] = $destination;
                }
                
                $query = "UPDATE posts SET title = :title, content = :content, $image_str category_id = :category_id WHERE id = :id";
                query($query, $data);

                redirect('admin/posts');
            }
        }
    }
}else
//DELETE
if($action == 'delete')
{
$query = "SELECT * FROM posts WHERE id=:id LIMIT 1";
$row = query_row($query, ['id'=>$id]);

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($row)
    {
    $errors = [];
    if (empty($errors)) 
    {
        $data = [];
        $data['id'] = $id;

        $query = "DELETE FROM posts WHERE id=:id";
        query($query, $data);

        if (file_exists($row['image'])) 
        {
            unlink($row['image']);
        }

        redirect('admin/posts');
    }
    }
}
}
?>