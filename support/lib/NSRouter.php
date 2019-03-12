<?php
/**
 * Router to handle navigation
 *
 * Author: darylcecile <darylcecile@gmail.com>
 * Date: 11/03/2019
 * Time: 00:49
 */

class NSRouter
{

    private static $routes = [];

    /**
     * @param string|array $route
     * @param callable $handler
     * @param string[] $requestType
     */
    public static function set($route,$handler,$requestType=["GET"]){

        if ( is_array($route) ) {
            if (count($route) === 0) return;
            $n = array_shift($route);
            if (count($route) > 0) self::set( $route ,  $handler , $requestType );
            $route = $n;
        }


        if ( Tools::startsWith($route,"/") === false ) $route = "/$route";

        $url = "/" . ( isset($_GET['url']) ? $_GET['url'] : '' );
        if ( $url === "/index.php" ) $url = "/";

        if ( Tools::MatchesPattern($route,$url) === true &&  in_array($_SERVER['REQUEST_METHOD'],$requestType) === true ){
            global $ServiceProvider;
            $ServiceProvider->ViewManager->variables = Tools::ExtractVariables($route,$url);
            $ServiceProvider->ViewManager->currentPath = $url;

            $returnValue = $handler( $ServiceProvider );

            if ( $returnValue !== false ) {
                echo $returnValue;
                die();
            }
        }
    }

}