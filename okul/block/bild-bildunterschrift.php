
<section class="py-80-60">
    <div class="container-md">
        <div class="grid-auto-fill gap-x-40-20 gap-y-40"
             style="--min-item-size: 350px;">
            <?php
            foreach ($block->Bild_Bildunterschrift as $cell)
            {
                    ?>
                    <div class="stack gap-y-40-20">
                        <figure style="aspect-ratio: 56/75;">
                            <img src="<?=$strapi_web_url?><?=$cell->Bild->url?>" alt="<?=$cell->Titel?>" class="cover">
                        </figure>
                        <div class="stack gap-y-20">
                            <h3 class="fs-300 fw-regular"><?=$cell->Titel?></h3>
                            <div>
                                <p><?=$cell->Untertitel?></p>
                                <?php
                                if($cell->E_mail!='')
                                {
                                    ?>
                                    <p>Email: <a href="mailto:<?=$cell->E_mail?>" class=""><?=$cell->E_mail?></a></p>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>

                    <?php


            }
            ?>
        </div>
    </div>
</section>

