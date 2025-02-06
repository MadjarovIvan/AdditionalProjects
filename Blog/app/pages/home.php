<?php include '../app/pages/includes/header.php'; ?>            
<h3 class="mx-3">Featured</h3>
<!-- cards -->
<div class="row mb-2">
    <?php 
    $query = 'SELECT posts.*, categories.category FROM posts join categories on posts.category_id = categories.id  ORDER BY id DESC LIMIT 6';
    $rows = query($query);
    if($rows)
    {
        foreach($rows as $row)
        {
            include '../app/pages/includes/post-card.php';

        }

    }else
    {
        echo 'No items found';
    }
    ?>
</div>

<?php include '../app/pages/includes/footer.php'; ?>