
<section class="pt-60-40">
    <div class="container-md">
        <div class="sidebar align-center reverse gap-x-80 gap-y-40"
             style="--sidebar-target-width:610px;--sidebar-content-min-width:30%;">
            <div class="stack gap-y-20">

                <nav aria-label="Breadcrumb" class="py-20">
                        <ul class="breadcrumb flex align-center list-none m-0 p-0 fs-200">
                            <li>
                                <a href="/" class="no-underline opacity-link">Startseite</a>
                            </li>
                            <?php
                            $i =1;
                            $count =count($block->Element);
                            foreach ($block->Element as $item)
                            {
                                if($i !=$count)
                                {
                                    if($i==1)
                                    {
                                        ?>
                                        <li>
                                            <a style="color:var(--clr-text-gray)" class="no-underline opacity-link"><?=$item->Titel?></a>
                                        </li>

                                        <?php
                                    }else
                                    {
                                        ?>
                                        <li>
                                            <a class="no-underline opacity-link"><?=$item->Titel?></a>
                                        </li>

                                        <?php
                                    }

                                }else
                                {
                                    ?>
                                    <li aria-current="page">
                                        <?=$item->Titel?>
                                    </li>
                                    <?php
                                }
                                $i++;
                            }
                            ?>
                        </ul>
                </nav>
            </div>
        </div>
    </div>
</section>