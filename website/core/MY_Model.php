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
     * MySQL组合字段
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
     * 去除反引号
     * @param $str
     * @return array|string
     */
    public function rm_back_quote($str) {
        return str_replace('`', '', $str);
    }

    /**
     * 从一组数组里查询字符串是否存在
     * @param $str 要查找的字符串
     * @param array $data 数组
     * @param int $flag 0时查索引, 1时查值
     * @return bool
     */
    public function find_field($str, $data=array(), $flag=0) {
        if ($flag === 0) {
            $arr = array_keys($data);
        } else {
            $arr = array_values($data);
        }

        foreach ($arr as $value) {
            $res = strpos($value, $str);
            if ($res !== FALSE) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * 判断是否为查询总数
     * @param bool $limit
     * @return bool
     */
    public function is_count($limit=FALSE) {
        if (! empty($limit) && ($limit=="rows")) {
            return TRUE;
        }
        return FALSE;
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
     * $a = array("a"=>15,"b","c");
     * `a` = 15 OR `b` = 15 OR `c` = 15
     * @param $data 数组 或 字符串
     * @param array $where 传入 where 条件，以便判断拼接时是否需要用 AND 连接
     * @return string
     */
    protected function make_or_wh_or($data, $where=array()) {
        $where_str = $this->_wh_cond($data);
        return empty($where_str) ? array() : (empty($where) ? $where_str : " ( {$where_str} ) ");
    }

    /**
     * 多重条件
     * @param array $where_arr
     * @return array|string
     */
    protected function make_and_wh($where_arr=array()) {
        $result = array();
        if (! empty($where_arr)) {
            if (is_string($where_arr)) {
                $result = $where_arr;
            }

            if (is_array($where_arr)) {
                return  implode(' AND ', $where_arr);
            }
        }

        return $result;
    }

    /**
     * 自定义构造 where
     * @param $list 数组 或 字符串
     * @param string $conf 条件连接符 !=<>like
     * @param bool $flag  FALSE为AND连接符,默认TRUE为OR连接符
     * @return string
     */
    private function _wh_cond($list, $conf="=", $flag=TRUE) {
        $where = "";
        $flag = $flag ? "OR" : "AND";

        if(is_string($list)) {
            $where = $list;
        } else if (is_array($list)) {
            $where_arr = array();
            $tmp = "";
            foreach($list as $k => $w) {
                if (is_numeric($k)) {
                    $k = $w;
                    $w = $tmp;
                }

                $tmp = $w;
                $where_arr[] = is_numeric($w) ?
                    sprintf('`%s` %s %d', $k, $conf, $w):
                    sprintf('`%s` %s "%s"', $k, $conf, $w);
            }
            $where .= implode($where_arr, " {$flag} ");
        }

        return $where;
    }

    /**
     * 写入数据库操作日志
     * @param $db
     */
    protected function log($db) {
        log_message('error', $db->last_query());
    }
}