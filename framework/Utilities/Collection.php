<?php

declare(strict_types=1);

namespace framework\Utilities;

/**
 * Class Collection.
 *
 * @package framework\Utilities
 */
abstract class Collection
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * Collection constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->addData($data);
    }

    /**
     * add numerous Nodes
     *
     * @param array $data
     * @param bool $key
     * @return Collection
     */
    public function addData(array $data, bool $key = false):self
    {
        foreach($data as $k => $v)
        {
            if ($key == true)
                $this->addNode($v, $k);
            else
                $this->addNode($v);
        }
        return ($this);
    }

    /**
     * add just one node
     *
     * @param $value
     * @param string|NULL $key
     * @param bool $replace
     * @return Collection
     */
    public function addNode($value, string $key = NULL, bool $replace = true):self
    {
        if ($key == NULL)
            $this->data[] = $value;
        else if (in_array($key, $this->data) && $replace == true)
            $this->data[$key] = $value;
        else if (!in_array($key, $this->data))
            $this->data[$key] = $value;
        return ($this);
    }

    /**
     * Delete one node by is name
     *
     * @param string $key
     * @return Collection
     */
    public function delNode(string $key):self
    {
        if (in_array($key, $this->data))
            unset($this->data[$key]);
        return ($this);
    }

    /**
     * Deleted all of Nodes
     * @return Collection
     */
    public function clear():self
    {
        $this->data = [];
        return ($this);
    }
}