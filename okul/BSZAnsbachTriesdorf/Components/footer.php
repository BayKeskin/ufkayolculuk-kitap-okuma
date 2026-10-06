<div class="modal termine-modal">
    <?php
    $data = $modul->getTermine();
    ?>
    <div class="modal-content bg-white termine-modal-content p-50 stack gap-y-30">
        <div class="flex-center gap-x-50">
            <div class="flex-center wrap gap-x-50 gap-y-8">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <rect x="5" y="6.25" width="20" height="20" rx="2" stroke="#1D1D1F" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M20 3.75V8.75" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round" />
                    <path d="M10 3.75V8.75" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round" />
                    <path d="M5 13.75H25" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round" />
                    <path d="M13.75 18.75H15" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round" />
                    <path d="M15 18.75V22.5" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round" />
                </svg>
                <p class="h2">Wichtige Termine</p>
            </div>
            <button class="close-button ml-auto shrink-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18" stroke="#2F2B3D" stroke-opacity="0.9" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6 6L18 18" stroke="#2F2B3D" stroke-opacity="0.9" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
        <hr style="margin: 0;">
        <div class="overflow-x-auto" style="word-break: keep-all;">
            <table>
                <tbody>
                <?php
                foreach ($data as $termin)
                {
                    $date = $system->convertDateFormat($termin->Datum);
                    ?>
                    <tr>
                        <td><?=$date?></td>
                        <td><?=$termin->Uhr?><?=$termin->Ort?></td>
                        <td><?=$termin->Titel?></td>
                    </tr>
                    <?php

                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal kontakt-modal">
    <div class="modal-content bg-white termine-modal-content p-50 stack gap-y-30">
        <div class="flex-center gap-x-50">
            <div class="flex-center wrap gap-x-50 gap-y-8">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <rect x="5" y="6.25" width="20" height="20" rx="2" stroke="#1D1D1F" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M20 3.75V8.75" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round" />
                    <path d="M10 3.75V8.75" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round" />
                    <path d="M5 13.75H25" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round" />
                    <path d="M13.75 18.75H15" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round" />
                    <path d="M15 18.75V22.5" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round" />
                </svg>
                <p class="h2">Kontakt</p>
            </div>
            <button class="close-button ml-auto shrink-none ">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18" stroke="#2F2B3D" stroke-opacity="0.9" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6 6L18 18" stroke="#2F2B3D" stroke-opacity="0.9" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
        <hr style="margin: 0;">
        <?php
        include"../../../block/kontakt.php";
        ?>

    </div>
</div>
<?php
$data = $modul->getDownload();
?>
<div class="modal downloads-modal">

    <div class="modal-content bg-white termine-modal-content downloads-modal-content p-50 stack gap-y-30">
        <div class="flex-center gap-x-50">
            <div class="flex-center wrap gap-x-50 gap-y-8">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <path d="M17.5 3.75V8.75C17.5 9.44036 18.0596 10 18.75 10H23.75" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M21.25 26.25H8.75C7.36929 26.25 6.25 25.1307 6.25 23.75V6.25C6.25 4.86929 7.36929 3.75 8.75 3.75H17.5L23.75 10V23.75C23.75 25.1307 22.6307 26.25 21.25 26.25Z" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15 13.75V21.25" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11.25 17.5L15 21.25L18.75 17.5" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <p class="h2">Downloads</p>
            </div>
            <button class="close-button ml-auto shrink-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18" stroke="#2F2B3D" stroke-opacity="0.9" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6 6L18 18" stroke="#2F2B3D" stroke-opacity="0.9" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
        <hr style="margin: 0;">
        <div class="overflow-x-auto" style="word-break: keep-all;">
            <table>
                <tbody>
                <?php
                foreach ($data as $download)
                {
                    ?>
                    <tr>
                        <td><?=$download->Titel?></td>
                        <td style="text-align: right"><a target="_blank" href="<?=$strapi_web_url?><?=$download->Datei->url?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 17V19C4 20.1046 4.89543 21 6 21H18C19.1046 21 20 20.1046 20 19V17" stroke="#2F2B3D" stroke-opacity="0.9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M7 11L12 16L17 11" stroke="#2F2B3D" stroke-opacity="0.9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 4V16" stroke="#2F2B3D" stroke-opacity="0.9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$schooldata =$modul->getSchool();
?>
<footer class="footer bg-gray py-80-60">
    <div class="container-md">

        <div class="sidebar  align-start wrap gap-y-60 gap-x-80" style="--sidebar-target-width: 200px;">

            <div class="footer-brand stack space-30" style="">

                <img src="/Public/assets/images/logo-landkreis-ansbach.png" alt="Landkreis Ansbach" class="w-full h-auto">


                <p class="fs-100 color-dark ">
                    <br><br>
                    Das <?=$schooldata->data[0]->Name?> ist eine
                    Schule des Landkreises Ansbach.
                </p>
            </div>

            <div class="footer-links grid-auto-fill wrap gap-x-60 gap-y-40 accent-links" style="--min-item-size:150px;">


                <?php
                $data = $system->get_navs();
                foreach ($data as $nav)
                {
                    if(count($nav->children)>0)
                    {
                        ?>
                        <div class="footer-col stack gap-y-20">
                            <span class="fs-200 fw-bold color-dark block"><?=$nav->Titel?></span>
                            <ul class="list-none p-0 m-0 stack gap-y-12">
                                <?php
                                foreach ($nav->children as $child)
                                {
                                    if($child->URL_Typ=='Interner Link')
                                    {
                                        if(isset($child->Zielseite->documentId))
                                        {
                                            $url ="/page/".$child->Zielseite->Slug;
                                        }else
                                        {
                                            $url ="";
                                        }
                                    }else
                                    {

                                        $url = $child->Url;
                                    }
                                    ?>
                                    <li><a href="<?=$url?>" class="text-inherit no-underline"><?=$child->Titel?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <?php

                    }
                }
                ?>

                <?php
                $data = $system->get_navs_footer();
                ?>
                <div class="footer-col stack gap-y-20">
                    <ul class="list-none p-0 m-0 stack gap-y-12">
                        <?php
                        $i =1;
                        foreach ($data as $nav)
                        {

                            if($nav->URL_Typ=='Interner Link')
                            {
                                if(isset($nav->Zielseite->documentId))
                                {
                                    $url ="/page/".$nav->Zielseite->Slug;
                                }else
                                {
                                    $url ="";
                                }
                            }else
                            {
                                $url = $nav->Url;
                            }

                            ?>
                            <li><a href="<?=$url?>" class="text-inherit no-underline"><?=$nav->Titel?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>









            </div>

        </div>
    </div>
</footer>



<script src="/Public/lenis.min.js"></script>
<script src="/Public/gsap.min.js"></script>
<script src="/Public/scrolltrigger.min.js"></script>
<script src="/Public/swiper-bundle.min.js"></script>
<script src="/Public/script.js"></script>
</body>

</html>