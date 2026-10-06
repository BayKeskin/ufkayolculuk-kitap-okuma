
<section class="py-100-60">
    <div class="container-md">
        <div class="sidebar reverse align-center gap-x-100-60 gap-y-40"
             style="--sidebar-target-width:560px;--sidebar-content-min-width:30%;">
            <div class="stack gap-y-40">
                <h2><?=$block->Titel?></h2>
                <p><?=$block->Beschreibung?></p>
            </div>


            <figure><img src="<?=$strapi_web_url?><?=$block->Bild->url?>" alt=""></figure>
        </div>
    </div>
</section>