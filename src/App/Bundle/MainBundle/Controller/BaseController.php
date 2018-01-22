<?php

namespace App\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class BaseController
 * @author  Fehiniaina Raharinivoson <fehiniaina28@gmail.com>
 * @package Aes\Bundle\UserBundle\Controller
 */
class BaseController extends Controller
{
    /**
     * @param $request
     * @param $nbTotal
     * @param $nbDisplayed
     * @param $values
     * @param $template
     * @return string
     */
    protected function getDataJson($request, $nbTotal, $nbDisplayed, $values, $template)
    {
        $data['sEcho']                = $request->query->get('sEcho');
        $data['iTotalRecords']        = (int) $nbTotal;
        $data['iTotalDisplayRecords'] = (int) $nbDisplayed;

        return $this->renderView($template, array('data' => $data, 'values' => $values));
    }

    /**
     * @param $request
     * @return array
     */
    protected function getFilters($request)
    {
        $filters = array();
        $start = $request->query->get('iDisplayStart');
        $length = $request->query->get('iDisplayLength');

        if (isset($start)) {
            $filters['start'] = (int) $start;
        }
        if (isset($length)) {
            $filters['length'] = (int) $length;
        }

        return $filters;
    }

    /**
     * @param $request
     * @param $columns
     * @return array
     */
    protected function getSortings($request, $columns)
    {
        $sortings = array();

        foreach ($columns as $k => $v) {
            $isSortCol = $request->query->get('iSortCol_' . $k);

            if (isset($isSortCol) && $columns[$isSortCol]) {
                $orderColumn = $columns[$isSortCol];
                $sSortDir = $request->query->get('sSortDir_' . $k);
                if (isset($sSortDir) && $sSortDir == 'asc') {
                    $orderDirection = 'ASC';
                } else {
                    $orderDirection = 'DESC';
                }

                $sortings[$orderColumn] = $orderDirection;
            }
        }

        return $sortings;
    }
}