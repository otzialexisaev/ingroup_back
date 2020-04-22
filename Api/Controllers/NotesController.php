<?php

namespace Api\Controllers;

use RedBeanPHP\R as R;

class NotesController extends CoreController
{
    public function get(\Klein\Request $request)
    {
        $params = $this->parseParamsFromRequest($request);

        $paramsSql = $this->paramsToSql($params);
        $data = R::findAll('notes', $paramsSql);
        $response = [];
        foreach ($data as $note) {
            $response[] = [
                'id' => $note->id,
                'title' => $note->title,
                'description' => $note->description,
                'created_at' => $note->created_at,
                'is_favourite' => $note->is_favourite,
            ];
        }
        $this->responseJson(['notes' => $response]);
    }

    public function delete($id)
    {
        if (empty($id) && $id !== '0')
            $this->responseJson(['success' => false]);

        $this->responseJson([
            'success' => R::trash('notes', $id)
        ]);
    }

    public function edit($params)
    {
        if (isset($params['id']) && $params['id'] !== "")
            $note = R::load('notes', $params['id']);
        else
            $note = R::dispense('notes');

        $note->title = $params['title'];
        $note->description = $params['description'];
        $note->is_favourite = $params['is_favourite'];
        R::store($note);
        $this->responseJson([
            'success' => 1
        ]);
    }
}