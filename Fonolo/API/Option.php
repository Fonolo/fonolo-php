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

class Option
{
    use RequestHandler;

    //
    // the instance of the Profile object
    //
    public $m_profile = null;

    //
    // the sid of the call-back option
    //
    public $m_option_id = null;

    //
    // constructor to copy over the client details
    //
    public function __construct(\Fonolo\Client $_client, \Fonolo\API\Profile $_profile, array $_args)
    {
        $this->init($_client);

        $this->m_profile = $_profile;
        $this->m_option_id = array_shift($_args);
    }

    //
    // function loaders
    //
    public function __get($_name)
    {
        $method = 'get_' . strtolower($_name);

        if (method_exists($this, $method) == false)
        {
            throw new FonoloException('invalid resource ' . $_name);
        }

        return $this->$method();
    }
    public function __call($_name, array $_args)
    {
        $method = 'get_' . strtolower($_name);

        if (method_exists($this, $method) == false)
        {
            throw new FonoloException('invalid resource ' . $_name);
        }

        return $this->$method($_args);
    }

    //
    // get a single call-back option
    //
    public function get()
    {
        return $this->_get('profile/' . $this->m_profile->m_profile_id . '/option/' . $this->m_option_id);
    }

    //
    // return the call-back schedule for this option
    //
    private function get_schedule()
    {
        return new Schedule($this->m_client, $this->m_profile, $this);
    }
}
