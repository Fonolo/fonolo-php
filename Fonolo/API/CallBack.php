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

class CallBack
{
    use RequestHandler;

    //
    // the SID of the call
    //
    public $m_call_id = null;        

    //
    // constructor to copy over the client details
    //
    public function __construct(\Fonolo\Client $_client, array $_args = null)
    {
        $this->init($_client);

        if (is_null($_args) == false)
        {
            $this->m_call_id = array_shift($_args);
        }
    }

    //
    // manage call-backs
    //
    public function start(array $_args)
    {
        return $this->_post('callback', $_args);
    }
    public function cancel()
    {
        return $this->_post('callback/' . $this->m_call_id . '/cancel');
    }
    public function status()
    {
        return $this->_get('callback/' . $this->m_call_id . '/status');
    }
}
