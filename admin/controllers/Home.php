<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * File:   Home.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2018-03-23
 */

class Home extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $response = array();
        $this->load->view('public/header');
        $this->load->view('public/sidebar', $this->sidebar);
        $this->load->view('home/index', $response);
        $this->load->view('public/footer');
    }
}