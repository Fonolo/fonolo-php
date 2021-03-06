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

class Call
{
    use RequestHandler;

    //
    // the SID of the call
    //
    public $m_call_id = null;

    //
    // constructor to copy over the client details
    //
    public function __construct(\Fonolo\Client $_client, array $_args)
    {
        $this->init($_client);

        $this->m_call_id = array_shift($_args);
    }

    //
    // get a single call
    //
    public function get()
    {
        return $this->_get('call/' . $this->m_call_id);
    }
}
