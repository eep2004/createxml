<?php
/**
 * CreateXml provides XML creation from an array
 *
 * @author Efimkin Evgeny <eep2004@ukr.net>
 * @version 2021-03-10
 **/
class CreateXml
{
    /**
     * Create XML and return as string
     * @param string $root
     * @param array $data
     * @return mixed
     */
    public static function get($root, $data)
    {
        $self = new self;
        return $self->create($root, $data);
    }

    /**
     * Create XML and save to file
     * @param string $file
     * @param string $root
     * @param array $data
     * @return mixed
     */
    public static function save($file, $root, $data)
    {
        if ($file != ''){
            $self = new self;
            return $self->create($root, $data, $file);
        }
        return false;
    }

    /**
     * Create SimpleXMLElement and adding data from array
     * @param string $root
     * @param array $data
     * @param string $file
     * @return mixed
     */
    public function create($root, $data, $file = '')
    {
        try {
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><'.$root.' />');
            $this->fromArray($xml, $data);
            return $file != '' ? $xml->asXML($file) : $xml->asXML();
        } catch (Exception $e){
            return null;
        }
    }

    /**
     * Adding data to SimpleXMLElement
     * @param SimpleXMLElement $xml
     * @param array $data
     */
    private function fromArray($xml, $data)
    {
        if (isset($data['@attr'])){
            foreach ($data['@attr'] as $k => $v){
                $xml->addAttribute($k, $v);
            }
            unset($data['@attr']);
        }
        foreach ($data as $key => $val){
            if (!is_array($val)){
                $xml->addChild($key, htmlspecialchars($val));
                continue;
            }
            if (!isset($val[0])){
                $val = array($val);
            }
            foreach ($val as $v){
                if (!is_array($v)){
                    $xml->addChild($key, htmlspecialchars($v));
                    continue;
                }
                if (isset($v['@value'])){
                    $child = $xml->addChild($key, htmlspecialchars($v['@value']));
                    unset($v['@value']);
                } else {
                    $child = $xml->addChild($key);
                }
                $this->fromArray($child, $v);
            }
        }
    }

}
