<section class="gallery-section py-80-60">
    <div class="container-md">


        <div class="grid col-3 col-1-tablet gap-x-40 gap-y-40">

            <?php
            foreach ($block->Fotos as $foto)
            {

                ?>
                <div class="img-wrapper aspect-square border br-5">
                    <img src="<?=$strapi_web_url?><?=$foto->url?>" style="width: 100%">
                </div>
                <?php
            }
            ?>



        </div>
    </div>
</section>