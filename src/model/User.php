<?php

namespace App\Model;

class User extends AbstractModel
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'user';
    }
}



