<?php
$padding_start='';
if($block->Anfangs_Leere=='Ja')
{
    $padding_start="px-32";
}
?>
<section class="">
    <div class="container-md">
        <div class="sidebar align-center reverse gap-x-80 gap-y-40"
             style="--sidebar-target-width:610px;--sidebar-content-min-width:30%;">
            <div class="stack gap-y-20 schrift-block <?=$padding_start?>">
                <p><?=$block->Schrift?></p>

            </div>
        </div>
    </div>
</section>