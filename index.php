<?php

require_once "autoload.php";

use ConverterFactory\Converter;

$get = filter_input_array(INPUT_GET);
$product_file = "products.json";
$products = fread(fopen($product_file, "r"),filesize($product_file));
$res = false;

if(!empty($products) && isset($get['format'])){
    $converter = new Converter($products, $get['format']);
    $res = $converter->convert();
}

echo '<a href="?format=JSON">JSON</a> | <a href="?format=XML">XML</a>';
echo '<pre>'.htmlentities($res ?? "File Not Converted").'</pre>';
