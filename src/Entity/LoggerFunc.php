<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LoggerFuncRepository")
 */
class LoggerFunc
{

    public function getLogger() :object
    {

    }
}
