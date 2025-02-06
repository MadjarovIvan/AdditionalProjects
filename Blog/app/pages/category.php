<?php include '../app/pages/includes/header.php'; ?>            

<div class="row mx-auto col-md-10">
    <h3>Category</h3>
    <?php

    $limit = 10;
    $offset =($PAGE['page_number']-1)*$limit;

    $category_slug = $url[1] ?? null;
    // var_dump($category_slug);
    // die();

    if($category_slug)
    {
        $query = "SELECT posts.*, categories.category FROM posts join categories ON posts.category_id = categories.id WHERE posts.category_id IN (SELECT id FROM categories WHERE slug LIKE :category_slug) ORDER BY id DESC limit $limit offset $offset";
        $rows = query($query , ['category_slug' => $category_slug.'%']);

        // $query = "SELECT posts.*, categories.category 
        //     FROM posts 
        //     JOIN categories ON posts.category_id = categories.id 
        //     WHERE posts.category_id IN (SELECT id FROM categories WHERE slug = :category_slug) 
        //     ORDER BY id DESC 
        //     LIMIT $limit OFFSET $offset";

        // echo "<pre>$query</pre>";  // Output the query (for debugging)
        // print_r(['category_slug' => $category_slug]); // Check bound parameters

        // $rows = query($query, ['category_slug' => $category_slug]);

        // var_dump($rows); // Check if rows are fetched
        $category = query_row("SELECT id FROM categories WHERE slug = :category_slug", ['category_slug' => $category_slug]);

// if ($category) {
//     $query = "SELECT posts.*, categories.category 
//               FROM posts 
//               JOIN categories ON posts.category_id = categories.id 
//               WHERE posts.category_id = :category_id 
//               ORDER BY id DESC 
//               LIMIT $limit OFFSET $offset";

//     $rows = query($query, ['category_id' => $category['id']]);

//     var_dump($rows); // Debugging
// } else {
//     echo "nothing found";
// }
//         die();
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