<?php
/**
 *
 * File:   MY_Model.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2017-12-13
 */

class MY_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 设置查询数量 或 偏移量
     * @param $limit 数量 或 偏移量
     * @return mixed
     */
    protected function make_limit($limit) {
        (is_string($limit) or is_numeric($limit)) && $limit = explode(",", $limit);
        if (is_array($limit)) {
            count($limit) == 1 && $limit[] = 0;
        }

        if (empty($limit) || ! is_array($limit)) {
            $limit = FALSE;
        }

        return $limit;
    }

    /**
     * Mysql组合字段
     * @param $fields 字段数组或者,分隔的字符串
     * @param $prefix 前缀
     * @return array|string
     */
    public function assemble_field($fields, $prefix) {
        if (! is_array($fields)) {
            $fields = explode(",", $fields);
        }
        $fields_arr = array();
        foreach ($fields as $keys => $values) {
            $fields_arr[] = $prefix.".".$values;
        }
        $fields = implode(",", $fields_arr);  //最终组合成 f.id,f.name,f.email形式
        return $fields;
    }

    /**
     * 写入数据库操作日志
     */
    protected function log() {
        log_message('info', $this->db->last_query());
    }
}