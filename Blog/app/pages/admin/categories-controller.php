<?php 
$query = "SELECT * FROM users WHERE id=:id";
$row = query_row($query, ['id'=>$id]);
//ADD NEW
if($action == 'add')
{
    if(!empty($_POST))
    {
        $errors = [];
        if (empty($_POST['category'])) 
        {
            $errors['category']= "A category is required";
        } else if (!preg_match("/^[a-zA-Z]+$/",     $_POST['category'])) 
        {
            $errors['category'] = "Category can only have letters and no numbers";
        }

        $slug = str_to_url($_POST['category']);
        $query = "SELECT id FROM categories WHERE slug = :slug limit 1";
        $slug_row = query($query, ['slug' => $slug]);

        if($slug)
        {
            $slug .= rand(1000,9999);
        }
        
        //INSERT IN TO DATABASE
        if (empty($errors)) 
        {
            $data = [];
            $data['category']   = $_POST['category'];
            $data['slug']       = $slug;
            $data['disabled']   = $_POST['disabled'];

            $query = "INSERT INTO categories (category,slug,disabled) VALUES (:category,:slug,:disabled)";
            query($query, $data);

            redirect('admin/categories');
        }
    }
} else
//EDIT
if($action == 'edit')
{
    $query = "SELECT * FROM categories WHERE id=:id LIMIT 1";
    $row = query_row($query, ['id'=>$id]);
    //validate
    if($row)
    {
        if(!empty($_POST))
        {
            $errors = [];
            if (empty($_POST['category'])) 
            {
                $errors['category']= "A category is required";
            } else if (!preg_match("/^[a-zA-Z]+$/",     $_POST['category'])) 
            {
                $errors['category'] = "Category can only have letters and no numbers";
            }

        //INSERT IN TO DATABASE
            if (empty($errors)) 
            {
                $data = [];
                $data['category'] = $_POST['category'];
                $data['disabled'] = $_POST['disabled'];
                $data['id'] = $id;

                $query = "UPDATE categories SET category = :category, disabled = :disabled WHERE id=:id";
                query($query, $data);

                redirect('admin/categories');
            }
        }
    }
}else
//DELETE
if($action == 'delete')
{
    $query = "SELECT * FROM categories WHERE id=:id LIMIT 1";
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

                $query = "DELETE FROM categories WHERE id=:id";
                query($query, $data);

                redirect('admin/categories');
            }
        }
    }
}
?>