<?php
abstract class Creator{
    abstract public function factoryMethod(): IFormat;

    public function converData(): IFormat{
        $c = $this->factoryMethod();
        return $c;
    }
}

class CreteJson extends Creator{
    public function factoryMethod(): IFormat{
        return new Json();
    }
}

class CreteXml extends Creator{
    public function factoryMethod(): IFormat{
        return new Xml();
    }
}

interface IFormat{
    public function set_data($data);
    public function convert_data();
}

class Json implements IFormat{
    protected $data;
    protected $converted_data;

    public function set_data($data){
        $this->data = $this->control_data($data);
        return $this;
    }

    public function convert_data(){
        $this->converted_data = json_encode($this->data);
        return $this->converted_data;
    }

    protected function control_data($data){
        $res = [];
        if(gettype($data) === "array"){
            $res = $data;
        }else if(gettype($data) === "string"){
            $res = json_decode($data, true);
            if(!is_array($res)){
              $res = false;
            }
        }else{
            $res = false;
        }
        return $res;
    }
}

class Xml implements IFormat{
    protected $data;
    protected $converted_data;

    public function set_data($data){
        $this->data = $this->control_data($data);
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

    protected function control_data($data){
        $res = [];
        if(gettype($data) === "array"){
            $res = $data;
        }else if(gettype($data) === "string"){
            $res = json_decode($data, true);
            if(!is_array($res)){
              $res = false;
            }
        }else{
            $res = false;
        }
        return $res;
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

function clientCode(Creator $creator, $data){
    return $creator->converData()->set_data($data)->convert_data();
}
$get = filter_input_array(INPUT_GET);
$product_file = "products.json";
$products = fread(fopen($product_file, "r"),filesize($product_file));
$res = false;
if($get['format'] == 'Json'){
  $res = clientCode(new CreteJson(), $products);
} else if($get['format'] == 'Xml'){
  $res = clientCode(new CreteXml(), $products);
}
echo $res;
