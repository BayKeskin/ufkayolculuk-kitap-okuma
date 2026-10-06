
<section class="pt-60-40 pb-100-60">
    <div class="container-md">
        <div class="sidebar align-center reverse gap-x-80 gap-y-40"
             style="--sidebar-target-width:610px;--sidebar-content-min-width:30%;">
            <div class="stack gap-y-20">
                <h1 class="uppercase">
                <?=$block->Titel?>
                </h1>
                <p>
                    <?=$block->Erklarung?>
                </p>
                <?php
                if($block->Button_Text!='' && $block->Button_URL!='')
                {
                    ?>
                    <a href="<?=$block->Button_URL?>" class="button"><span><?=$block->Button_Text?></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                             fill="none">
                            <path d="M0.75 12.75L6.75 6.75L0.75 0.75M6.75 12.75L12.75 6.75L6.75 0.75" stroke="white"
                                  stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <?php
                }
                ?>

            </div>


            <div class="image-with-border-and-box">
                <figure style="aspect-ratio: 610/380;" class=""><img src="<?=$strapi_web_url?><?=$block->Bild->url?>"
                                                                     alt="">
                </figure>
            </div>

        </div>
    </div>
</section>