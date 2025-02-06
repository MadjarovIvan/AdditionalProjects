<?php include '../app/pages/includes/header.php'; ?>            

<div class="row mx-auto col-md-10">
    <h3>Search</h3>
    <?php

    $limit = 10;
    $offset =($PAGE['page_number']-1)*$limit;

    $find = $_GET['find'] ?? null;

    if($find)
    {
        $find = "%$find%";
        $query = "SELECT posts.*, categories.category FROM posts join categories ON posts.category_id = categories.id WHERE posts.title LIKE :find ORDER BY id DESC limit $limit offset $offset";
        $rows = query($query, ['find' => $find]);
    }

    if(!empty($rows))
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

    <div class="col-md-12 mb-4">
        <a href="<?=$PAGE['first_link']?>">
            <button class="btn btn-primary">First Page</button>
        </a>
        <a href="<?=$PAGE['prev_link']?>">
            <button class="btn btn-primary">Prev Page</button>
        </a>
        <a href="<?=$PAGE['next_link']?>">
            <button class="btn btn-primary float-end">Next Page</button>
        </a>
    </div>
</div>
<?php include '../app/pages/includes/footer.php'; ?>