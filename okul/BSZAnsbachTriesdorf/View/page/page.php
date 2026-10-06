<?php
include"../../Components/header.php";
include"../../Controller/page/page.php";
$modul = new Page();
$detail = $modul->get_detail()->data[0];
?>


    <main id="primary">
        <h1 class="sr-only"><?=$detail->Titel?></h1>
        <?php
        $modul->load_page();
        ?>
    </main>

<?php
include"../../Components/footer.php";
?>