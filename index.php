<?php

interface IFormat{
    public function set_data($data);
    public function convert_data();
}

class Json implements IFormat{
    protected $data;
    protected $converted_data;

    public function set_data($data){
        $this->data = $data;
        return $this;
    }

    public function convert_data(){
        $this->converted_data = json_encode($this->data);
        return $this->converted_data;
    }
}

class Xml implements IFormat{
    protected $data;
    protected $converted_data;

    public function set_data($data){
        if(is_array($data)){
            $this->data = $data;
        }else{
            $this->data = json_decode($data,true);
        }
        return $this;
    }

    public function convert_data(){
        $this->converted_data = $this->data;
        $xml = new SimpleXMLElement('<products/>');
        $this->array_to_xml($this->data, $xml);
        $domxml = new DOMDocument('1.0');
        $domxml->preserveWhiteSpace = false;
        $domxml->formatOutput = true;
        $domxml->loadXML($xml->asXML());
        return $this->converted_data = $domxml->saveXML();
    }

    public function array_to_xml($array, $xml){
        foreach($array as $key => $value) {
            if(is_array($value)) {
                if(is_numeric($key)){
                    $child = $xml->addChild('product');
                    $this->array_to_xml($value, $child);
                } else {
                    $this->array_to_xml($value, $xml);
                }
            }else{
                $xml->addChild($key, $value);
            }
        }
    }
}

class Converter{

    protected $formats = ['Json','Xml'];
    protected $format = "";
    protected $data = [];

    public function __construct($data, $format){
        $this->data = $this->control_data($data);
        $this->format = $this->control_format($format);
    }

    public function convert(){
        $res = false;
        if($this->format && $this->data){
            $convert = new $this->format;
            $res = $convert->set_data($this->data)->convert_data();
        }
        return $res;
    }

    protected function control_data($data){
        $res = [];
        if(gettype($data) === "array"){
            $res = $data;
        }else if(gettype($data) === "string"){
            $res = json_decode($data, true);
        }else{
            $res = false;
        }
        return $res;
    }

    public function control_format($format){
        $res = false;
        if(in_array($format,$this->formats)){
            $res = $format;
        }
        return $res;
    }
}

$get = filter_input_array(INPUT_GET);
$product_file = "products.json";
$products = fread(fopen($product_file, "r"),filesize($product_file));
$res = false;
if(!empty($products) && isset($get['format'])){
    $converter = new Converter($products, $get['format']);
    $res = $converter->convert();
}
echo $res;

/*
$test_array = array (
  'bla' => 'blub',
  'foo' => 'bar',
  'another_array' => array (
    'stack' => 'overflow',
  ),
);
$xml = new SimpleXMLElement('<root/>');
array_walk_recursive($test_array, array ($xml, 'addChild'));
print $xml->asXML();
*/
