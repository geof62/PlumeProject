<?php

declare(strict_types=1);

namespace src\Page\Model;

use framework\Models\models\Entity;

class UserExample extends Entity
{
    protected $id;
    protected $name;
    protected $password;
    protected $friends;

    public static function ORM():array
    {
        return ([
            // id is autodetect
            'table' => 'example',
            'prop' => [
                'name' => [
                    'type' => 'string',
                    'max' => 30,
                    'min' => 10
                ],
                'password' => [
                    'type' => 'password',
                    'min' => 10,
                    'regex' => "[a-zA-Z]*"
                ],
                'friends' => [
                    'type' => 'ManyToOne',
                    'entity' => 'User'
                ]
            ]
        ]);
    }
}