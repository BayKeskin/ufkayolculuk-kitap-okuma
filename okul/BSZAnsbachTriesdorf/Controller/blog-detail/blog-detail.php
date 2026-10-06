<?php
Class Modul
{
    function get_blog_categorie()
    {
        global $curl;
        global $strapi;
        $data =$strapi->getBlogCategories();
        return $data;
    }
    function get_Detail()
    {
        global $curl;
        global $strapi;
        global $Parsedown;
        $data =$strapi->Get_Detail("beitrages",$_GET['url']);

        return $data->data[0];
    }


    function getSchool()
    {
        global $curl;
        global $strapi;
        global $Parsedown;
        $data =$strapi->getSchool();
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

}