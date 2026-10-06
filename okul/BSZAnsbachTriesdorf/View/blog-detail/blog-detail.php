<?php
include"../../Components/header.php";
include"../../Controller/blog-detail/blog-detail.php";
$modul = new Modul();
$data = $modul->get_Detail();
?>

<section class="pt-60-40">
    <div class="container-md">
        <div class="sidebar align-center reverse gap-x-80 gap-y-40"
             style="--sidebar-target-width:610px;--sidebar-content-min-width:30%;">
            <div class="stack gap-y-20">

                <nav aria-label="Breadcrumb" class="py-20">
                    <ol class="breadcrumb flex align-center list-none m-0 p-0 fs-200">
                        <li>
                            <a href="/" class="no-underline opacity-link">Startseite</a>
                        </li>
                        <li>
                            <a href="/blog" class="no-underline opacity-link">Blog</a>
                        </li>
                        <li aria-current="page">
                            <?=$data->Titel?>
                        </li>

                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="text-image-section">
    <div class="container-md">

        <div class="grid col-2 col-1-tablet gap-x-100-60 align-center">

            <div class="content-wrapper">
                <h1 class="h3" style="margin-bottom: 15px">
                    <?=$data->Titel?>
                </h1>

                <?=$data->Kurze_Erklarung?>


            </div>
            <?php if (isset($data->Bild) && isset($data->Bild->url)) : ?>
                <div class="img-wrapper border br-8">
                    <img src="<?= $strapi_web_url . $data->Bild->url ?>" alt="" class="w-full h-auto">
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<section class="pt-60-40">
    <div class="container-md">
        <div class="sidebar align-center reverse gap-x-80 gap-y-40"
             style="--sidebar-target-width:610px;--sidebar-content-min-width:30%;">
            <div class="stack gap-y-20 reverse gap-x-80 ul-list-background">
                <?=$data->Inhalt?>
            </div>
        </div>
    </div>
</section>

<?php
if(isset($data->Fotos))
{
    ?>
    <section class="gallery-section py-80-60">
        <div class="container-md">


            <div class="grid-auto-fit align-start gap-x-40 gap-y-40 blogdetail-fotos">

                <?php
                foreach ($data->Fotos as $foto)
                {
                    ?>
                    <div class="img-wrapper aspect-square border br-5">
                        <img src="<?=$strapi_web_url?><?=$foto->url?>" style="width: 100%">
                    </div>
                    <?php
                }
                ?>



            </div>
        </div>
    </section>
    <?php
}
?>

<?php
include"../../Components/footer.php";
?>
