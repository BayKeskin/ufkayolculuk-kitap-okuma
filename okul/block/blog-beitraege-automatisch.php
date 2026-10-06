
<?php
if($block->id!='')
{
    $data = $modul->getBlogs($block->Kategorie->documentId);
}else
{
    $data = $modul->getBlogs();
}

?>
<section class="bg-gray pt-60-40 pb-100-60">
    <div class="container-md">
        <div class="stack gap-y-60">
            <div class="repel wrap gap-x-20">
                <h2>Aktuelles aus unserer Schule</h2>
                <a href="/blog" class="button">
                    <span>Alle Beiträge</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                         fill="none">
                        <path d="M0.75 12.75L6.75 6.75L0.75 0.75M6.75 12.75L12.75 6.75L6.75 0.75" stroke="white"
                              stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg></a>
            </div>
            <div class="container">
                <div class="grid gap-x-32 news-grid fs-h3">
                    <?php
                    $i =0;
                    foreach ($data->data as $row)
                    {



                        if($i==0 OR $i==1)
                        {
                            ?>
                            <div class="news-card stack relative clr-white py-60-40 px-40-20">
                                <figure class="absolute inset-0"><img src="<?=$strapi_web_url?><?=$row->Bild->url?>" alt="">
                                </figure>
                                <div class="stack gap-y-12 z-index-10 mt-auto">
                                    <div class="flex-center gap-x-8 fs-000">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                             viewBox="0 0 18 18" fill="none">
                                            <circle cx="9" cy="9" r="6.75" stroke="white" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M9 5.25V9L11.25 11.25" stroke="white" stroke-width="1.5"
                                                  stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <?php
                                        if($row->Datum!='')
                                        {
                                            ?>
                                            <span><?=$system->formatToGermanDate($row->Datum)?></span>
                                            <?php
                                        }else
                                        {
                                            $datum = explode("T",$row->createdAt);
                                            ?>
                                            <span><?=$system->formatToGermanDate($datum[0])?></span>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                    <hr>
                                    <h3><a href="/blog-detail/<?=$row->Slug?>" class=""><?=$row->Titel?></a></h3>
                                </div>
                            </div>
                            <?php

                        }else
                        {
                            ?>
                            <div class="news-card stack relative clr-white py-60-40 px-40-20">
                                <figure class="absolute inset-0"><img src="<?=$strapi_web_url?><?=$row->Bild->url?>"
                                                                      alt="">
                                </figure>
                                <div class="stack gap-y-12 z-index-10 mt-auto">
                                    <div class="flex-center gap-x-8 fs-000">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                             viewBox="0 0 18 18" fill="none">
                                            <circle cx="9" cy="9" r="6.75" stroke="white" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M9 5.25V9L11.25 11.25" stroke="white" stroke-width="1.5"
                                                  stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <?php
                                        if($row->Datum!='')
                                        {
                                            ?>
                                            <span><?=$system->formatToGermanDate($row->Datum)?></span>
                                            <?php
                                        }else
                                        {
                                            $datum = explode("T",$row->createdAt);
                                            ?>
                                            <span><?=$system->formatToGermanDate($datum[0])?></span>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <hr>
                                    <h3><a href="/blog-detail/<?=$row->Slug?>" class=""><?=$row->Titel?></a></h3>
                                </div>
                            </div>
                            <?php
                        }




                        if($i>3)
                        {
                            break;
                        }



                        $i++;
                    }

                    ?>




                </div>
            </div>
        </div>
    </div>
</section>