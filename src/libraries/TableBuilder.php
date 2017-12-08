<?php

class TableBuilder {
    /**
     * @param $columnHeader
     * @param array ...$dataRows
     * @return array
     */
    public static function table($columnHeader, ...$dataRows) {
        $rows = array();

        foreach ($dataRows as $data) {
            $row = array();
            foreach ($columnHeader as $cIndex => $column) {
                $row[$column] = $data[$cIndex];
            }
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * @param array ...$columnNames
     * @return array
     */
    public static function head(...$columnNames) {
        return $columnNames;
    }

    /**
     * @param array ...$dataValues
     * @return array
     */
    public static function dRow(...$dataValues) {
        return $dataValues;
    }
}
