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
//
//NSRouter::set('/get/{id}',function(NSServiceProvider $ServiceProvider){
//
//    $id = $ServiceProvider->ViewManager->variables["id"];
//
//    // create result
//    $result = new NSResult();
//
//    // set the id as the title
//    $result->Title = $id;
//
//    // sets the result data to the value of row with id
//    $result->Data = $ServiceProvider->ArticleRepository->get($id);
//
//    // output result2
//    return $result;
//
//});
//
//NSRouter::set('/article/add',function(NSServiceProvider $ServiceProvider){
//
//
//
//});
//
//NSRouter::set('/article/edit/{id}',function(NSServiceProvider $ServiceProvider){
//
//    $id = $ServiceProvider->ViewManager->variables["id"];
//
//    // create result
//    $result = new NSResult();
//
//    // set the id as the title
//    $result->Title = $id;
//
//    // sets the result data to the value of row with id
//    $result->Data = $ServiceProvider->ArticleRepository->get($id);
//
//    // output result2
//    return $result;
//
//});
//
