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

class Profile
{
    use RequestHandler;

    //
    // the SID of the profile
    //
    public $m_profile_id = null;

    //
    // constructor to copy over the client details
    //
    public function __construct(\Fonolo\Client $_client, array $_args)
    {
        $this->init($_client);

        $this->m_profile_id = array_shift($_args);
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
    // get a single call-back profile
    //
    public function get()
    {
        return $this->_get('profile/' . $this->m_profile_id);
    }

    //
    // return options for this profile
    //
    private function get_option(array $_args = null)
    {
        return new Option($this->m_client, $this, $_args);
    }
    private function get_options()
    {
        return new Options($this->m_client, $this);
    }

    //
    // return questions for this profile
    //
    private function get_question(array $_args = null)
    {
        return new Question($this->m_client, $this, $_args);
    }
    private function get_questions()
    {
        return new Questions($this->m_client, $this);
    }

    //
    // return scheduling information
    //
    private function get_scheduling()
    {
        return new Scheduling($this->m_client, $this);
    }
}
