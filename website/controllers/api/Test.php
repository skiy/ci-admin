<?php
/**
 *
 * test.php
 * @author  : Skiychan <dev@skiy.net>
 * @link    : http://www.zzzzy.com
 * @created : 2016/06/29
 * @modified:
 * @version : 0.0.1
 */

require ASSETS . 'libraries/Pub_Controller.php';

class Test extends Pub_Controller {
    public function __construct() {
        parent::__construct();

    }

    public function list_get() {
        $data = [
            'name'  => "skiy",
            'sex'   => 1,
            'add'   => "shenzhen",
            'store' => "http://oupag.taobao.com",
            'email' => "dev@skiy.net"
        ];

        $this->show_response(0, ['data' => $data]);
    }

}