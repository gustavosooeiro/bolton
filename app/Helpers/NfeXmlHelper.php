<?php

namespace App\Helpers;
/**
 * Class NfeXMLHelper
 * 
 * This helper class extracts information from a XML string.
 * 
 */
class NfeXmlHelper {
    /**
     * 
     * Returns an array with the Id and total of a NFE.
     * 
     * @param string $nfe This param is a base64 encoded XML string
     * @return (string|float)[] [$accessKey string, $total float]
     * 
     */
    public static function getIdAndTotal($nfe){
        $valor = base64_decode($nfe, true);
        $xml = simplexml_load_string($valor, 'SimpleXMLElement', LIBXML_COMPACT);
        if ($xml->NFe){
            $accessKey = (string) $xml->NFe->infNFe['Id'];
            $total = (float) $xml->NFe->infNFe->total->ICMSTot->vNF;
        }else{
            $accessKey = (string) $xml->infNFe['Id'];
            $total = (float) $xml->infNFe->total->ICMSTot->vNF;
        }
        return [$accessKey, $total];
    }
}
