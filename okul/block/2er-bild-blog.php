<section class="gallery-section py-80-60">
    <div class="container-md">


        <div class="grid col-2 col-1-tablet gap-x-40 gap-y-40 twoerbildblog">

            <?php
            foreach ($block->Bild as $Bild)
            {
                ?>
                <div class="img-wrapper border br-5">
                    <img src="<?=$strapi_web_url?><?=$Bild->Bild->url?>" style="width: 100%">
                </div>
                <?php
            }
            ?>



        </div>
    </div>
</section>