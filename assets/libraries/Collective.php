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
            $CI->load->config('return_code');
            $return_code = $CI->config->item('return_code');
            $msg = $return_code['error_'.$flag] ?? '未知错误';
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

    /**
     * 根据 IP 获取归属地
     * @param $ip
     * @return array
     */
    public static function get_ip_location($ip) {
        $CI = &get_instance();

        if ($ip === '') {
            $ip = $CI->input->ip_address();
        }

        if (! filter_var($ip, FILTER_VALIDATE_IP)) {
            $ip = gethostbyname($ip);
        }

        if ( ! $CI->input->valid_ip($ip)) {
            return [];
        }

        $dbfile = ASSETS . 'libraries/dat/ip2region.db';
        $CI->load->library('Ip2Region', [$dbfile]);
        $data = $CI->ip2region->binarySearch($ip);

        $info_arr = explode('|', $data['region']);
//        var_dump($info_arr);exit;

        $city_arr = [];
        if ($info_arr[4] == '内网IP') {
            return ['内网IP'];
        }

        if ($info_arr[0] != '中国') {
            $city_arr[] = $info_arr[0];
        }

        $filter_arr = [
            '香港',
            '澳门',
            '北京',
            '上海',
            '天津',
            '重庆',
            '0',
        ];
        if (! in_array($info_arr[2], $filter_arr)) {
            $city_arr[] = $info_arr[2];
        }

        if (! in_array($info_arr[3], ['台湾', '0'])) {
            $city_arr[] = $info_arr[3];
        }

        return $city_arr;
    }

    /**
     * 获取页码
     * @param $submit 提交的 submit 是否提交(用于翻页后的搜索)
     * @param $page 页码
     * @return int
     */
    public static function get_page_number($submit, $page) {
        return empty($_POST[$submit]) && isset($_GET[$page]) && (int)$_GET[$page] > 0 ? (int)$_GET[$page] : 1;
    }

    /**
     * 获取页码
     * @param $page 页码
     * @return int
     */
    public static function page_number($page) {
        if (isset($_POST[$page])) {
            $page_num = ((int)$_POST[$page] > 0) ? (int)$_POST[$page] : 1;
        } else if (isset($_GET[$page])) {
            $page_num = ((int)$_GET[$page] > 0) ? (int)$_GET[$page] : 1;
        } else {
            $page_num = 1;
        }

        return $page_num;
    }

    /**
     * 分页
     * @param $per_page 每页数量
     * @param $total 总数
     * @param $uri class/method 页
     * @return mixed
     */
    public static function pagination($per_page, $total, $uri) {
        $CI = &get_instance();

        $CI->load->library('pagination');

        $config['base_url'] = site_url($uri);
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;

        $config['first_link'] = '首页';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '末页';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['prev_link'] = '上一页';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '下一页';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['display_pages'] = TRUE;

        $CI->pagination->initialize($config);
        $page_str = $CI->pagination->create_links();

        return $page_str;
    }
}

