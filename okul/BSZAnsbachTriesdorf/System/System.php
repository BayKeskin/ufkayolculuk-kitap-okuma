<?php
session_start();
ob_start();
ini_set("display_errors",0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include '../../Additions/PHPMailler/src/Exception.php';
include '../../Additions/PHPMailler/src/PHPMailer.php';
include '../../Additions/PHPMailler/src/SMTP.php';
$mail = new PHPMailer(true);
$school_id="zqhxwawliks3c67ydk9napva";

include"../../Additions/curl/curl.php";
$curl = new Curl();
include"../../Additions/StrapiApi/strapiapi.php";
$strapi = new StrapiApi();
include"../../Additions/Parsedown/Parsedown.php";
$Parsedown = new Parsedown();


$strapi_web_url ="https://sites.lk-schulen.de";

Class System
{

    public $title='';
    public $description ='';

    function getImage($image)
    {
        if(isset($image->large))
        {
            return $image->large->url;
        }
        elseif(isset($image->medium))
        {
            return $image->medium->url;
        } elseif(isset($image->small))
        {
            return $image->small->url;
        }elseif(isset($image->thumbnail))
        {
            return $image->thumbnail->url;
        }
    }
    
    function get_School_Data()
    {
        global $curl;
        global $strapi;
        $data =$strapi->getSchool();
        return $data;

    }
    function get_navs()
    {
        global $strapi;
        $data = $strapi->getNavs();
        $references = [];
        $tree = [];
        $items = $data->data;

        foreach ($items as &$item) {
            $item->children = [];
            $references[$item->documentId] = &$item;
        }

        foreach ($items as &$item) {
            if ($item->Menuposition == 'Kopfzeile') {
                if (isset($item->Zugehoriges_Menu) && is_object($item->Zugehoriges_Menu) && !empty($item->Zugehoriges_Menu->documentId)) {
                    $parentId = $item->Zugehoriges_Menu->documentId;
                    if (isset($references[$parentId])) {
                        $references[$parentId]->children[] = &$item;
                    } else {
                        $tree[] = &$item;
                    }
                } else {
                    $tree[] = &$item;
                }
            }
        }

        $this->sort_menu_tree($tree);

        return $tree;
    }

    function sort_menu_tree(&$menu_items) {
        usort($menu_items, function($a, $b) {
            $rankA = (isset($a->rank) && $a->rank !== '' && $a->rank !== null) ? intval($a->rank) : 999999;
            $rankB = (isset($b->rank) && $b->rank !== '' && $b->rank !== null) ? intval($b->rank) : 999999;
            if ($rankA === $rankB) {
                return 0;
            }
            return ($rankA < $rankB) ? -1 : 1;
        });
        foreach ($menu_items as &$item) {
            if (!empty($item->children)) {
                $this->sort_menu_tree($item->children);
            }
        }
    }

    function get_navs_footer()
    {
        global $curl;
        global $strapi;
        $data =$strapi->getNavs();
        $references = [];
        $tree = [];
        $items = $data->data;
        foreach ($items as &$item)
        {
            $item->children = [];
            $references[$item->documentId] = &$item;
        }
        foreach ($items as &$item)
        {
            if($item->Menuposition=='Fußzeile')
            {
                $tree[] = $item;
            }
        }
        return $tree;
    }
    function getRandomUserAgent()
    {
        $userAgents=array(
          "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6",
          "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
          "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)",
          "Opera/9.20 (Windows NT 6.0; U; en)",
          "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en) Opera 8.50",
          "Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 5.1) Opera 7.02 [en]",
          "Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; fr; rv:1.7) Gecko/20040624 Firefox/0.9",
          "Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/48 (like Gecko) Safari/48"
        );
        $random = rand(0,count($userAgents)-1);

        return $userAgents[$random];
    }

    function convertDateFormat(string $dateString): string
    {
        $inputFormat = 'Y-m-d';
        $outputFormat = 'd.m.Y';
        $date = DateTime::createFromFormat($inputFormat, $dateString);
        if ($date === false)
        {
            return "";
        }
        return $date->format($outputFormat);
    }

    function date_replace($date)
    {
        $explode   =explode("-",$date);
        $new_date=$explode[2]."-".$explode[1]."-".$explode[0];
        return $new_date;
    }

    function day_return($date){
        global $db;
        $date=explode ("-",$this->date_replace($date));
        $day = date("l",mktime(0,0,0,$date[1],$date[0],$date[2]));
        $day_english = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
        $day_ = array("Montag","Deinstag","Mittwoch","Donnerstag","Freitag","Samstag","Sonntag");
        $day_replace = str_replace($day_english,$day_,$day);
        return $day_replace;
    }


    function get_date_day_and_month($date,$type='datetime')
    {
        $months = array("","Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember");

        $explode = explode(" ", $date);
        $time = isset($explode[1])?$explode[1]:'';
        $date = $explode[0];
        $dates = explode("-", $date);
        $month = $dates[1];
        if ($month < 10)
        {
            $month = str_replace("0", "", $month);
        } else
        {
            $month = $month;
        }

        $day = $this->day_return($date);

        if($type=='datetime')
        {
            echo $dates[2] . " " . $months[$month] . " " . $dates[0] . " $day " . $time;
        }
        if($type=='datetimenoday')
        {
            echo $dates[2] . " " . $months[$month] . " " . $dates[0]  ." ".$time;
        }
        else
        {
            if($type=='dateday')
            {
                echo $dates[2] . " " . $months[$month] . " " . $dates[0] . " $day ";
            }

            if($type=='date')
            {
                echo $dates[2] . " " . $months[$month] . " " . $dates[0];
            }

        }

    }


    function HttpStatus($code) {
        $status = array(
          100 => 'Continue',
          101 => 'Switching Protocols',
          200 => 'OK',
          201 => 'Created',
          202 => 'Accepted',
          203 => 'Non-Authoritative Information',
          204 => 'No Content',
          205 => 'Reset Content',
          206 => 'Partial Content',
          300 => 'Multiple Choices',
          301 => 'Moved Permanently',
          302 => 'Found',
          303 => 'See Other',
          304 => 'Not Modified',
          305 => 'Use Proxy',
          306 => '(Unused)',
          307 => 'Temporary Redirect',
          400 => 'Bad Request',
          401 => 'Unauthorized',
          402 => 'Payment Required',
          403 => 'Forbidden',
          404 => 'Not Found',
          405 => 'Method Not Allowed',
          406 => 'Not Acceptable',
          407 => 'Proxy Authentication Required',
          408 => 'Request Timeout',
          409 => 'Conflict',
          410 => 'Gone',
          411 => 'Length Required',
          412 => 'Precondition Failed',
          413 => 'Request Entity Too Large',
          414 => 'Request-URI Too Long',
          415 => 'Unsupported Media Type',
          416 => 'Requested Range Not Satisfiable',
          417 => 'Expectation Failed',
          500 => 'Internal Server Error',
          501 => 'Not Implemented',
          502 => 'Bad Gateway',
          503 => 'Service Unavailable',
          504 => 'Gateway Timeout',
          505 => 'HTTP Version Not Supported');
        return $status[$code] ? $status[$code] : $status[500];
    }
    function SetHeader($code){
        header("HTTP/1.1 ".$code." ".$this->HttpStatus($code));
        header("Content-Type: application/json; charset=utf-8");
    }


    function GetIP()
    {
        if(getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
            if (strstr($ip, ',')) {
                $tmp = explode (',', $ip);
                $ip = trim($tmp[0]);
            }
        } else {
            $ip = getenv("REMOTE_ADDR");
        }
        return $ip;
    }

    function formatToGermanDate($dateString="")
    {
        if(!empty($dateString))
        {
            $dateTime = new DateTime($dateString);

            // Create a formatter for German (de_DE) locale
            $formatter = new IntlDateFormatter(
                'de_DE',
                IntlDateFormatter::LONG,
                IntlDateFormatter::NONE,
                null,
                null,
                'dd. MMMM yyyy'
            );

            return $formatter->format($dateTime);
        }

    }


    function sendmail($subject, $message, $mails = array())
    {

        global $db;
        global $mail;

        try {
            $mail->clearAddresses();
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'mail.your-server.de';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'mailserver@mocodev.de';                     //SMTP username
            $mail->Password   = 'KiB6y3wBsPky59EH';                               //SMTP password
            $mail->SMTPSecure = 'TLS';            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet = 'utf-8';
            //Recipients
            $mail->SetFrom($mail->Username, $subject);
            foreach ($mails as $m)
            {
                $mail->AddAddress($m);
                // $mail->addBCC($m, "Du");
            }
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = '';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }

    function set_url($text)
    {
        $find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
        $replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
        $text = strtolower(str_replace($find, $replace, $text));
        $text = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $text);
        $text = trim(preg_replace('/\s+/', ' ', $text));
        $text = str_replace(' ', '-', $text);
        return $text;
    }
}



$system = new System();
