<?php

//                
// This file is part of the Fonolo PHP Wrapper package.
//
// (c) Foncloud, Inc.
//
// For the full copyright and license information, please view the LICENSE
// file that was distributed with this source code.
//

namespace Fonolo\API;

use Fonolo\Exceptions\FonoloException;

class Optins
{
    use RequestHandler;

    //
    // constructor to copy over the client details
    //
    public function __construct(\Fonolo\Client $_client)
    {
        $this->init($_client);
    }

    //
    // get a list of optins
    //
    public function get(array $_settings = null)
    {
        return $this->_get('optins', $_settings);
    }
}
