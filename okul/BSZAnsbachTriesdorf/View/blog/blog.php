<?php
include"../../Components/header.php";
include"../../Controller/blog/blog.php";
$modul = new Modul();
if(!isset($_GET['cat']))
{
    $data = $modul->get_blog();
}else
{
    $data = $modul->get_blog($_GET['cat']);
}

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

                            <li aria-current="page">
                                Blog
                            </li>

                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-30 pb-40">
        <div class="container-md">
            <div class="sidebar align-center reverse gap-x-80 gap-y-40"
                 style="--sidebar-target-width:610px;--sidebar-content-min-width:30%;">
                <div class="stack gap-y-20">
                    <h3>    Aktuelles aus unserer Schule</h3>

                </div>
            </div>
        </div>
    </section>


    <section class="pt-30 pb-40">
        <div class="container-md">
            <div class="sidebar align-center reverse gap-x-80 gap-y-40" style="--sidebar-target-width:610px;--sidebar-content-min-width:30%;">
                <div class="stack gap-y-20">
                    <div class="flex-center wrap gap-x-40-20 fs-200">
                        <label class="form-label">Nach Kategorie filtern:</label>
                        <select style="width:auto;" class="form-select max-w-full" onchange="location = this.value;">
                            <?php
                            $categories = $modul->get_blog_categorie();
                            foreach ($categories->data as $category)
                            {
                                ?>
                                <option <?=isset($_GET['cat'])?$_GET['cat']==$category->documentId?'selected':'':''?> value="/blog/<?=$category->documentId?>"><?=$category->Titel?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </section>



    <section class="pt-60-40 pb-100-60">
        <div class="container-md">
            <div class="stack gap-y-60">
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
                                            <span>01. August 2025</span>
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
                                            <span>28. Juli 2025</span>
                                        </div>
                                        <hr>
                                        <h3><a href="/blog-detail/<?=$row->Slug?>" class=""><?=$row->Titel?></a></h3>
                                    </div>
                                </div>
                                <?php
                            }






                            $i++;
                        }

                        ?>




                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
include"../../Components/footer.php";
?>