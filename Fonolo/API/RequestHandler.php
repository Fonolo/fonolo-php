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

trait RequestHandler
{
    protected $m_client = null;

    //
    // init a new object
    //
    protected function init(\Fonolo\Client $_client)
    {
        $this->m_client = $_client;
    }

    //
    // build a request URL
    //
    private function build_url($_action, array $_args = null)
    {
        //
        // if there were arguments passed in
        //
        if (is_null($_args) == false)
        {
            return $this->m_client->url() . $_action . '.json' . '?' . http_build_query($_args);
        } else
        {
            return $this->m_client->url() . $_action . '.json';
        }
    }

    //
    // make the actual request
    //
    private function request($_type, $_action, array $_args = null)
    {
        $response = '';

        //
        // if CURL exists, use it- it's faster
        //
        if (function_exists('curl_version') == true)
        {
            //
            // set up CURL
            //
            $c = curl_init();

            //
            // custom request headers
            //
            $headers = array();

            if ($_type == 'POST')
            {
                curl_setopt($c, CURLOPT_URL, $this->build_url($_action));
                curl_setopt($c, CURLOPT_POST, true);

                //
                // content type header for the form post
                //
                $headers['Content-Type'] = 'application/x-www-form-urlencoded';

                //
                // if there are args
                //
                if (is_null($_args) == false)
                {
                    curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($_args));
                }
                
            } else
            {
                curl_setopt($c, CURLOPT_URL, $this->build_url($_action, $_args));
            }

            curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_USERPWD, $this->m_client->account_sid() . ':' . $this->m_client->api_token());

            //
            // turn on/off peer SSL verification
            //
            if ($this->m_client->verify_ssl() == false)
            {
                curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
            }

            //
            // if we have extra headers to add
            //
            if (count($headers) > 0)
            {
                curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
            }

            //
            // add additional custom CURL opts
            //
            if ( (is_null($this->m_client->m_curl_opts) == false) && (count($this->m_client->m_curl_opts) > 0) )
            {
                curl_setopt_array($c, $this->m_client->m_curl_opts);
            }

            //
            // make the request
            //
            $response  = curl_exec($c);

            //
            // shutdown CURL
            //
            curl_close($c);

            //
            // validate the response data
            //
            if ( ($response === false) || (strlen($response) == 0) )
            {
                throw new FonoloException('failed to make request to Fonolo API');
            }

        //
        // otherwise, just use file_get_contents()
        //
        } else
        {
            //
            // POST request
            //
            if ($_type == 'POST')
            {
                //
                // build the opts
                //
                $opts = array('http' =>
                    array(
                        'method'        => 'POST',
                        'verify_peer'   => $this->m_client->verify_ssl(),
                        'header'        => array(

                            'Content-type: application/x-www-form-urlencoded',
                            'Authorization: Basic ' . base64_encode($this->m_client->account_sid() . ':' . $this->m_client->api_token())
                        ),
                        'content'       => (is_null($_args) == true) ? '' : http_build_query($_args),
                    )
                );

                //
                // make the request
                //
                $response = file_get_contents($this->build_url($_action), false, stream_context_create($opts));
                if ( ($response === false) || (strlen($response) == 0) )
                {
                    throw new FonoloException('failed to make request to Fonolo API');
                }

            //
            // GET request
            //
            } else
            {
                //
                // build the opts
                //
                $opts = array('http' =>
                    array(
                        'method'        => 'GET',
                        'verify_peer'   => $this->m_client->verify_ssl(),
                        'header'        => array(

                            'Authorization: Basic ' . base64_encode($this->m_client->account_sid() . ':' . $this->m_client->api_token())
                        )
                    )
                );

                //
                // make the request
                //
                $response = file_get_contents($this->build_url($_action, $_args), false, stream_context_create($opts));
                if ( ($response === false) || (strlen($response) == 0) )
                {
                    throw new FonoloException('failed to make request to Fonolo API');
                }
            }
        }

        //
        // json decode it
        //
        $data = json_decode($response);
        if ( (is_null($data) == true) || (isset($data->head) == false) || (isset($data->head->status) == false) )
        {
            throw new FonoloException('failed to decode response from Fonolo API');
        }

        //
        // look for a positive response
        //
        if ($data->head->status != 200)
        {
            throw new FonoloException('Fonolo API returned error: ' . $data->head->message);
        }

        return $data;
    }

    //
    // make a get request to the API
    //
    protected function _get($_action, array $_args = null)
    {
        return $this->request('GET', $_action, $_args);
    }

    //
    // make a post request to the API
    //
    protected function _post($_action, array $_args = null)
    {
        return $this->request('POST', $_action, $_args);
    }
}
