<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * File:   MY_Loader.php
 * Author: Skiychan <dev@skiy.net>
 * Created: 2016/9/13
 */

class MY_Loader extends CI_Loader {
    protected $_ci_logics =	array();
    protected $_ci_logic_paths =	array(APPPATH);

    protected $_ci_services =	array();
    protected $_ci_service_paths =	array(APPPATH);

    public function __construct() {
        parent::__construct();
		
		$this->_ci_ob_level  = ob_get_level();
		$this->_ci_library_paths = array(APPPATH, ASSETS, BASEPATH);
		$this->_ci_helper_paths = array(APPPATH, ASSETS, BASEPATH);
		$this->_ci_model_paths = array(APPPATH, ASSETS);
		$this->_ci_view_paths = array(APPPATH.'views/'	=> TRUE, ASSETS.'views/'=>TRUE);

        $this->_ci_logic_paths = array(APPPATH, ASSETS);
    }

    /**
     * 扩展 逻辑层
     * @param $logic
     * @param string $name
     * @return $this
     */
    public function logic($logic, $name = '')
    {
        if (empty($logic))
        {
            return $this;
        }
        elseif (is_array($logic))
        {
            foreach ($logic as $key => $value)
            {
                is_int($key) ? $this->logic($value, '') : $this->logic($key, $value);
            }

            return $this;
        }

        $path = '';
        // Is the service in a sub-folder? If so, parse out the filename and path.
        if (($last_slash = strrpos($logic, '/')) !== FALSE)
        {
            // The path is in front of the last slash
            $path = substr($logic, 0, ++$last_slash);

            // And the logic name behind it
            $logic = substr($logic, $last_slash);
        }

        if (empty($name))
        {
            $name = $logic;
        }

        if (in_array($name, $this->_ci_logics, TRUE))
        {
            return $this;
        }

        $CI =& get_instance();
        if (isset($CI->$name))
        {
            throw new RuntimeException('The logics name you are loading is the name of a resource that is already being used: '.$name);
        }

        // Note: All of the code under this condition used to be just:
        //
        //       load_class('Logic', 'core');
        //
        //       However, load_class() instantiates classes
        //       to cache them for later use and that prevents
        //       CI_Logic from being an abstract class and is
        //       sub-optimal otherwise anyway.
        if ( ! class_exists('CI_Logic', FALSE))
        {
            $app_path = APPPATH.'core'.DIRECTORY_SEPARATOR;
            if (file_exists($app_path.'Logic.php'))
            {
                require_once($app_path.'Logic.php');
                if ( ! class_exists('Logic', FALSE))
                {
                    throw new RuntimeException($app_path."Logic.php exists, but doesn't declare class Logic");

                }
            }
            $class = config_item('subclass_prefix').'Logic';
            if (file_exists($app_path.$class.'.php'))
            {
                require_once($app_path.$class.'.php');
                if ( ! class_exists($class, FALSE))
                {
                    throw new RuntimeException($app_path.$class.".php exists, but doesn't declare class ".$class);
                }
            }
        }
        $logic = ucfirst($logic);
        if ( ! class_exists($logic, FALSE))
        {
            foreach ($this->_ci_logic_paths as $logic_path)
            {
                if ( ! file_exists($logic_path.'logics/'.$path.$logic.'.php'))
                {
                    continue;
                }

                require_once($logic_path.'logics/'.$path.$logic.'.php');
                if ( ! class_exists($logic, FALSE))
                {
                    throw new RuntimeException($logic."logics/".$path.$logic.".php exists, but doesn't declare class ".$logic);
                }

                break;
            }

            if ( ! class_exists($logic, FALSE))
            {
                throw new RuntimeException('Unable to locate the logic you have specified: '.$logic);
            }
        }
        elseif ( ! is_subclass_of($logic, 'MY_Logic'))
        {
            throw new RuntimeException("Class ".$logic." already exists and doesn't extend MY_Logic");
        }

        $this->_ci_logics[] = $name;
        $CI->$name = new $logic();
        return $this;
    }

}