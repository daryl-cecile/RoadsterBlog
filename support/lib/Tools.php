<?php
/**
 * Bunch of useful tools
 *
 * Author: darylcecile <darylcecile@gmail.com>
 * Date: 11/03/2019
 * Time: 00:51
 */


class Tools
{

    /**
     * Gets relative date (e.g. Yesterday)
     *
     * @param DateTime $d
     * @param bool $withTime
     * @return string
     */
    public static function getFriendlyDate($d,$withTime=false){
        $current = new DateTime();
        $currentDate = date("d/m/y", $current->getTimestamp());
        $givenDate = date("d/m/y", $d->getTimestamp());

        if ($currentDate === $givenDate) $friendlyDate = "Today";
        else if ($d->modify("+1 day")->format("d/m/y") === $currentDate) $friendlyDate = "Yesterday";
        else if ($d->modify("-1 day")->format("d/m/y") === $currentDate) $friendlyDate = "Tomorrow";
        else{
            $friendlyDate = $givenDate;
        }

        if ($withTime) $friendlyDate .= " " . date("H:i", $d->getTimestamp());

        return $friendlyDate;
    }

    /**
     * Checks if the string contains another string
     *
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function contains($haystack,$needle){
        return strpos($haystack, $needle) !== false;
    }

    /**
     * Checks if string starts with specified value
     *
     * @param $str
     * @param $start
     * @return bool
     */
    public static function startsWith($str,$start){
        return substr( $str, 0, strlen($start) ) === $start;
    }

    /**
     * Checks if string ends with specified value
     *
     * @param $str
     * @param $end
     * @return bool
     */
    public static function endsWith($str,$end){
        $length = strlen($end);
        if ($length == 0) return true;
        return (substr($str, -$length) === $end);
    }

    /**
     * Check if the provided string contains safe-only characters
     *
     * @param $string
     * @return bool
     */
    public static function IsSafe($string)
    {
        if(preg_match('/[^a-zA-Z0-9_]/', $string) == 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Checks if visitor is a bot
     *
     * @return bool
     */
    public static function isBot(){
        return (
            isset($_SERVER['HTTP_USER_AGENT'])
            && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])
        );
    }

    /**
     * Performs a safe redirect
     *
     * @param $location
     * @param bool $permanent
     */
    public static function redirectTo($location,$permanent=false){
        if (headers_sent() === false)
        {
            header('x-current:' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" );
            header('Location: ' . $location, true, ($permanent === true) ? 301 : 302);
        }
        else{
            echo "<meta http-equiv='refresh' content='0;url=$location'>";
        }

        exit();
    }

    /**
     * Attempts to find and return visitor IP address
     *
     * @return mixed
     */
    public static function getIP(){
        return isset($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR'];
    }

    /**
     * Checks if a GET or POST parameter is set
     *
     * @param $name
     * @param string $ofType
     * @return bool
     */
    public static function hasParam($name,$ofType="GET,POST"){
        $getVal = self::GET($name,null);
        $postVal = self::POST($name,null);
        if ( self::contains($ofType,"POST") && $postVal !== null ){
            return true;
        }

        if ( self::contains($ofType,"GET") && $getVal !== null ){
            return true;
        }
        return false;
    }

    public static function POST($name,$default=null){
        $encoded = false;
        if ( isset($_POST['encoded']) ){
            $encoded = $_POST['encoded'] === "1";
        }

        if ( isset($_POST[$name]) ){
            if ($_POST[$name] === "") return $default;
            return ($encoded ? urldecode ( $_POST[$name] ) : $_POST[$name]);
        }
        else{
            return $default;
        }
    }

    public static function REQUEST($name,$default=null){
        if ( isset($_REQUEST[$name]) ){
            if ($_REQUEST[$name] === "") return $default;
            return $_REQUEST[$name];
        }
        else{
            return $default;
        }
    }

    public static function GET($name,$default=null){
        if ( isset($_GET[$name]) ){
            if ($_GET[$name] === "") return $default;
            return $_GET[$name];
        }
        else{
            return $default;
        }
    }

    /**
     * Generates and returns a random string
     *
     * @param int $length
     * @return string
     */
    public static function generateRandomString($length = 8) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function ExtractVariables(string $pattern, string $input){

        //(?<test>.+)

        $rPattern = str_replace(')','\\)',$pattern);
        $rPattern = str_replace('(','\\(',$rPattern);
        $rPattern = str_replace('?','\\?',$rPattern);
        $rPattern = str_replace('\\','\\\\',$rPattern);
        $rPattern = str_replace('|','\\|',$rPattern);
        $rPattern = str_replace('/','\\/',$rPattern);
        $rPattern = str_replace('.','\\.',$rPattern);
        $rPattern = str_replace('[','\\[',$rPattern);
        $rPattern = str_replace(']','\\]',$rPattern);
        $rPattern = str_replace('*','\\*',$rPattern);
        $rPattern = str_replace('^','\\^',$rPattern);
        $rPattern = str_replace('$','\\$',$rPattern);
        $rPattern = str_replace(':','\\:',$rPattern);

        $rPattern = preg_replace('/\{/','(?<',$rPattern);
        $rPattern = preg_replace('/\}/','>.+)',$rPattern);


        $rPattern = "/$rPattern/";

        $m = null;

        $r = preg_match($rPattern,$input,$m);

        if ($r){
            foreach ($m as $key => $value)
            {
                if (is_int($key))
                    unset($m[$key]);
            }
        }

        return $m;

    }

    public static function MatchesPattern(string $pattern, string $input){
        $new_pattern = "";

        $variable_regex = '/(?<!\\\\){(.+?)}/m';
        preg_match_all($variable_regex, $pattern, $matches, PREG_SET_ORDER, 0);

        $new_pattern = str_replace('\\','\\\\',$pattern);
        $new_pattern = str_replace('|','\\|',$new_pattern);
        $new_pattern = str_replace('/','\\/',$new_pattern);
        $new_pattern = str_replace('.','\\.',$new_pattern);
        $new_pattern = str_replace('?','\\?',$new_pattern);
        $new_pattern = str_replace(')','\\)',$new_pattern);
        $new_pattern = str_replace('(','\\(',$new_pattern);
        $new_pattern = str_replace('[','\\[',$new_pattern);
        $new_pattern = str_replace(']','\\]',$new_pattern);
        $new_pattern = str_replace('*','\\*',$new_pattern);
        $new_pattern = str_replace('^','\\^',$new_pattern);
        $new_pattern = str_replace('$','\\$',$new_pattern);
        $new_pattern = str_replace(':','\\:',$new_pattern);

        foreach($matches as $match){
            $new_pattern = str_replace('{' . $match[1] . '}', '(.+?)' , $new_pattern);
        }

        $new_pattern = '/' . $new_pattern . '$/m';

        preg_match_all($new_pattern, $input, $parts, PREG_SET_ORDER, 0);

        if ($pattern === "/"){
            return ($pattern === $input);
        }
        else if ( sizeof($parts) >= 1 ){
            return sizeof($matches) === sizeof($parts[0]) - 1;
        }
        else{
            return false;
        }

    }

    /**
     * Generates and returns a GUID
     *
     * @return string
     */
    public static function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    /**
     * Creates md5 hash from input and (optionally) a salt
     *
     * @param $input
     * @param null|string $salt
     * @return string
     */
    public static function Hash($input,$salt=null){
        if ($salt === null || $salt === "") return md5( strtolower( trim( $input ) ) );
        else{
            return md5( strtolower( trim( $input . '.' . $salt ) ) );
        }
    }

    /**
     * Gets and returns host
     *
     * @return array|false|string
     */
    public static function GetHost(){
        return getenv('HTTP_HOST');
    }

    /**
     * Sets/Updates cookie
     *
     * @param string $name
     * @param string $value
     * @param int $minutes
     */
    public static function updateCookie($name,$value,$minutes=60){
        $lifetime = time() + (60 * $minutes);
        setcookie($name, $value, $lifetime);
    }

    /**
     * Calculates and returns read time of content in minutes
     *
     * @param $content
     * @return int
     */
    public static function CalculateReadTime($content){
        $word = str_word_count(strip_tags($content));
        $m = floor($word / 200);
        return $m;
    }

    /**
     * Submits the sitemap to Google
     *
     * @param $site
     * @return bool
     */
    public static function SubmitSitemap($site) {
        if ( Tools::contains($site,"localhost") ) return true;

        $url = 'http://www.google.com/webmasters/sitemaps/ping?sitemap='.htmlentities($site.'/sitemap.xml');

        $response = file_get_contents($url);

        if($response){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Includes file for use as dependency
     *
     * @param $path
     */
    public static function DependsOn($path){
        $v = __DIR__ . "/../" . $path;
        include_once $v;
    }
}




