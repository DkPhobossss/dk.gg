<?php
class Script
{
	private $_dir = "";
	private $_file = "";
	private $_params = "";
	private $_url = "";
    private $_url_args = "";

	public function  __construct($filename, &$params = array() , $url = '' , $url_args = '')
    {
		$this->initialize($filename, $params, $url, $url_args);
	}

	public function initialize($filename, &$params, $url = '', $url_args = '')
    {
        $filename = mb_ereg_replace('\.', '', $filename);
		$p = strrpos($filename, "/");

		if ($p !== false)
        {
			$p++;
			$this->_dir = substr($filename, 0, $p);
		}

		$this->_file = substr($filename, $p);
		$this->_dir .= $this->_file . "/";

        if (!empty($url))
        {
            $this->_url = $url;
            $this->_url_args = $url_args;
        }

		$this->_params = $params;
	}


	public function _run()
    {
		return include(func_get_arg(0));
	}


	public function _process()
    {
		$filename = $this->_dir . $this->_file;

		//if (Config::$localization) {
		//	Localization::load($this->_dir);
		//}

		ob_start();
		if (is_readable($filename . ".php")) {
			$this->_run($filename . ".php");
		}

		if (is_readable($filename . ".tpl")) {
			$this->_run($filename . ".tpl");
		}

		//if (Config::$localization) {
		//	Localization::unload();
		//}
		return ob_get_clean();
	}

	public function script($name, $params = array())
    {
        if (mb_substr($name, 0, 1) == '/') {
            $name = 'scripts' . $name;
        }
        else {
            $name = $this->_dir . $name;
        }

		$script = new Script($name, $params);
		return $script->_process();
	}

	public function cscript($name, $params = array())
	{
		$script = clone $this;
		$script->initialize($this->_dir . $name);
		return $script->_process();
	}

	public function subscript($name, $params = array())
	{
		$old_dir = $this->_dir;
		$old_file = $this->_file;
		$old_params = &$this->_params;

		$this->initialize($this->_dir . $name, $params);

		$result = $this->_process();

		$this->_dir = $old_dir;
		$this->_file = $old_file;
		$this->_params = $old_params;

		return $result;
	}

	public function nextscript($name, $params = array())
	{
		$old_dir = $this->_dir;
		$old_file = $this->_file;
		$old_params = &$this->_params;
		$old_url = $this->_url;
        $old_url_args = $this->_url_args;

		$filename = HFU::next($name);

		$next = $filename;
		$this->_url .= $this->_url_args . "/" . $next;
        $this->_url_args = HFU::args($next, true);

        if ($this->_dir == 'scripts/' && $filename != 'site')
        {
            $this->_dir .= 'site/';
        }

		while (!is_readable($this->_dir . $filename . "/" . $next . ".php") && !is_readable($this->_dir . $filename . "/" . $next . ".tpl")) {
			$next = HFU::next();
			if (empty($next)) {
				break;
			}
			$filename .= "/" . $next;
			$this->_url .= $this->_url_args . "/" . $next;
            $this->_url_args = HFU::args($next, true);
		}

		if (!empty($next)) {
			$this->initialize($this->_dir . $filename, $params);
			$result = $this->_process();
		}
		else {
			$result = false;
		}

		$this->_dir = $old_dir;
		$this->_file = $old_file;
		$this->_params = $old_params;
		$this->_url = $old_url;
        $this->_url_args = $old_url_args;

		return $result;
	}

	public function dir()
    {
		return $this->_dir;
	}

	public function url($path = '', $args = false, $query = false)
    {
        $url = $this->_url;

        if (!empty($path)) {
            $url .= '/' . $path;
        }

        $url_parts = mb_split('/', $url);
        $i = 0;
        $url_cparts = array();
        foreach ($url_parts as $part) {
            if ($part == '.') {
                $url_cparts = array();
            }
            elseif ($part == '..') {
                array_pop($url_cparts);
            }
            else {
                array_push($url_cparts, $part);
            }
        }

        if (is_array($query)) {
            $query = http_build_query($query);
        }

        if ($args) {
            $url = implode('/', $url_cparts) . '-' . $args;
        }
        else {
            $url = implode('/', $url_cparts);
        }
        return $url . (empty($query) ? '' : '?' . $query);
	}

    public function url_ajax($name = false, $path = '', $query = false)
    {
        return '/ajax.php' . $this->url($path, $name, $query);
    }

	public function param($key, $default = false)
    {
		return isset($this->_params[$key]) ? $this->_params[$key] : $default;
	}

	public function arg($index, $default = '')
    {
		return HFU::arg($this->_file, $index, $default);
	}

	public function js($filename = "")
    {
		if (empty($filename)) {
			$filename = $this->_file;
		}

		Output::js($this->_dir . $filename);
	}

	public function css($file_name = "")
    {
		Output::css($this->_dir . (empty($file_name) ? $this->_file : $file_name) );
	}
}