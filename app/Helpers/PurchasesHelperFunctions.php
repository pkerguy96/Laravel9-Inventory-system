<?php
if (!function_exists('PurchaseInsert')) {
    function insertFields(string $modelClass, array $fields)
    {
        $model = new $modelClass;
        foreach ($fields as $key => $value) {
            $model->$key = $value;
        }
        $model->save();
        return $model;
    }
}
