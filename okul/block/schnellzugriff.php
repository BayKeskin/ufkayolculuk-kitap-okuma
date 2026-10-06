<?php
$options = array_map(fn($n) => "Download $n", range(1, 20));
?>
<section class="bg-accent py-30">
    <div class="container-md stack gap-y-40">
        <h2><?=$block->Titel?></h2>
        <div class="cluster gap-x-40">
            <?php
            if($block->Knopf_1_Title!='')
            {
                if($block->Knopf_1_Option!='')
                {
                    if (in_array($block->Knopf_1_Option, $options))
                    {
                       $modal = "downloads";
                       $attr = "data-downloads='".$system->set_url($block->Knopf_1_Option)."'";
                    }else
                    {
                        $modal =$system->set_url($block->Knopf_1_Option);
                        $attr = "";
                    }
                    ?>
                    <button <?=$attr?> href="" class="button button-inverse open-<?=$modal?>-button">
                        <span><?=$block->Knopf_1_Title?></span>
                    </button>
                    <?php
                }else
                {
                    ?>
                    <a href="<?=$block->Knopf_1_URL?>" class="button button-inverse">
                        <span><?=$block->Knopf_1_Title?></span>
                    </a>
                    <?php
                }
            }

            ?>

            <?php
            if($block->Knopf_2_Title!='')
            {
                if($block->Knopf_2_Option!='')
                {
                    if (in_array($block->Knopf_2_Option, $options))
                    {
                        $modal = "downloads";
                        $attr = "data-downloads='".$system->set_url($block->Knopf_2_Option)."'";
                    }else
                    {
                        $modal =$system->set_url($block->Knopf_2_Option);
                        $attr = "";
                    }
                    ?>
                    <button <?=$attr?> href="" class="button button-inverse open-<?=$modal?>-button">
                        <span><?=$block->Knopf_2_Title?></span>
                    </button>
                    <?php
                }else
                {
                    ?>
                    <a href="<?=$block->Knopf_2_URL?>" class="button button-inverse">
                        <span><?=$block->Knopf_2_Title?></span>
                    </a>
                    <?php
                }
            }

            ?>

            <?php
            if($block->Knopf_3_Title!='')
            {
                if($block->Knopf_3_Option!='')
                {
                    if (in_array($block->Knopf_3_Option, $options))
                    {
                        $modal = "downloads";
                        $attr = "data-downloads='".$system->set_url($block->Knopf_3_Option)."'";
                    }else
                    {
                        $modal =$system->set_url($block->Knopf_3_Option);
                        $attr = "";
                    }
                    ?>
                    <button <?=$attr?> href="" class="button button-inverse open-<?=$modal?>-button">
                        <span><?=$block->Knopf_3_Title?></span>
                    </button>
                    <?php
                }else
                {
                    ?>
                    <a href="<?=$block->Knopf_3_URL?>" class="button button-inverse">
                        <span><?=$block->Knopf_3_Title?></span>
                    </a>
                    <?php
                }
            }

            ?>

            <?php
            if($block->Knopf_4_Title!='')
            {
                if($block->Knopf_4_Option!='')
                {
                    if (in_array($block->Knopf_4_Option, $options))
                    {
                        $modal = "downloads";
                        $attr = "data-downloads='".$system->set_url($block->Knopf_4_Option)."'";
                    }else
                    {
                        $modal =$system->set_url($block->Knopf_4_Option);
                        $attr = "";
                    }
                    ?>
                    <button <?=$attr?> href="" class="button button-inverse open-<?=$modal?>-button">
                        <span><?=$block->Knopf_4_Title?></span>
                    </button>
                    <?php
                }else
                {
                    ?>
                    <a href="<?=$block->Knopf_4_URL?>" class="button button-inverse">
                        <span><?=$block->Knopf_4_Title?></span>
                    </a>
                    <?php
                }
            }

            ?>


            <?php
            if($block->Knopf_5_Title!='')
            {
                if($block->Knopf_5_Option!='')
                {
                    if (in_array($block->Knopf_5_Option, $options))
                    {
                        $modal = "downloads";
                        $attr = "data-downloads='".$system->set_url($block->Knopf_5_Option)."'";
                    }else
                    {
                        $modal =$system->set_url($block->Knopf_5_Option);
                        $attr = "";
                    }
                    ?>
                    <button <?=$attr?> href="" class="button button-inverse open-<?=$modal?>-button">
                        <span><?=$block->Knopf_5_Title?></span>
                    </button>
                    <?php
                }else
                {
                    ?>
                    <a href="<?=$block->Knopf_5_URL?>" class="button button-inverse">
                        <span><?=$block->Knopf_5_Title?></span>
                    </a>
                    <?php
                }
            }
            ?>

        </div>
    </div>
</section>