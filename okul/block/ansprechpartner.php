<?php
$data= $modul->getAnsprechpartner();
$schooldata =$modul->getSchool();
?>
<section class="bg-accent py-60-40">
    <div class="container-md">
        <div class="sidebar reverse gap-x-60-40"
             style="--sidebar-target-width:360px;--sidebar-content-min-width:60%;">
            <div class="stack gap-y-32">
                <h2>Ansprechpartner</h2>
                <div class="relative">
                    <div class="ansprechpartner-slider">
                        <div class="swiper-wrapper align-start gap-y-20" style="--min-item-size:170px;">
                            <?php
                            foreach ($data as $row)
                            {
                                ?>
                                <div class=" swiper-slide ansprechpartner-stack stack gap-y-32 w-full">
                                    <figure style="aspect-ratio: 169/218;" class="white-box-shadow w-full">
                                        <img src="<?=$strapi_web_url?><?=$row->Bild->url?>"
                                             alt="">
                                    </figure>
                                    <div>
                                        <p><?=$row->Titel?></p>
                                        <p class="italic"><?=$row->Aufgabe?></p>
                                    </div>
                                </div>

                                <?php
                            }
                            ?>
                        </div>

                        <button class="swiper-button-prev">
                            <span class="sr-only">Zum vorherigen Slide wechseln</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="23" viewBox="0 0 14 23"
                                 fill="none">
                                <path d="M11.125 20.125L2.125 11.125L11.125 2.125" stroke="white"
                                      stroke-width="4.25" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button class="swiper-button-next">
                            <span class="sr-only">Zum nächsten Slide wechseln</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="23" viewBox="0 0 14 23"
                                 fill="none">
                                <path d="M2.125 20.125L11.125 11.125L2.125 2.125" stroke="white"
                                      stroke-width="4.25" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

            <div class="stack gap-y-32">
                <h2>Kontakt</h2>

                <?php
                if($schooldata->data[0]->Schule_2_Adres_Titel=='')
                {
                    ?>
                    <div class="stack gap-y-40">
                        <div>
                            <p><?=$schooldata->data[0]->Schule_1_Adres_Titel?></p>
                        </div>
                        <div>
                            <p><?=$schooldata->data[0]->Schule_1_Adress?></p>
                        </div>
                        <div>
                            <a class="flex-center gap-x-8" href="tel:<?=str_replace(" ","",$schooldata->data[0]->Schule_1_Telefon)?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path
                                    d="M5 4H9L11 9L8.5 10.5C9.57096 12.6715 11.3285 14.429 13.5 15.5L15 13L20 15V19C20 20.1046 19.1046 21 18 21C9.92765 20.5094 3.49056 14.0724 3 6C3 4.89543 3.89543 4 5 4"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                    <path d="M15 7C16.1046 7 17 7.89543 17 9" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M15 3C18.3137 3 21 5.68629 21 9" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span><?=$schooldata->data[0]->Schule_1_Telefon?></span>
                            </a>
                            <a class="flex-center gap-x-8" href="tel:<?=str_replace(" ","",$schooldata->data[0]->Schule_1_Telefon_2)?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path
                                    d="M5 4H9L11 9L8.5 10.5C9.57096 12.6715 11.3285 14.429 13.5 15.5L15 13L20 15V19C20 20.1046 19.1046 21 18 21C9.92765 20.5094 3.49056 14.0724 3 6C3 4.89543 3.89543 4 5 4"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                    <path d="M15 7C16.1046 7 17 7.89543 17 9" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M15 3C18.3137 3 21 5.68629 21 9" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span><?=$schooldata->data[0]->Schule_1_Telefon_2?></span>
                            </a>
                            <a class="flex-center gap-x-8" href="mailto:<?=$schooldata->data[0]->Schule_1_Mail?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <rect x="3" y="5" width="18" height="14" rx="2" stroke="white"
                                          stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M3 7L12 13L21 7" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span><?=$schooldata->data[0]->Schule_1_Mail?></span>
                            </a>
                        </div>
                    </div>
                    <?php
                }else
                {
                    ?>
                    <div class="stack">
                        <div>
                            <p><strong><?=$schooldata->data[0]->Schule_1_Adres_Titel?></strong></p>
                        </div>
                        <div>
                            <p><?=$schooldata->data[0]->Schule_1_Adress?></p>
                        </div>
                        <div>
                            <a class="flex-center gap-x-8" href="tel:<?=str_replace(" ","",$schooldata->data[0]->Schule_1_Telefon)?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path
                                    d="M5 4H9L11 9L8.5 10.5C9.57096 12.6715 11.3285 14.429 13.5 15.5L15 13L20 15V19C20 20.1046 19.1046 21 18 21C9.92765 20.5094 3.49056 14.0724 3 6C3 4.89543 3.89543 4 5 4"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                    <path d="M15 7C16.1046 7 17 7.89543 17 9" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M15 3C18.3137 3 21 5.68629 21 9" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span><?=$schooldata->data[0]->Schule_1_Telefon?></span>
                            </a>
                            <a class="flex-center gap-x-8" href="tel:<?=str_replace(" ","",$schooldata->data[0]->Schule_1_Telefon_2)?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path
                                    d="M5 4H9L11 9L8.5 10.5C9.57096 12.6715 11.3285 14.429 13.5 15.5L15 13L20 15V19C20 20.1046 19.1046 21 18 21C9.92765 20.5094 3.49056 14.0724 3 6C3 4.89543 3.89543 4 5 4"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                    <path d="M15 7C16.1046 7 17 7.89543 17 9" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M15 3C18.3137 3 21 5.68629 21 9" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span><?=$schooldata->data[0]->Schule_1_Telefon_2?></span>
                            </a>
                            <a class="flex-center gap-x-8" href="mailto:<?=$schooldata->data[0]->Schule_1_Mail?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <rect x="3" y="5" width="18" height="14" rx="2" stroke="white"
                                          stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M3 7L12 13L21 7" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span><?=$schooldata->data[0]->Schule_1_Mail?></span>
                            </a>
                        </div>
                    </div>

                    <div class="stack">
                        <div>
                            <p><strong><?=$schooldata->data[0]->Schule_2_Adres_Titel?></strong></p>
                        </div>
                        <div>
                            <p><?=$schooldata->data[0]->Schule_2_Adresse?></p>
                        </div>
                        <div>
                            <a class="flex-center gap-x-8" href="tel:<?=str_replace(" ","",$schooldata->data[0]->Schule_2_Telefon)?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path
                                    d="M5 4H9L11 9L8.5 10.5C9.57096 12.6715 11.3285 14.429 13.5 15.5L15 13L20 15V19C20 20.1046 19.1046 21 18 21C9.92765 20.5094 3.49056 14.0724 3 6C3 4.89543 3.89543 4 5 4"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                    <path d="M15 7C16.1046 7 17 7.89543 17 9" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M15 3C18.3137 3 21 5.68629 21 9" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span><?=$schooldata->data[0]->Schule_2_Telefon?></span>
                            </a>
                            <a class="flex-center gap-x-8" href="tel:<?=str_replace(" ","",$schooldata->data[0]->Schule_2_Telefon_2)?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path
                                    d="M5 4H9L11 9L8.5 10.5C9.57096 12.6715 11.3285 14.429 13.5 15.5L15 13L20 15V19C20 20.1046 19.1046 21 18 21C9.92765 20.5094 3.49056 14.0724 3 6C3 4.89543 3.89543 4 5 4"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                    <path d="M15 7C16.1046 7 17 7.89543 17 9" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M15 3C18.3137 3 21 5.68629 21 9" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span><?=$schooldata->data[0]->Schule_2_Telefon_2?></span>
                            </a>
                            <a class="flex-center gap-x-8" href="mailto:<?=$schooldata->data[0]->Schule_2_Mail?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <rect x="3" y="5" width="18" height="14" rx="2" stroke="white"
                                          stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M3 7L12 13L21 7" stroke="white" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span><?=$schooldata->data[0]->Schule_2_Mail?></span>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>



            </div>
        </div>
    </div>
</section>



