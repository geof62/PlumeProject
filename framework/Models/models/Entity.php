<?php

declare(strict_types=1);

namespace framework\Models\models;

use framework\Application\Application;
use framework\Exception\models\Exception;

abstract class Entity implements EntityInterface
{
    static private $app;
    private $sauv =[];

    public static function setApp(Application $app)
    {
        self::$app = $app;
    }

    // fonctions static pour récup id par autre param

    public function __construct(int $id)
    {
        ////// chargement des données par id
        $this->saveParams();
    }

    public function __call($name, $arguments)
    {
        if (substr($name, 0, 3) == "set" && count($arguments) == 1)
        {
            $prop = lcfirst(substr($name, 3));
            $this->$prop = $arguments[0];
        }
        else if (substr($name, 0, 3) == "get")
        {
            $prop = lcfirst(substr($name, 3));
            if (isset($this->$prop))
                throw new Exception($prop . " does not exist");
            else
                return ($this->$prop);
        }
        else
            throw new Exception("invalid method $name for this class");
    }

    private function saveParams():self
    {
        foreach(self::ORM()['prop'] as $k => $v)
        {
            if (!empty($this->$k))
                $this->sauv[$k] = $this->$k;
        }
        return ($this);
    }

    private function verifParams():self
    {
        foreach(self::ORM()['prop'] as $k => $v)
        {
            $this->verifTypeParam($v['type'], $this->$k);
            if (array_key_exists('min', $v))
                $this->verifMin($this->$k, $v['min']);
            if (array_key_exists('max', $v))
                $this->verifMax($this->$k, $v['max']);
            if (array_key_exists('regex', $v) && ($v['type'] == "string" || $v['type'] == "password"))
                $this->verifMax($this->$k, $v['regex']);
            // autres verifs
        }
    }

    private function verifTypeParam(string $type, $value):self
    {
        if ($type == "string" && !is_string($value))
            throw new Exception("invalid type : " . $type . " for the propriety " . $value);
        else if ($type == "int" && !is_int($value))
            throw new Exception("invalid type : " . $type . " for the propriety " . $value);
        else if ($type == "password" && !is_string($value))
            throw new Exception("invalid type : " . $type . " for the propriety " . $value);
        /////// à cmp
        else
            return ($this);
    }

    private function verifMin($value, int $min):self
    {
        if (is_string($value) && strlen($value) < $min)
            throw new Exception("minimum lenght for the paramter : " . $min);
        else if ((is_int($value) || is_float($value)) && $value < $min)
            throw new Exception("minimum for the paramter : " . $min);
        else
            return ($this);
    }

    private function verifMax($value, int $max):self
    {
        if (is_string($value) && strlen($value) > $max)
            throw new Exception("maximum lenght for the paramter : " . $max);
        else if ((is_int($value) || is_float($value)) && $value > $max)
            throw new Exception("maximum for the parameter : " . $max);
        else
            return ($this);
    }

    private function verifRegex($value, string $regex):self
    {


        return ($this);
    }

    public function save():self
    {
        $this->verifParams();
        return ($this);
    }
}