<?php

/**
 * Created by PhpStorm.
 * User: mizanur
 * Date: 5/28/2016
 * Time: 6:26 PM
 */

namespace App\Helpers\Classes;

use DB;

class DT
{
    public function __construct($request, $table, $primaryKey, $columns, $actions)
    {
        $this->request = $request;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->columns = $columns;
        $this->actions = $actions;
    }

    public function generate()
    {
        // Build the SQL query string from the request
        $where = self::filter();
        $order = self::order();
        $limit = self::limit();

        // Main query to actually get the data
        $query = DB::raw('SELECT * FROM ' . $this->table . ' ' . $where . ' ' . $order . ' ' . $limit);
        $this->data = DB::select($query);

        // Data set length after filtering
        $query = DB::raw("SELECT COUNT(`{$this->primaryKey}`) AS recordsFiltered FROM `$this->table` " . $where);
        $resFilterLength = DB::select($query);
        $this->recordsFiltered = $resFilterLength[0]->recordsFiltered;

        // Total data set length
        $query = DB::raw("SELECT COUNT(`{$this->primaryKey}`) AS resTotalLength FROM `$this->table`");
        $resTotalLength = DB::select($query);
        $this->recordsTotal = $resTotalLength[0]->resTotalLength;

        $dataArray = [];
        $i = 0;
        foreach ($this->data as $row) {
            $this->id = isset($row->id) ? $row->id : 0;
            $j = 0;
            foreach ($this->columns as $col) {
                $dataArray[$i][$j] = '';
                if (isset($row->$col) & $row->$col != '') {
                    $dataArray[$i][$j] = $row->$col;
                }
                $j++;
            }
            $action_buttons = "";
            if (count($this->actions) > 0) {
                foreach ($this->actions as $action) {
                    $icon = (isset($action['icon']) && $action['icon'] != '') ? $action['icon'] . ' ' : '';
                    $title = (isset($action['title']) && $action['title'] != '') ? $action['title'] : '';
                    $class = (isset($action['class']) && $action['class'] != '') ? $action['class'] : '';
                    $action_buttons .= " <a title='" . $title . "' class='" . $class . "' href='" . $action['action'] . "'>" . $icon . $action['display_name'] . "</a>";
                }
                if ($action_buttons != "") {
                    $dataArray[$i][] = str_replace('[id]', $this->id, trim($action_buttons));
                }
            }
            $i++;
        }


        /*
        * Output
        */
        $this->output = [
            "draw" => isset ($request['draw']) ? intval($request['draw']) : 0,
            "recordsTotal" => intval($this->recordsTotal),
            "recordsFiltered" => intval($this->recordsFiltered),
            "data" => $dataArray
        ];
        //}
        return json_encode($this->output);
    }

    /**
     * Paging
     */
    public function limit()
    {
        $limit = '';

        if (isset($this->request['start']) && $this->request['length'] != -1) {
            $limit = "LIMIT " . intval($this->request['start']) . ", " . intval($this->request['length']);
        }

        return $limit;
    }


    /**
     * Ordering
     */
    public function order()
    {
        $order = '';
        if (isset($this->request['order']) && count($this->request['order'])) {
            $columnIdx = $this->request['order'][0]['column'];
            $columnName = $this->columns[$columnIdx];
            $dir = $this->request['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            $order = 'ORDER BY ' . $columnName . ' ' . $dir;
        }

        return $order;
    }


    /**
     * Searching / Filtering
     */
    public function filter()
    {
        $where = "";
        if (isset($this->request['search']) && $this->request['search']['value'] != '') {
            $whereArr = [];
            $str = $this->request['search']['value'];
            foreach($this->columns as $column){
                $whereArr[] = "`" . $column . "` LIKE '%" . $str . "%'";
            }
            $where = "WHERE (" . implode(' OR ', $whereArr) .")";
        }
        return $where;
    }
}