<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.11.06
 * Time: 14:59
 */

namespace Corvus\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CorvusUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
