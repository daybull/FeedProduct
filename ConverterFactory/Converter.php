<?php
namespace ConverterFactory;

use ConverterFactory\JsonProvider;
use ConverterFactory\XmlProvider;
class Converter{

    protected $formatJson = "JSON";
    public $jsonProvider = JsonProvider::class;
    protected $formatXml = "XML";
    public $xmlProvider = XmlProvider::class;
    protected $provider = "";
    protected $data = [];

    public function __construct($data, $format){
        $this->data = $this->controlData($data);
        $this->provider = $this->controlFormat($format);
    }

    public function convert(){
        $res = false;
        if($this->data){
            $res = $this->provider->setData($this->data)->convertData();
        }
        return $res;
    }

    protected function controlData($data){
        $res = [];
        if(gettype($data) === "array"){
            $res = $data;
        }
        if(gettype($data) === "string"){
            $res = json_decode($data, true);
        }
        return $res;
    }

    public function controlFormat($format){
        $res = false;
        if(str_contains($format, $this->formatJson)){
            $res = new $this->jsonProvider();
        }

        if(str_contains($format, $this->formatXml)){
            $res = new $this->xmlProvider();
        }
        
        
        return $res;
    }
}