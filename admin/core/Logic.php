<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 逻辑层
 * File:   Logic.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2018/07/12
 */

/**
 * Logic Class
 *
 * @package        CodeIgniter
 * @subpackage    Libraries
 * @category    Libraries
 * @author        EllisLab Dev Team
 * @link        https://codeigniter.com/user_guide/libraries/config.html
 */
class Logic {

    /**
     * Class constructor
     *
     * @return    void
     */
    public function __construct() {
        log_message('info', 'Logic Class Initialized');
    }

    // --------------------------------------------------------------------

    /**
     * @param $key
     * @return mixed
     */
    public function __get($key) {
        // Debugging note:
        //	If you're here because you're getting an error message
        //	saying 'Undefined Property: system/core/Model.php', it's
        //	most likely a typo in your model code.
        return get_instance()->$key;
    }
}