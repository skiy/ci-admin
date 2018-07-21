<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * File:   Welcome.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2018-03-23
 */

class Welcome extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        echo 'Admin';
    }
}