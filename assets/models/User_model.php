<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * File:   User_model.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2018/07/21
 */

class User_model extends MY_Model {
    private $_table = 'users';
    private $_table_2 = 'login_logs';

    public function __construct() {
        parent::__construct();
    }

    /**
     * 获取账号信息
     * @param $uid
     * @param $name
     * @return mixed
     */
    public function get_user($uid='', $name='') {
        if ($uid === '' && $name === '') {
            return FALSE;
        }

        $where = [];
        if ($uid !== '') {
            $where['id'] = $uid;
        }
        if ($name !== '') {
            $where['name'] = $name;
        }

        $result = $this->db->where($where)
            ->get($this->_table)
            ->row_array();

        $this->log($this->db);
        return $result;
    }

    /**
     * 添加管理员登录日志
     * @param $data
     * @return mixed
     */
    public function add_login_log($data) {
        if (empty($data)) {
            return FALSE;
        }
        $result = $this->db->insert($this->_table_2, $data);

        $this->log($this->db);
        return $result;
    }

    /**
     * 修改用户信息
     * @param $uid
     * @param $data
     * @param array $where_arr
     * @return mixed
     */
    public function modify_user($uid, $data, $where_arr=[]) {
        $where = [
            'id' => $uid,
        ];

        if (! empty($where_arr) && is_array($where_arr)) {
            $where = array_merge($where, $where_arr);
        }

        $this->db->where($where)
            ->update($this->_table, $data);

        $rows = $this->db->affected_rows();

        $this->log($this->db);
        return $rows;
    }

    /**
     * 登录日志
     * @param $where
     * @param array $where_ext
     * @param array $limit
     * @return mixed
     */
    public function login_log_list($where, $where_ext=[], $limit=[]) {
        $this->db->where($where);
        $where_ext_str = $this->make_and_wh($where_ext);
        $this->db->where($where_ext_str);

        if (! empty($limit) && ($limit=="rows")) {
            $result = $this->db->from($this->_table_2)->count_all_results();
            $this->log($this->db);
            return $result;
        }

        $fields = 'l.id,l.uid,l.ip,l.address,l.created_at,u.name';
        $this->db->select($fields)
            ->from($this->_table_2 . ' AS l');

        $join_1 = 'l.uid = u.id';
        $this->db->join($this->_table . ' AS u', $join_1, 'left');

        $order_str = 'l.id desc';
        $this->db->order_by($order_str);

        $limit = $this->make_limit($limit);
        if (! empty($limit)) {
            $this->db->limit($limit[0], $limit[1]);
        }

        $result = $this->db->get()
            ->result_array();

        $this->log($this->db);
        return $result;
    }
}