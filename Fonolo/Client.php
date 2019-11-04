<?php

//
// This file is part of the Fonolo PHP Wrapper package.
//
// (c) Foncloud, Inc.
//
// For the full copyright and license information, please view the LICENSE
// file that was distributed with this source code.
//

namespace Fonolo;

use Fonolo\Exceptions\FonoloException;

//
// register the autoloader
//
spl_autoload_register('Fonolo\Client::autoload');

class Client
{
    //
    // PHP SDK version
    //
    const VERSION = '1.0.2';

    //
    // the API key
    //
    private $m_account_sid = null;
    private $m_api_token = null;

    //
    // the request URL
    //
    private $m_url = 'https://api.fonolo.com/3.0/';

    //
    // if we should verify SSL when we make requests
    //
    private $m_verify_ssl = true;

    //
    // additional CURL opts
    //
    public $m_curl_opts = array();

    //
    // init the object and set the API token
    //
    public function __construct($_account_sid, $_api_token)
    {
        //
        // validate the key
        //
        if (preg_match('/^[A-Z]{2}[0-9a-f]{32}$/', $_account_sid) == 0)
        {
            throw new FonoloException('invalid API acount sid provided.');
        }
        if (preg_match('/^[0-9a-f]{64}$/', $_api_token) == 0)
        {
            throw new FonoloException('invalid API access token provided.');
        }

        $this->account_sid($_account_sid);
        $this->api_token($_api_token);
    }

    //
    // autoloader
    //
    static public function autoload($_name)
    {
        if (strncmp($_name, 'Fonolo', 6) == 0)
        {
            require_once str_replace('\\', '/', $_name) . '.php';
        }
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
    // get/set internal values
    //
    public function account_sid($_account_sid = null)
    {
        if (is_null($_account_sid) == true)
        {
            return $this->m_account_sid;
        } else
        {
            $this->m_account_sid = $_account_sid;
        }
    }
    public function api_token($_api_token = null)
    {
        if (is_null($_api_token) == true)
        {
            return $this->m_api_token;
        } else
        {
            $this->m_api_token = $_api_token;
        }
    }
    public function url($_url = null)
    {
        if (is_null($_url) == true)
        {
            return $this->m_url;
        } else
        {
            $this->m_url = $_url;
        }
    }
    public function verify_ssl($_verify = null)
    {
        if (is_null($_verify) == true)
        {
            return $this->m_verify_ssl;
        } else
        {
            $this->m_verify_ssl = $_verify;
        }
    }

    //
    // here to support adding additional custom curl opts
    //
    public function curl_opts(array $_opts = null)
    {
        $this->m_curl_opts = $_opts;
    }

    //
    // return call details
    //
    private function get_call(array $_args = null)
    {
        return new API\Call($this, $_args);
    }
    private function get_calls()
    {
        return new API\Calls($this);
    }

    //
    // return the realtime, pending or scheduled call-backs view
    //
    private function get_realtime()
    {
        return new API\Realtime($this);
    }

    private function get_pending()
    {
        return new API\Pending($this);
    }

    private function get_scheduled()
    {
        return new API\Scheduled($this);
    }

    //
    // return call-back profile details
    //
    private function get_profile(array $_args = null)
    {
        return new API\Profile($this, $_args);
    }
    private function get_profiles()
    {
        return new API\Profiles($this);
    }

    //
    // manage call-backs
    //
    private function get_callback(array $_args = null)
    {
        return new API\CallBack($this, $_args);
    }

    //
    // list of time zones
    //
    private function get_timezones()
    {
        return new API\Timezones($this);
    }
}
