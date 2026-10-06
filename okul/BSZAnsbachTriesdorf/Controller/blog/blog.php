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
    function get_blog($cat_id='')
    {
        global $curl;
        global $strapi;
        $data =$strapi->getBlog($cat_id);
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