<?php
include"../../Components/header.php";
include"../../Controller/termine/termine.php";
$modul = new Modul();
$data = $modul->getTermine();
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
                                Termine
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
                    <h3>Termine</h3>

                </div>
            </div>
        </div>
    </section>



    <section class="pt-60-40 pb-100-60">
        <div class="container-md">
            <div class="stack gap-y-60">
                <div class="container termine-content">
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
                                    <td><?=$termin->Uhr?> <?=$termin->Ort?></td>
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
        </div>
    </section>
<?php
include"../../Components/footer.php";
?>