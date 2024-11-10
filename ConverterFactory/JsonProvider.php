<?php
namespace ConverterFactory;

use Interface\IFormat;

class JsonProvider implements IFormat{
    protected $data;
    protected $convertedData;

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function convertData()
    {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}