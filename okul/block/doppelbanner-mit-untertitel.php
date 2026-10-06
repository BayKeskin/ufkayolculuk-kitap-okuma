
<section class="py-60-40">
    <div class="container-md">
        <div class="stack gap-y-60-40">
            <?php
            if($block->Titel!='')
            {
                ?>
                <h2 class="max-w-800"><?=$block->Titel?></h2>
                <?php

            }
            ?>

            <div class="grid-auto-fit gap-x-80-60 gap-y-40" style="--min-item-size: 440px;">
                <div class="stack">
                    <figure style="aspect-ratio: 555/287;"><img src="<?=$strapi_web_url?><?=$block->Block_1_Bild->url?>" ></figure>
                    <div class="stack gap-y-8 py-20 px-40-20" style="background-color: var(--clr-bg-card,#fefefe);">
                        <h3><?=$block->Block_1_Titel?></h3>
                        <p><?=$block->Block_1_Erklarung?></p>
                        <a href="<?=$block->Block_1_Button_URL?>" class="button space-12 button--outline">
                            <span><?=$block->Block_1_Button_Text?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M0.75 12.75L6.75 6.75L0.75 0.75M6.75 12.75L12.75 6.75L6.75 0.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg></a>
                    </div>
                </div>

                <div class="stack">
                    <figure style="aspect-ratio: 555/287;"><img src="<?=$strapi_web_url?><?=$block->Block_2_Bild->url?>" ></figure>
                    <div class="stack gap-y-8 py-20 px-40-20" style="background-color: var(--clr-bg-card,#fefefe);">
                        <h3><?=$block->Block_2_Titel?></h3>
                        <p><?=$block->Block_2_Erklarung?></p>
                        <a href="<?=$block->Block_2_Button_URL?>" class="button space-12 button--outline">
                            <span><?=$block->Block_2_Button_Text?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M0.75 12.75L6.75 6.75L0.75 0.75M6.75 12.75L12.75 6.75L6.75 0.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>