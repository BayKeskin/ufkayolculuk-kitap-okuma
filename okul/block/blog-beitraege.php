
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
                    if($block->beitrage!='')
                    {
                    $blog_detail = $modul->get_detail_blog($block->beitrage->documentId);
                    ?>
                    <div class="news-card stack relative clr-white py-60-40 px-40-20">
                        <figure class="absolute inset-0"><img src="<?=$strapi_web_url?><?=$blog_detail->data[0]->Bild->url?>" alt="">
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
                                if($block->beitrage->Datum!='')
                                {
                                    ?>
                                    <span><?=$system->formatToGermanDate($block->beitrage->Datum)?></span>
                                    <?php
                                }else
                                {
                                    $datum = explode("T",$block->beitrage->createdAt);
                                    ?>
                                    <span><?=$system->formatToGermanDate($datum[0])?></span>
                                    <?php
                                }
                                ?>
                            </div>
                            <hr>
                            <h3><a href="/blog-detail/<?=$block->beitrage->Slug?>" class=""><?=$block->beitrage->Titel?></a></h3>
                        </div>
                    </div>
                    <?php
                    }
                    if($block->Beitrage_2!='')
                    {
                    $blog_detail = $modul->get_detail_blog($block->Beitrage_2->documentId);
                    ?>
                    <div class="news-card stack relative clr-white py-60-40 px-40-20">
                        <figure class="absolute inset-0"><img src="<?=$strapi_web_url?><?=$blog_detail->data[0]->Bild->url?>" alt="">
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
                                if($block->Beitrage_2->Datum!='')
                                {
                                    ?>
                                    <span><?=$system->formatToGermanDate($block->Beitrage_2->Datum)?></span>
                                    <?php
                                }else
                                {
                                    $datum = explode("T",$block->Beitrage_2->createdAt);
                                    ?>
                                    <span><?=$system->formatToGermanDate($datum[0])?></span>
                                    <?php
                                }
                                ?>
                            </div>
                            <hr>
                            <h3><a href="/blog-detail/<?=$block->Beitrage_2->Slug?>" class=""><?=$block->Beitrage_2->Titel?></a></h3>
                        </div>
                    </div>
                    <?php
                    }
                    if($block->Beitrage_3!='')
                    {
                    $blog_detail = $modul->get_detail_blog($block->Beitrage_3->documentId);
                    ?>
                    <div class="news-card stack relative clr-white py-60-40 px-40-20">
                        <figure class="absolute inset-0"><img src="<?=$strapi_web_url?><?=$blog_detail->data[0]->Bild->url?>"
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
                                if($block->Beitrage_3->Datum!='')
                                {
                                    ?>
                                    <span><?=$system->formatToGermanDate($block->Beitrage_3->Datum)?></span>
                                    <?php
                                }else
                                {
                                    $datum = explode("T",$block->Beitrage_3->createdAt);
                                    ?>
                                    <span><?=$system->formatToGermanDate($datum[0])?></span>
                                    <?php
                                }
                                ?>
                            </div>
                            <hr>
                            <h3><a href="/blog-detail/<?=$block->Beitrage_3->Slug?>" class=""><?=$block->Beitrage_3->Titel?></a></h3>
                        </div>
                    </div>
                    <?php
                    }
                    if($block->Beitrage_4!='')
                    {
                    $blog_detail = $modul->get_detail_blog($block->Beitrage_4->documentId);
                    ?>
                    <div class="news-card stack relative clr-white py-60-40 px-40-20">
                        <figure class="absolute inset-0"><img src="<?=$strapi_web_url?><?=$blog_detail->data[0]->Bild->url?>"
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
                                if($block->Beitrage_4->Datum!='')
                                {
                                    ?>
                                    <span><?=$system->formatToGermanDate($block->Beitrage_4->Datum)?></span>
                                    <?php
                                }else
                                {
                                    $datum = explode("T",$block->Beitrage_4->createdAt);
                                    ?>
                                    <span><?=$system->formatToGermanDate($datum[0])?></span>
                                    <?php
                                }
                                ?>
                            </div>
                            <hr>
                            <h3><a href="/blog-detail/<?=$block->Beitrage_4->Slug?>" class=""><?=$block->Beitrage_4->Titel?></a></h3>
                        </div>
                    </div>
                    <?php
                    }
                    if($block->Beitrage_5!='')
                    {
                    $blog_detail = $modul->get_detail_blog($block->Beitrage_5->documentId);
                    ?>
                    <div class="news-card stack relative clr-white py-60-40 px-40-20">
                        <figure class="absolute inset-0"><img src="<?=$strapi_web_url?><?=$blog_detail->data[0]->Bild->url?>" alt="">
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
                                if($block->Beitrage_5->Datum!='')
                                {
                                    ?>
                                    <span><?=$system->formatToGermanDate($block->Beitrage_5->Datum)?></span>
                                    <?php
                                }else
                                {
                                    $datum = explode("T",$block->Beitrage_5->createdAt);
                                    ?>
                                    <span><?=$system->formatToGermanDate($datum[0])?></span>
                                    <?php
                                }
                                ?>
                            </div>
                            <hr>
                            <h3><a href="/blog-detail/<?=$block->Beitrage_5->Slug?>" class=""><?=$block->Beitrage_5->Titel?></a></h3>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>