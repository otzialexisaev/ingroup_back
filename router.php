<?php

use Api\Controllers as Api;

$klein = new \Klein\Klein();

$klein->respond('GET', '/api/notes/get', function ($request) {
    $api = new Api\NotesController();
    $api->get($request);
});

$klein->respond('GET', '/api/notes/delete', function ($request) {
    $id = $request->param('id', false);
    $api = new Api\NotesController();
    $api->delete($id);
});

$klein->respond('POST', '/api/notes/create', function () {
    $rest_json = file_get_contents("php://input");
    $postParams = json_decode($rest_json, true);
    $api = new Api\NotesController();
    $api->edit($postParams);
});


$klein->dispatch();