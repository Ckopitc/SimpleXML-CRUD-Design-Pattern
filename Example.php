<?php
## PHP's SimpleXMLElement CRUD Design Pattern

$src = "data-created.xml";
$json_src = "data-created.json";
$echo = "";

######################################
#[C]reate
$xml = new DOMDocument("1.0", "UTF-8");
$xml->preserveWhiteSpace = false;
$xml->formatOutput = false;

// Schema
$data = $xml->createElement("data");
$data = $xml->appendChild($data);
$text = "Hello World!";
$message = $xml->createElement("message", $text);
$message = $data->appendChild($message);

// End Task
$output = $xml->saveXML();
$xml->save($src);

// Echo
$echo .=  "[C]reate<br/>";
$echo .=  $output;
$echo .=  "<br />-------------<br />";



######################################
#[R]ead
$xml = simplexml_load_file($src);
$count = count($xml->children());

// Schema
for ($i = 0; $i < $count; $i++){
    $output = $xml->message[$i];
}
// Echo
$echo .="[R]ead<br/>";
$echo .=$output;
$echo .="<br />-------------<br />";



######################################
#[U]pdate
$xml = simplexml_load_file($src);
$update = new SimpleXMLElement($xml->asXML());

// Schema
$update->addChild("message", "Thank You! - updated");
$node = new SimpleXMLElement("<node></node>");
$update->addChild("node", "1234567890");

// End Task
$update->asXML($src);

// Echo
$echo .="[U]pdate<br/>";
$echo .= htmlentities($update->asXML());
$echo .="<br />-------------<br />";



######################################
#[D]elete
$xml = simplexml_load_file($src);
$sxe = new SimpleXMLElement("<".$xml->getName()."></".$xml->getName().">");

//Scheme
//$sxe->addChild($xml->getName());
foreach ($xml->children() as $node){
    if ($node->getName() == 'node'){
        $sxe->addChild($node->getName(), $node." - delete");
    } else {
        $sxe->addChild($node->getName(), $node);
    }
}

//End Task
$sxe->saveXML($src);

// Echo
$echo .="[D]elete<br/>";
$echo .=$output;
$echo .="<br />-------------<br />";



######################################
# JSON Example
$xml = simplexml_load_file($src);
$output = fopen($json_src, "c");
fwrite($output, json_encode($xml));
fclose($output);

######################################
# PHP Example
echo $echo;
