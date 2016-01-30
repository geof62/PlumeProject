<?php

declare(strict_types=1);

namespace framework\Models\models;

use framework\Application\Application;
use framework\Exception\models\Exception;

/**
 * Class Entity
 * This class is a parent for all entities which must have a DB relations
 *
 * @package framework\Models\models
 */
abstract class Entity implements EntityInterface
{
    /**
     * safeguard of the Application to can access it
     *
     * @var Application
     */
    static private $app;

    /**
     * sauvegarde des parametres
     *
     * @var array
     */
    private $sauv =[];

    /**
     * used to safegard an instance of Application
     * @param Application $app
     */
    public static function setApp(Application $app)
    {
        self::$app = $app;
    }

    /**
     * Get an id by a gived parameter
     *
     * @param string $param
     * @return int
     */
    public static function getIdByParam(string $param):int
    {

    }

    /**
     * Entity constructor.
     *
     * @param int $id if is not precise, create new instance
     */
    public function __construct(int $id = -1)
    {
        ////// chargement des données par id
        $this->saveParams();
    }

    /**
     * dynamique setter and getter
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws Exception
     */
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

    /**
     * Save in the DB changes
     *
     * @return Entity
     */
    private function saveParams():self
    {
        foreach(self::ORM()['prop'] as $k => $v)
        {
            if (!empty($this->$k))
                $this->sauv[$k] = $this->$k;
        }
        return ($this);
    }

    /**
     * Check if the proprieties are valid
     *
     * @return Entity
     * @throws Exception
     */
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
                $this->verifRegex($this->$k, $v['regex']);
            // autres verifs
        }
    }

    /**
     * check if a propriety have a valid type
     *
     * @param string $type
     * @param $value
     * @return Entity
     * @throws Exception
     */
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

    /**
     * check if the minimum is valid
     *
     * @param $value
     * @param int $min
     * @return Entity
     * @throws Exception
     */
    private function verifMin($value, int $min):self
    {
        if (is_string($value) && strlen($value) < $min)
            throw new Exception("minimum lenght for the paramter : " . $min);
        else if ((is_int($value) || is_float($value)) && $value < $min)
            throw new Exception("minimum for the paramter : " . $min);
        else
            return ($this);
    }

    /**
     * check if the maximum is valid
     *
     * @param $value
     * @param int $max
     * @return Entity
     * @throws Exception
     */
    private function verifMax($value, int $max):self
    {
        if (is_string($value) && strlen($value) > $max)
            throw new Exception("maximum lenght for the paramter : " . $max);
        else if ((is_int($value) || is_float($value)) && $value > $max)
            throw new Exception("maximum for the parameter : " . $max);
        else
            return ($this);
    }

    /**
     * check if the parameter is valid by regex
     *
     * @param $value
     * @param string $regex
     * @return Entity
     * @throws Exception
     */
    private function verifRegex($value, string $regex):self
    {
        if (!preg_match("#^" . $regex . "$#", $value))
            throw new Exception("the parameter doesn't correspond to the regex ");
        return ($this);
    }

    /**
     * save the changes of the entity
     *
     * @return Entity
     */
    public function save():self
    {
        $this->verifParams();
        //
        return ($this);
    }
}