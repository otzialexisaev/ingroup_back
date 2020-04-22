<?php

namespace Api\Controllers;

use Klein\Request;
use RedBeanPHP\R as R;

class CoreController
{
    const DEFAULT_DIRECTION = 'DESC';
    const DEFAULT_SORT = 'id';

    public function __construct()
    {
        R::setup('mysql:host=localhost;dbname=ingroup', 'root', '');
    }

    /*
     * @param \Klein\Request $request
     * @return array
     */
    public function parseParamsFromRequest(Request $request)
    {
        $pager = $request->param('pager', false);
        $filter = $request->param('filter', false);
        $sort = $request->param('sort', false);
        $params = [
            'pager' => [
                'page' => isset($pager['page']) ? $pager['page'] : false,
                'count' => isset($pager['count']) ? $pager['count'] : false,
            ],
            'sort' => [
                'field' => isset($sort['field']) ? $sort['field'] : self::DEFAULT_SORT,
                'direction' => isset($sort['direction']) ? $sort['direction'] : self::DEFAULT_DIRECTION,
            ],
        ];
        if (is_array($filter))
            foreach ($filter as $key => $item) {
                $params['filter'][$key] = $item;
//            'filter' => [
//                'field' => isset($filter['field']) ? $filter['field'] : self::DEFAULT_SORT,
//                'exp' => isset($filter['exp']) ? $filter['exp'] : self::DEFAULT_DIRECTION,
//                'value' => isset($filter['value']) ? $filter['value'] : self::DEFAULT_DIRECTION,
//            ]
            }
        return $params;
    }

    /**
     * Добавка пагинации к sql.
     * @param $page int|false
     * @param $count int|false
     * @return string
     */
    public function createPager($page, $count)
    {
        if ($page == false || $count == false)
            return "";
        $start = $count * ($page - 1);
        return " LIMIT {$start},{$count} ";
    }

    public function createFilter(array $filter)
    {
        if (empty($filter))
            return " ";

        $sql = [];
        foreach ($filter as $key => $item) {
            $sql[] = $item['field'] . ' ' . $item['exp'] . ' ' . $item['value'];
        }
        return implode(' AND ', $sql);
    }

    public function createOrderBy($field, $direction)
    {
        if ($field == false || $direction == false)
            return "  ";
        return " ORDER BY {$field} {$direction} ";
    }

    public function responseJson($response)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo(json_encode($response));
    }

    public function paramsToSql(array $params)
    {
        $sql = ' ';

        if (isset($params['filter']) && is_array($params['filter']))
            $sql .= $this->createFilter($params['filter']);

        if (
            isset($params['sort'])
            && isset($params['sort']['field'])
            && isset($params['sort']['direction'])
        )
            $sql .= $this->createOrderBy($params['sort']['field'], $params['sort']['direction']);

        if (
            isset($params['pager'])
            && isset($params['pager']['page'])
            && isset($params['pager']['count'])
        )
            $sql .= $this->createPager($params['pager']['page'], $params['pager']['count']);

        return $sql;
    }
}