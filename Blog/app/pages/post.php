<?php include '../app/pages/includes/header.php'; ?>            
<div class="row mx-auto col-md-10">
    <h3>Blog</h3>
    
    <?php

    $slug = $url[1] ?? null;

    if($slug)
    {
        $query = "SELECT posts.*, categories.category FROM posts join categories on posts.category_id = categories.id  WHERE posts.slug = :slug";
        $row = query_row($query, ['slug' => $slug]);

        if(!empty($row))
        {
    ?>
            <div class="col-md-12">
                <div class="row g-0 border rounded overflow-hidden flex-column flex-lg-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col-12 d-lg-block">
                        <img src="<?=get_image($row['image'])?>" class="bd-placeholder-img w-100" width="100%" style="object-fit: cover" alt="">
                    </div>
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-primary-emphasis"><?=esc($row['category'] ?? 'Unknown')?></strong>
                        <h3 class="mb-0"><?=esc($row['title'])?></h3>
                        <div class="mb-1 text-body-secondary"><?=esc($row['date'])?></div>
                            <p class="card-text mb-auto">
                            <?=esc($row['content'])?>
                            </p>
                    </div>
                    
                </div>
            </div>
<?php
        }
    }else
    {
        echo 'No items found';
    }
    ?>

</div>
<?php include '../app/pages/includes/footer.php'; ?>