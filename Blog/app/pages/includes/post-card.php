<!-- card 1 -->
<div class="col-md-6">
    <a href="<?=ROOT?>/post/<?=$row['slug']?>">    
    <div class="row g-0 border rounded overflow-hidden flex-column flex-lg-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary-emphasis"><?=esc($row['category'] ?? 'Unknown')?></strong>
                <h3 class="mb-0"><?=esc($row['title'])?></h3>
            
            <div class="mb-1 text-body-secondary"><?=esc($row['date'])?></div>
                <p class="card-text mb-auto">
                <?=esc(substr($row['content'], 0, 200))?>
                </p>
                <a href="<?=ROOT?>/post/<?=$row['slug']?>" class="icon-link gap-1 icon-link-hover stretched-link">
                    Continue reading
                    <svg class="bi"><use xlink:href="#chevron-right"/></svg>
                </a>
        </div>
        <div class="col-auto d-lg-block">
            <img src="<?=get_image($row['image'])?>" class="bd-placeholder-img w-100" width="200" height="250" alt="">
        </div>
    </div>
    </a>
</div>