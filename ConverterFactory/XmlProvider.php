<?php
namespace ConverterFactory;

use Interface\IFormat;
class XmlProvider implements IFormat{
    protected $data;
    protected $convertedData;

    public function setData($data){
        if(is_array($data)){
            $this->data = $data;
        }else{
            $this->data = json_decode($data,true);
        }
        return $this;
    }

    public function convertData()
    {
        $this->convertedData = $this->data;
        $xml = new \SimpleXMLElement('<products/>');
        $this->arrayToXml($this->data, $xml);
        $domxml = new \DOMDocument('1.0');
        $domxml->preserveWhiteSpace = false;
        $domxml->formatOutput = true;
        $domxml->loadXML($xml->asXML());
        return $this->convertedData = $domxml->saveXML();
    }

    public function arrayToXml($array, $xml){
        foreach($array as $key => $value) {
            if(is_array($value)) {
                if(is_numeric($key)){
                    $child = $xml->addChild('product');
                    $this->arrayToXml($value, $child);
                } else {
                    $this->arrayToXml($value, $xml);
                }
            }else{
                $xml->addChild($key, $value);
            }
        }
    }
}