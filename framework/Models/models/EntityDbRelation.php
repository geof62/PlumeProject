<?php

declare(strict_types=1);

namespace framework\Models\models;
use framework\Config\models\Config;

/**
 * Class EntityDbRelation
 * This class is used to hydrate Entities and save their content
 *
 * @package framework\Models\models
 */
class EntityDbRelation
{
    /**
     * safeguard of the schema
     * @var array
     */
    protected $orm = [];

    /**
     * safegard of the value of proprieties
     * @var array
     */
    protected $vars = [];

    /**
     * if true, the element is already present in the DB
     * @var bool
     */
    protected $exist = false;

    /**
     * EntityDbRelation constructor.
     * @param Entity $vars
     * @param int $id
     */
    public function __construct(Entity $vars, int $id)
    {
        $this->orm = $vars->ORM();
        if ($id != -1)
        {
            $this->hydrateById($vars, $id)
                ->hydrateRelationById($vars, $id);
        }
    }

    /**
     * @param Entity $vars
     * @param int $id
     * @return EntityDbRelation
     *
     * hydrate an entity from its id
     *
     */
    protected function hydrateById(Entity $vars, int $id):self
    {
        $table = $this->ORM['table'];
        $search = $vars::getApp()->getDB()->prepare('SELECT id FROM ' . $table . ' WHERE ID=:id');
        $search->execute(['id', $id]);
        $sh = $search->fetchAll();
        if (count($sh) != 0)
        {
            $this->vars['id'] = $id;
            $this->exist = true;
            $req = 'SELECT ';
            foreach ($this->orm as $k => $v)
            {
                if ($v['type'] != "OneToOne" && $v['type'] != "ManyToOne" && $v['type'] != "OneToMany" && $v['type'] != "ManyToMany")
                    $req .= $k . ' ';
            }
            $req = 'FROM ' . $table . ' WHERE id=:id';
            $search = $vars::getApp()->getDB()->prepare($req);
            $search->execute(['id' => $id]);
            $sh = $search->fetch();
            foreach ($this->orm as $k => $v)
            {
                if ($v['type'] != "OneToOne" && $v['type'] != "ManyToOne" && $v['type'] != "OneToMany" && $v['type'] != "ManyToMany") {
                    $method = 'set' . ucfirst($k);
                    $vars->$method($sh[$k]);
                    $this->vars[$k] = $sh[$k];
                }
            }
        }
        return ($this);
    }

    public function hydrateRelationById(Entity $vars, int $id):self
    {
        return ($this);
    }

    public function save():self
    {
        
    }
};