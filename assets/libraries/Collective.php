<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 公共方法
 * File:   Collective.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2016/9/12
 */

class Collective {

    /**
     * 返回资源头格式
     * @var array
     */
    private static $_supported_formats = [
        'json' => 'application/json',
        'array' => 'application/json',
        'csv' => 'application/csv',
        'html' => 'text/html',
        'jsonp' => 'application/javascript',
        'php' => 'text/plain',
        'serialized' => 'application/vnd.php.serialized',
        'xml' => 'application/xml'
    ];

    public function __get($name) {
        $CI = &get_instance();
        return $CI->$name;
    }

    /**
     * 返回资源数据
     * @param int $code 错误码
     * @param array $data_arr 数据
     * @param int $level 数据是否和错误码同级
     * @param string $msg 提示信息
     * @param string $format 返回格式
     * @return array
     */
    public static function response($code = 0, $data_arr = [], $level = 1, $msg = '', $format = 'json') {

        $data = [
            'code'      => $code,
            'message'   => $msg === '' ? self::get_return_message($code) : $msg,
            'success'   => $code === 0 ? TRUE : FALSE,
            'extra'     => []
        ];

        if (! empty($data_arr)) {
            if (! is_array($data_arr)) {
                $data_arr = ['data' => $data_arr];
            }

            if ($level == 1) {
                $data = array_merge($data, $data_arr);
            } else {
                $data['extra'] = $data_arr;
            }
        }

        if ($format == 'xml') {
            self::_response_xml($data);
        } else if ($format == 'json') {
            self::_response_json($data);
        }

        return $data;
    }

    /**
     * 转 json 格式
     * @param $data
     */
    private static function _response_json($data) {
        $json_data = json_encode($data, JSON_UNESCAPED_UNICODE);
        self::_format_data($json_data, 'json');
    }

    /**
     * 转 xml 格式
     * @param $data
     */
    private static function _response_xml($data) {
        $CI = & get_instance();
        $CI->load->library('Array2xml');
        $xml_data = $CI->array2xml->convert($data);
        self::_format_data($xml_data, 'xml');
    }

    /**
     * 按格式输出数据
     * @param $data
     * @param string $format 格式
     */
    private static function _format_data($data, $format='html') {
        $CI = & get_instance();
        $CI->output->set_content_type(self::$_supported_formats[$format], strtolower($CI->config->item('charset')))
                    ->set_output($data)
            ->_display();
        exit;
    }

    /**
     * @param int/string $flag 标识 (标识码为数字时,为错误码)
     * @param array $param_arr 格式化时作为 sprintf 的参数
     * @return mixed|string
     */
     public static function get_return_message($flag = 0, $param_arr = []) {
        $CI = & get_instance();
        $msg = '';
        if (is_numeric($flag)) {
            $CI->load->language('return_code');
            $msg = $CI->lang->line('error_'.$flag);
        }

        if (! empty($param_arr)) {
            $args[] = $msg;
            if (! is_array($param_arr)) {
                $param_arr = [$param_arr];
            }
            $args = array_merge($args, $param_arr);
            $msg = call_user_func_array("sprintf", $args);
        }

        return $msg;
    }
}

