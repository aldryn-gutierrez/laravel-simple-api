<?php

namespace App\Services;

use App\Models\Data;

class DataService 
{
    public function get($key, $timestamp = null)
    {
        $dataQuery = Data::where('key', $key);

        if (!is_null($timestamp)) {
            $dataQuery->where('timestamp', '<=', $timestamp);
        }

        $data = $dataQuery->orderBy('id', 'desc')
            ->first();

        return $data;
    }

    public function save(\stdClass $records)
    {
        foreach ($records as $key => $record) {
            $data = new Data();
            $data->key = $key;
            $data->value = $record;
            $data->timestamp = time();
            $data->save();
        }
    }
}
