<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * File:   MY_Config.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2016/9/13
 */

class MY_Config extends CI_Config {

    public $_config_paths = array(APPPATH, ASSETS);
    /**
     * 重写site_url和base_url
     * MY_Config constructor.
     * https://github.com/bcit-ci/CodeIgniter/blob/e50aaa/system/core/Config.php
     */
    public function __construct()
    {
        $this->config =& get_config();
        log_message('debug', "Config Class Initialized");
        // Set the base_url automatically if none was provided
        if ($this->config['base_url'] == '')
        {
            // The regular expression is only a basic validation for a valid "Host" header.
            // It's not exhaustive, only checks for valid characters.
            if (isset($_SERVER['HTTP_HOST']) && preg_match('/^((\[[0-9a-f:]+\])|(\d{1,3}(\.\d{1,3}){3})|[a-z0-9\-\.]+)(:\d+)?$/i', $_SERVER['HTTP_HOST']))
            {
                $base_url = (empty($_SERVER['HTTPS']) OR strtolower($_SERVER['HTTPS']) === 'off') ? 'http' : 'https';
                $base_url .= '://'. $_SERVER['HTTP_HOST'];
                $base_url .= substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])));
            }
            else
            {
                $base_url = 'http://localhost/';
            }
            $this->set_item('base_url', $base_url);
        }
    }
}