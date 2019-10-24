<?php
namespace AliyunMNS\Responses;
use AliyunMNS\Exception\MnsException;

abstract class BaseResponse
{
    protected $succeed;
    protected $statusCode;

    abstract public function parseResponse($statusCode, $content);

    public function isSucceed()
    {
        return $this->succeed;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    protected function loadXmlContent($content)
    {
        $xmlReader = new \XMLReader();
        $isXml = $xmlReader->XML($content);
        $xml_parser = xml_parser_create();
        $res = xml_parse($xml_parser,$content,true);
        if (!$res || $isXml === FALSE) {
            throw new MnsException($this->statusCode, $content);
        }
        try {
            while ($xmlReader->read()) {}
        } catch (\Exception $e) {
            throw new MnsException($this->statusCode, $content);
        }
        $xmlReader->XML($content);
        return $xmlReader;
    }
}

?>
