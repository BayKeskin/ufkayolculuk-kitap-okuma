<?php
include"../../System/System.php";
$school_data = $system->get_School_Data();
$getAnnouncementdata =$strapi->getAnnouncement()->data;
?>



<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSZ Ansbach Triesdorf</title>
    <link rel="stylesheet" href="/Public/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="/Public/css/styles.css">
    <link rel="preload" href="/Public/assets/fonts/bebas_neue.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <meta name="robots" content="noindex">
</head>

<body style="--clr-accent: <?=$school_data->data[0]->Hauptfarbe?>;--clr-text-accent:#000;--clr-text-on-bg-accent:#000;">
<style>
    .bg-gray-dynamic {
        background-color: <?=$school_data->data[0]->Grauer_Block_Hintergrund?>;
    }
</style>
<a id="skip-link" href="#primary">Direkt zum Inhalt</a>
<header class="header relative z-index-100 border-bottom-gray">
    <div class="container-lg">
        <div class="py-16 repel gap-x-20">
            <?php
            $bild = $system->getImage($school_data->data[0]->logo->formats);
            ?>
            <a href="/" class="logo-wrapper inline-block opacity-link" title="Logo">
                <figure><img class="contain" src="<?=$strapi_web_url?><?=$bild?>" alt="BSZ Ansbach Triesdorf">
                </figure>
            </a>
            <button id="toggleButton" class="toggle-menu clr-white flex-column justify-center show-tablet-flex" aria-controls="mobile-nav" aria-expanded="false">
                <span class="sr-only">Menü</span>
                <span aria-hidden="true" class="line line-1 block w-full bg-accent"></span>
                <span aria-hidden="true" class="line line-2 block w-full bg-accent"></span>
                <span aria-hidden="true" class="line line-3 block w-full bg-accent"></span>
            </button>
            <div class="fs-200 hide-tablet repel gap-x-80">
                <nav aria-label="Webseiten-Navigation" class="primary-navigation flex align-center gap-x-20"
                     id="primary-nav">
                    <ul class="cluster gap-x-20 gap-y-20 accent-links" role="list">
                        <?php
                        $data = $system->get_navs();
                        $dropdown_id = 1;
                        foreach ($data as $nav) :
                            if (count($nav->children) > 0) : ?>
                                <li class="menu-dropdown">
                                    <button class="has-submenu inline-flex align-center gap-x-12" aria-expanded="false" aria-controls="dropdown-<?= $dropdown_id ?>">
                                        <span><?= $nav->Titel ?></span>
                                    </button>
                                    <div class="submenu submenu-text-only bg-white br-2 bg-accent" id="dropdown-<?= $dropdown_id ?>">
                                        <ul class="stack align-stretch gap-y-20">
                                            <?php foreach ($nav->children as $child) :
                                                $url = ($child->URL_Typ == 'Interner Link') ? (isset($child->Zielseite->Slug) ? "/page/" . $child->Zielseite->Slug : "") : $child->Url;
                                                if (count($child->children) > 0) : ?>
                                                    <li class="menu-dropdown-sub">
                                                        <button class="has-submenu w-full repel gap-x-4">
                                                            <span><?= $child->Titel ?></span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="7" height="13" viewBox="0 0 7 13" fill="none"><path d="M0.5 12.5L6.5 6.5L0.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                        </button>
                                                        <div class="submenu submenu-text-only bg-white br-2 bg-accent">
                                                            <ul class="stack align-stretch gap-y-20">
                                                                <?php foreach ($child->children as $grandchild) :
                                                                    $g_url = ($grandchild->URL_Typ == 'Interner Link') ? (isset($grandchild->Zielseite->Slug) ? "/page/" . $grandchild->Zielseite->Slug : "") : $grandchild->Url; ?>
                                                                    <li><a href="<?= $g_url ?>"><?= $grandchild->Titel ?></a></li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                <?php else : ?>
                                                    <li><a href="<?= $url ?>"><?= $child->Titel ?></a></li>
                                                <?php endif;
                                            endforeach; ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php else :
                                $url = ($nav->URL_Typ == 'Interner Link') ? (isset($nav->Zielseite->Slug) ? "/page/" . $nav->Zielseite->Slug : "") : $nav->Url; ?>
                                <li><a href="<?= $url ?>"><?= $nav->Titel ?></a></li>
                            <?php endif;
                            $dropdown_id++;
                        endforeach; ?>
                    </ul>
                </nav>

                <figure style="aspect-ratio: 16/11;max-width: 80px;"><img class="contain" src="/Public/assets/images/logo-landkreis-ansbach.png" alt=""></figure>

            </div>

            <nav aria-label="Mobile Webseiten-Navigation"
                 class="mobile-menu-wrapper bg-white fs-200 fixed inset-0 z-index-minus-1" id="mobile-nav">
                <div class="container-lg h-full bg-white">
                    <div class="mobile-menu-content stack align-stretch gap-y-60 h-full">
                        <div class="stack align-stretch gap-y-60 h-full overflow-auto">
                            <ul class="mobile-menu-content__mainlist stack align-stretch gap-y-20" role="list">
                                <?php
                                foreach ($data as $nav) :
                                    if (count($nav->children) > 0) : ?>
                                        <li>
                                            <button class="has-submenu"><?= $nav->Titel ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="6" viewBox="0 0 13 6" fill="none"><path d="M0 -5.68248e-07L2.29602 -4.67886e-07L4.81841 2.95105L6.43532 4.82517L6.56468 4.82518L8.18159 2.95105L10.704 -1.00362e-07L13 0L7.56716 6L5.43283 6L0 -5.68248e-07Z" fill="#1D1D1F" /></svg>
                                            </button>
                                            <div class="submenu">
                                                <ul class="stack gap-y-20 align-stretch">
                                                    <?php foreach ($nav->children as $child) :
                                                        $url = ($child->URL_Typ == 'Interner Link') ? (isset($child->Zielseite->Slug) ? "/page/" . $child->Zielseite->Slug : "") : $child->Url;
                                                        if (count($child->children) > 0) : ?>
                                                            <li>
                                                                <button class="has-submenu repel gap-x-4">
                                                                    <span><?= $child->Titel ?></span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="6" viewBox="0 0 13 6" fill="none"><path d="M0 -5.68248e-07L2.29602 -4.67886e-07L4.81841 2.95105L6.43532 4.82517L6.56468 4.82518L8.18159 2.95105L10.704 -1.00362e-07L13 0L7.56716 6L5.43283 6L0 -5.68248e-07Z" fill="#1D1D1F" /></svg>
                                                                </button>
                                                                <div class="submenu submenu-text-only">
                                                                    <ul class="stack align-stretch gap-y-20">
                                                                        <?php foreach ($child->children as $grandchild) :
                                                                            $g_url = ($grandchild->URL_Typ == 'Interner Link') ? (isset($grandchild->Zielseite->Slug) ? "/page/" . $grandchild->Zielseite->Slug : "") : $grandchild->Url; ?>
                                                                            <li><a href="<?= $g_url ?>"><span><?= $grandchild->Titel ?></span></a></li>
                                                                        <?php endforeach; ?>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                        <?php else : ?>
                                                            <li><a href="<?= $url ?>"><span><?= $child->Titel ?></span></a></li>
                                                        <?php endif;
                                                    endforeach; ?>
                                                </ul>
                                            </div>
                                        </li>
                                    <?php else :
                                        $url = ($nav->URL_Typ == 'Interner Link') ? (isset($nav->Zielseite->Slug) ? "/page/" . $nav->Zielseite->Slug : "") : $nav->Url; ?>
                                        <li><a href="<?= $url ?>"><?= $nav->Titel ?></a></li>
                                    <?php endif;
                                endforeach; ?>
                            </ul>
                            <a href="#" class="opacity-link align-self-end">
                                <figure style="aspect-ratio: 16/11;max-width: 80px;"><img class="contain" src="/Public/assets/images/logo-landkreis-ansbach.png" alt=""></figure>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>

<?php
foreach ($getAnnouncementdata as $row)
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
?>
