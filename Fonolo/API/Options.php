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

class Options
{
    use RequestHandler;

    //
    // the instance of the Profile object
    //
    private $m_profile = null;

    //
    // constructor to copy over the client details
    //
    public function __construct(\Fonolo\Client $_client, \Fonolo\API\Profile $_profile)
    {
        $this->init($_client);
        $this->m_profile = $_profile;
    }

    //
    // get a list of call-back profiles
    //
    public function get(array $_settings = null)
    {
        return $this->_get('profile/' . $this->m_profile->m_profile_id . '/options', $_settings);
    }
}
