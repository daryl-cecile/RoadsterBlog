<?php
/**
 * Routes
 *
 * Author: darylcecile <darylcecile@gmail.com>
 * Date: 11/03/2019
 * Time: 01:05
 */

NSRouter::set("",function(NSServiceProvider $ServiceProvider){

    $vm = new ViewModel();
    $vm->name = "Hey";

    $ServiceProvider->ViewManager->RenderView("home", $vm);

});

NSRouter::set('/article/add',function(NSServiceProvider $ServiceProvider){

    $vm = new ViewModel();
    $ServiceProvider->ViewManager->RenderView("rizBlog",$vm);

});

NSRouter::set('/article/edit/{id}',function(NSServiceProvider $ServiceProvider){

    $vm = new ViewModel();
    $vm->data = [
        "article_id" => $ServiceProvider->ViewManager->variables['id']
    ];
    $ServiceProvider->ViewManager->RenderView("rizBlog",$vm);

});
