<?php
/**
 *
 * Baidu_Controller.php
 * @author  : Skiychan <dev@skiy.net>
 * @link    : https://www.zzzzy.com
 * @created : 5/21/16
 * @modified:
 * @version : 0.0.1
 */

require ASSETS . 'libraries/REST_Controller.php';

class Pub_Controller extends REST_Controller {
    private $_status_code = 200;

    public $apikey = '';
    private $_secretkey = '';

    public function __construct() {
        parent::__construct();
        //$this->check_permissions();
    }

    /**
     * @param int $code   错误码
     * @param string $msg 信息内容
     * @param null $data 数据补充
     * @param int $level  数据补充是否和错误码平级 默认1同级
     */
    public function show_response($code = 0, $data = NULL, $level = 1, $msg = '') {
        $response = Common::response($code, $data, $level, $msg, 'rest');

        return $this->response($response, $this->_status_code);
    }

    /**
     * 设置网页状态码
     * @param int $code
     */
    public function set_status_code($code = 200) {
         $this->_status_code = $code;
    }

    /**
     * 检测权限,使用 head 来判断
     */
    public function check_permissions() {
        $api_key   = $this->head('Apikey');
        $random    = $this->head('Random');
        $signature = $this->head('Signature');

        //ucfirst
        if (empty($api_key)) {
            return $this->show_response(50001);
        }

        $setSecert = $this->_getSecertKey($api_key);
        if ($setSecert != TRUE) {
            return $this->show_response(50002);
        }

        //只要请求了接口,就添加统计（需要把 redis 初始化提前）
        //$redis->hincrby(self::STAT, $api_key, 1);

        $mysign = hash_hmac('ripemd160', $random, $this->_secretkey);
        if ($mysign != $signature) {
            return $this->show_response(50003);
        }

    }

    /**
     * 获取secertkey
     * @param $apikey
     */
    private function _getSecertKey($apikey) {
        if (empty($apikey)) {
            return;
        }

        $this->load->model('customers_model');
        $result_customer = $this->customers_model->customer_apikey($apikey);
        if ($result_customer) {
            $this->apikey = $apikey;
            $this->_secretkey = $result_customer['secretkey'];

            return true;
        }

        return;
    }
}