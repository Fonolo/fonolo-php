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

class Question
{
    use RequestHandler;

    //
    // the instance of the Profile object
    //
    private $m_profile = null;

    //
    // the sid of the pre-call question
    //
    private $m_question_id = null;

    //
    // constructor to copy over the client details
    //
    public function __construct(\Fonolo\Client $_client, \Fonolo\API\Profile $_profile, array $_args)
    {
        $this->init($_client);

        $this->m_profile = $_profile;
        $this->m_question_id = array_shift($_args);
    }

    //
    // get a single pre-call question
    //
    public function get()
    {
        return $this->_get('profile/' . $this->m_profile->m_profile_id . '/question/' . $this->m_question_id);
    }
}
