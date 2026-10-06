
<?php
if($block->Hintergrund!='')
{
    $styletext = 'style="background-color:'.$block->Hintergrund.'"';
}else
{
    $styletext='';
}
?>
<section class="pb-16">
    <div class="container-md">
        <div class="sidebar align-center reverse gap-x-80 gap-y-40"
             style="--sidebar-target-width:610px;--sidebar-content-min-width:30%;">
            <div class="stack gap-y-20 bg-gray-dynamic bg-gray-text-block" <?=$styletext?> >
                <p><?=$block->Schrift?></p>
            </div>
        </div>
    </div>
</section>