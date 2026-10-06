<?php
$schooldata =$modul->getSchool();
?>
<section class="contact-section py-80-60">
    <div class="container-md">

        <div class="grid col-2 col-1-tablet gap-x-100-60 align-start">

            <div class="contact-info stack space-40">

                <h2 class="fs-h2 fw-bold color-dark m-0">Kontakt</h2>
                <br><br>
                <div class="address-block fs-p color-dark">
                    <p><?=$schooldata->data[0]->Name?></p>
                    <p>Förderschwerpunkt Lernen</p>

                    <div class="space-20"></div>
                    <br><br>
                    <p><?=$schooldata->data[0]->Schule_1_Adress?></p>
                </div>
                <br><br>
                <div class="contact-details fs-p color-dark stack space-4">
                    <p>Tel: <a href="tel:<?=$schooldata->data[0]->Schule_1_Telefon?>"><?=$schooldata->data[0]->Schule_1_Telefon?></a> </p>
                    <p>Fax.: <a href="tel:<?=$schooldata->data[0]->Schule_1_Telefon_2?>"><?=$schooldata->data[0]->Schule_1_Telefon_2?></a></p>
                    <p>
                        Mail:
                        <a href="mailto:<?=$schooldata->data[0]->Schule_1_Mail?>" class="accent-link text-decoration-none">
                            <?=$schooldata->data[0]->Schule_1_Mail?>
                        </a>
                    </p>
                </div>

            </div>

            <?php
            /*
            ?>

            <div class="contact-form-wrapper">
                <form action="#" method="POST" class="stack space-20">

                    <div class="form-group">
                        <label for="name" class="form-label color-dark">Ihr Name</label>
                        <input type="text" id="name" name="name" class="form-input bg-white">
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label color-dark">Ihre E-Mail Adresse</label>
                        <input type="email" id="email" name="email" class="form-input bg-white">
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label color-dark">Ihre Nachricht an uns</label>
                        <textarea id="message" name="message" class="form-input bg-white" rows="6"></textarea>
                    </div>

                    <p class="fs-100 text-gray kontakt-daten">
                        Mit dem Absende der Nachrichten bestätigen Sie, dass Sie unsere
                        <a href="#" class="underline-link color-inherit">Datenschutzerklärung</a> gelesen haben.
                    </p>

                    <button type="submit" class="button border-none pointer">
                        Absenden
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13 17L18 12L13 7M6 17L11 12L6 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                </form>
            </div>
            */
            ?>

        </div>
    </div>
</section>