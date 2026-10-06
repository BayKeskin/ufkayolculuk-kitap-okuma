<?php
$data = $modul->getAnnouncement();

foreach ($data as $row)
{
    ?>
    <section class="margin-block-60">
        <div class="container-md">
            <div class="bg-warning p-12">
                <div class="flex align-start gap-x-24">
                    <div class="bg-white place-center p-4 shrink-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                             fill="none">
                            <path d="M11 7.33333V10.7998" stroke="#FF9F43" stroke-width="1.5" stroke-linecap="round"
                                  stroke-linejoin="round" />
                            <path d="M11 14.2439L11 14.2875" stroke="#FF9F43" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M4.58331 17.4167H17.4166C18.024 17.4124 18.5898 17.1077 18.9275 16.6029C19.2652 16.0981 19.3311 15.4588 19.1033 14.8958L12.595 3.66666C12.2721 3.08308 11.6578 2.72089 10.9908 2.72089C10.3239 2.72089 9.70953 3.08308 9.38664 3.66666L2.87831 14.8958C2.65501 15.4456 2.71159 16.0694 3.03016 16.57C3.34873 17.0706 3.88989 17.3861 4.48248 17.4167"
                                stroke="#FF9F43" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="stack gap-y-4">
                        <p class="semi-bold"><?=$row->Titel?></p>
                        <p><?=$row->Erklarung?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}