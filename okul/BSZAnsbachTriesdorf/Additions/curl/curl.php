<?php
Class Curl
{
    public $apikey ='a15ebc2b-283a-40e8-af07-e3d8626df004';
    function Get_Dinamic_No_Schoole($url)
    {
        /* No Filter */
        global $school_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url."?sort=id:asc&populate=*");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_PROXY, '');
        $response = curl_exec($ch);
        if(curl_errno($ch))
        {
            echo "cURL Error: " . curl_error($ch);
        } else
        {
            return json_decode($response);
        }
        curl_close($ch);
    }
    function Get_Dinamic($url)
    {

        /* No Filter */
        global $school_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url."?sort=id:asc&filters[Schule][documentId][%24eq]=$school_id&populate=*");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_PROXY, '');
        $response = curl_exec($ch);
        if(curl_errno($ch))
        {
            echo "cURL Error: " . curl_error($ch);
        } else
        {
            return json_decode($response);
        }
        curl_close($ch);
    }

    function Get_General($url,$sort="",$cat='')
    {


        global $school_id;

        if($sort=='')
        {
            $short_by="asc";
        }else
        {
            $short_by=$sort;
        }
        $ch = curl_init();



        if($cat!='')
        {
            curl_setopt($ch, CURLOPT_URL, $url."?filters[Schule][documentId][%24eq]=$school_id&filters[beitragskategorien][documentId][%24eq]=$cat&sort=createdAt:$short_by&populate=*");
        }else
        {
            curl_setopt($ch, CURLOPT_URL, $url."?filters[Schule][documentId][%24eq]=$school_id&sort=createdAt:$short_by&populate=*");
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_PROXY, '');
        $response = curl_exec($ch);
        if(curl_errno($ch))
        {
            echo "cURL Error: " . curl_error($ch);
        } else
        {
            return json_decode($response);
        }
        curl_close($ch);
    }

    function Get($url)
    {
        global $school_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url."?filters[Schule][documentId][%24eq]=$school_id&sort=id:asc&populate[Blocke][populate]=*");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_PROXY, '');
        $response = curl_exec($ch);
        if(curl_errno($ch))
        {
            echo "cURL Error: " . curl_error($ch);
        } else
        {
            return json_decode($response);
        }
        curl_close($ch);
    }

    function Get_Detail_No_Block($url,$document_id)
    {
        global $school_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url."?filters[Schule][documentId][%24eq]=$school_id&filters[documentId][%24eq]=$document_id&sort=id:asc&populate=*");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_PROXY, '');
        $response = curl_exec($ch);
        if(curl_errno($ch))
        {
            echo "cURL Error: " . curl_error($ch);
        } else
        {
            return json_decode($response);
        }
        curl_close($ch);
    }

    function Get_Detail($url,$document_id)
    {

        global $school_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url."?filters[Slug][%24eq]=$document_id&sort=id:asc&pLevel");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_PROXY, '');
        $response = curl_exec($ch);
        if(curl_errno($ch))
        {
            echo "cURL Error: " . curl_error($ch);
        } else
        {
            return json_decode($response);
        }
        curl_close($ch);
    }

    function Post($url,$data)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "Content-Type: application/json",
            "AuthenticationToken: $this->apikey"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //$data = json_encode($data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;

    }

    function Put($url,$data)
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'AuthenticationToken:'.$this->apikey,
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;



    }

    function Delete($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "AuthenticationToken: $this->apikey"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }
    
}