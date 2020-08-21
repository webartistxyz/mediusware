<?php
namespace App\SearchData;

class Search
{

    private static $tableColumns;

    public static function searchQuery($query, $columns, $searchData)
    {
        if (!empty($searchData)) {
            self::$tableColumns = $columns;
            return $query->where(function ($qry) use ($searchData) {
                $columns = self::$tableColumns;
                for ($i = 0; $i < count($columns); $i++) {
                    $i == 0 ? $qry->where($columns[$i], 'LIKE', $searchData . '%') : $qry->orWhere($columns[$i], 'LIKE', $searchData . '%');
                }
            });
        }
    }
}
