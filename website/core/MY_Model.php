<?php
/**
 *
 * MY_Model.php
 * @author  : Skiychan <dev@skiy.net>
 * @link    : http://www.zzzzy.com
 * @created : 2016/06/24
 * @modified:
 * @version : 0.0.1
 */

class MY_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
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
}