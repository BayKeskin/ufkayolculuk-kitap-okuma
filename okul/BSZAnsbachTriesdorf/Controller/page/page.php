<?php
Class Page {

    public $page_id;
    public function __construct()
    {
        global $curl;
        global $strapi;
        if(!isset($_GET['page_id']))
        {
            $start_seite_id=$strapi->getStartPage();
            $this->page_id=$start_seite_id;
        }else
        {
            $this->page_id=$_GET['page_id'];
        }
    }
    function get_detail()
    {
        global $curl;
        global $strapi;
        global $Parsedown;
        $data =$strapi->Get_Detail("seitens",$this->page_id);
        return $data;
    }

    function get_blog_categorie()
    {
        global $curl;
        global $strapi;
        $data =$strapi->getBlogCategories();
        return $data;
    }
    function get_detail_blog($blog_id)
    {
        global $curl;
        global $strapi;
        global $Parsedown;
        $data =$strapi->Get_Detail_No_Block("beitrages",$blog_id);
        return $data;
    }

    function getAnnouncement()
    {
        global $curl;
        global $strapi;
        global $Parsedown;
        $data =$strapi->getAnnouncement()->data;

        return $data;
    }


    function getTermine()
    {
        global $curl;
        global $strapi;
        global $Parsedown;
        $data =$strapi->getTermine()->data;
       
        return $data;
    }

    function getDownload()
    {
        global $curl;
        global $strapi;
        global $Parsedown;
        $data =$strapi->getDownload()->data;

        return $data;
    }


    function getAnsprechpartner()
    {
        global $curl;
        global $strapi;
        global $Parsedown;
        $data =$strapi->getAnsprechpartner()->data;
        return $data;
    }



    function getSeite()
    {
        global $curl;
        global $strapi;
        global $Parsedown;
        $data =$strapi->getPage();
        return $data;

    }
    function getSchool()
    {
        global $curl;
        global $strapi;
        global $Parsedown;
        $data =$strapi->getSchool();
        return $data;
    }

    function startPage()
    {
        global $curl;
        global $strapi;
        global $Parsedown;
        $data =$strapi->getStartPage();
        return $data;
    }

    function getBlogs($cat_id='')
    {
        global $curl;
        global $strapi;
        global $Parsedown;
        $data = $strapi->getBlog();
        return $data;
    }

    function load_page()
    {
        global $modul;
        global $detail;
        global $Parsedown;
        global $strapi_web_url;
        global $system;

        foreach ($detail->Blocke as $block)
        {
            $titel =explode(".",$block->__component);
            include"../../../block/".end($titel).".php";
        }

    }

  
}