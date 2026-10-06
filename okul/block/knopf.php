
<section class="pb-16">
    <div class="container-md">
        <div class="sidebar align-center reverse gap-x-80 gap-y-40"
             style="--sidebar-target-width:610px;--sidebar-content-min-width:30%;">
            <div  class="flex wrap gap-x-20 gap-y-20 align-center">
                <?php
                if($block->URL!='')
                {
                    ?>
                    <a  href="<?=$block->URL?>" class="button no-underline" >
                        <?=$block->Schrift?>

                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13 17L18 12L13 7M6 17L11 12L6 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <?php
                }else
                {
                    ?>
                    <a  href="<?=$strapi_web_url?><?=$block->PDF->url?>" class="button no-underline" target="_blank">
                        <?=$block->Schrift?>

                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13 17L18 12L13 7M6 17L11 12L6 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <?php
                }
                ?>

            </div>

        </div>
    </div>
</section>





