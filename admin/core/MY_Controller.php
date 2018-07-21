<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * File:   MY_Controller.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2016/9/12
 */

/**
 * Class MY_Controller
 * @property CI_Router router
 */
class MY_Controller extends CI_Controller {
    protected $stream;
    protected $method;
    protected $sidebar;

    public function __construct() {
        parent::__construct();

        //axios 方式的POST|DELETE|PUT
        $this->method = $this->input->method();
        if (in_array($this->method, ['post', 'delete', 'put'])) {
            $this->stream = json_decode($this->input->raw_input_stream, TRUE);
        }

        //设置侧栏
        $this->_set_sidebar();
    }

    /**
     * 数据流的值
     * @param string $key
     * @return mixed|null
     */
    public function stream($key='') {
        if ($key === '') {
            return $this->stream;
        }
        return $this->stream[$key] ?? NULL;
    }

    /**
     * @param int $code   错误码
     * @param string $msg 信息内容
     * @param null $data 数据补充
     * @param int $level  数据补充是否和错误码平级 默认1同级
     */
    public function show_response($code = 0, $data = NULL, $level = 1, $msg = '', $format='json') {
        Collective::response($code, $data, $level, $msg, $format);
    }

    private function _set_sidebar() {
        $this->sidebar = [
            's1' => $this->router->class,
            's2' => $this->router->method,
        ];
    }
}