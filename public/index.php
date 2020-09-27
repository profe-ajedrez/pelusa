<?php

include '../vendor/autoload.php';

use vso\http\request\InterfaceRequest;
use vso\http\contenttype\ContentTypeJson;
use vso\http\response\BaseResponse;
use vso\pelusa\app\PelusaEnvLoader;
use vso\pelusa\app\PelusaInitializer;
use vso\http\response\InterfaceHttpResponseCodes;

$pelusaEnvloader  = new PelusaEnvLoader('..\environments', 'dev.env');
$pelusaIntializer = new PelusaInitializer($pelusaEnvloader);
$pelu = new vso\pelusa\app\Pelusa($pelusaIntializer);

$pelu->router->get(
    '/',
    function (InterfaceRequest $request) {
        $jsonContent = new ContentTypeJson();
        $response    = new BaseResponse(200, $jsonContent, '', null);
        $request->answer($response);
        die;
    }
);

$pelu->router->get(InterfaceHttpResponseCodes::NOT_FOUND_404, function (InterfaceRequest $request) {

    $jsonContent = new ContentTypeJson();
    $response    = new BaseResponse(InterfaceHttpResponseCodes::NOT_FOUND_404, $jsonContent, '', null);
    $request->answer($response);
    die;
});

$pelu->router->dispatch();
