<?php
Class StrapiApi
{
    public $strapi_url ="https://sites.lk-schulen.de/api/";

    function getBlogCategories()
    {
        global $curl;
        $data = $curl->Get_General($this->strapi_url.'beitragskategoriens','desc');
        return $data;
    }

    function get_detail($url,$document_id)
    {
        global $curl;
        $data = $curl->Get_Detail($this->strapi_url.$url,$document_id);
        return $data;
    }


    function Get_Detail_No_Block($url,$document_id)
    {
        global $curl;
        $data = $curl->Get_Detail_No_Block($this->strapi_url.$url,$document_id);
        return $data;
    }

    function getAnnouncement()
    {
        global $curl;
        $data = $curl->Get_Dinamic_No_Schoole($this->strapi_url.'ankuendigungens');
        return $data;
    }

    function getTermine()
    {
        global $curl;
        $data = $curl->Get_General($this->strapi_url.'wichtige-termines','desc');
        return $data;
    }
    function getDownload()
    {
        global $curl;
        $data = $curl->Get_General($this->strapi_url.'downloads');
        return $data;
    }

    function getBlog($cat='')
    {
        global $curl;
        $data = $curl->Get_General($this->strapi_url.'beitrages','',$cat);
        return $data;
    }


    function getAnsprechpartner()
    {
        global $curl;
        $data = $curl->Get_General($this->strapi_url.'ansprechpartners');
        return $data;
    }


    function getNavs()
    {
        global $curl;
        $data = $curl->Get_General($this->strapi_url.'menus');
        return $data;

    }
    function getStartPage()
    {
        global $curl;
        $data = $curl->Get_Dinamic($this->strapi_url.'seitens');
        $start_seite_id="";
        foreach ($data->data as $page)
        {
            if($page->Startseite=='Ja')
            {
                $start_seite_id=$page->Slug;
            }
        }
        return $start_seite_id;

    }
    function getPage()
    {
        global $curl;
        $data = $curl->Get($this->strapi_url.'seitens');
        return $data;

    }
    function getSchool()
    {
        global $curl;
        $data = $curl->Get_General($this->strapi_url.'schools');
        return $data;

    }
}