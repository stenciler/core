<?php

namespace Stencil\Engine;

if ( !defined( 'ABSPATH' ) ) exit;
 
class Mustache {

	protected $helpers = [];

	public function __construct() {
		$this->add_helper('limitLength', array($this, 'limitLength'));
		$this->add_helper('items', array($this, 'items'));
		$this->add_helper('attr', array($this, 'attribute'));
	}

	public function add_helper($name, $callable) {
		$this->helpers[$name] = $callable;
	}

	public function attribute($string, $context) {

		$output = '';
		if(isset($context['attributes']) && is_array($context['attributes'])) {
			$data = $context['attributes'];
			$output .= call_user_func_array(array($this,'process'), array($string, $data));
		}
		return $output;
	}

	public function items($string, $context) {
		$output = '';
		if(isset($context['items']) && is_array($context['items'])) {
			foreach ($context['items'] as $key => $item) {
				$output .= call_user_func_array(array($this,'process'), array($string, $item));
			}
		}
		return $output;
	}

	public function limitLength($string, array $context = []) {
		$string =  call_user_func_array(array($this,'process'), array($string, $context));
		$string = strip_tags($string);
		if (strlen($string) > 200) {
			$stringCut = substr($string, 0, 200);
			$endPoint = strrpos($stringCut, ' ');
			$string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
		}
		return $string;
	}

	

	public function process($template, array $context = []) {
		$helpers = $this->helpers;
		$pattern = '@({{)(?<SECTION_TYPE>#|\^)(?P<SECTION_NAME>[a-zA-Z\-\_\.]+)(}})(?P<SECTION_CONTENT>.*?)({{/\3}})@sm';

		$template = preg_replace_callback($pattern, function (array $matches) use ($context, $helpers) {
			$result = '';
			$key = $matches['SECTION_NAME'];
			if ($matches['SECTION_TYPE'] === '^') {
				if (!array_key_exists($key, $context) || empty($context[$key])) {
					$result = $matches['SECTION_CONTENT'];
				}
			} elseif ($matches['SECTION_TYPE'] === '#') {
				$content = $matches['SECTION_CONTENT'];
				if(isset($helpers[$matches['SECTION_NAME']])) {
					if(is_callable($helpers[$matches['SECTION_NAME']])) {
						$call = call_user_func_array($helpers[$matches['SECTION_NAME']], array($content, $context));
						if($call !== null) {
							$result = $call;
						}
					}
				}
			}  elseif ($matches['SECTION_TYPE'] === '$') {
				echo "dollar found";
			} else {
				throw new \UnexpectedValueException('Unknown section type in template.');
			}
			return $result;
		}, $template);

		$pattern = '/{{\!\s?(?P<COMMENT>.+)\s?}}|{{{\s?(?P<HTML_RAW>[a-zA-Z\-\_\.]+)\s?}}}|{{\s?(?P<HTML_ENCODE>[a-zA-Z\-\_\.]+)\s?}}/m';


		return preg_replace_callback($pattern, function (array $matches) use ($context, $helpers) {
			
			if ($matches['COMMENT'] !== '') {
				$result = '';
			} elseif ($matches['HTML_RAW'] !== '') {
				$encode = false;
				$key = $matches['HTML_RAW'];
			} elseif ($matches['HTML_ENCODE'] !== '') {
				$encode = true;
				$key = $matches['HTML_ENCODE'];
			} else {
				throw new \UnexpectedValueException('Unknown tag type in template.');
			}
			if (!isset($result) && isset($key)) {
				$result = $key;
				if (array_key_exists($key, $context)) {
					$result = $context[$key];
					if (isset($encode) && (bool) $encode === true) {
						$result = htmlentities($result, ENT_HTML5 | ENT_QUOTES);
					}
				}
			}
			return $result;
		}, $template);

	}

	public function render($template, array $context = []) {
		return $this->process($template, $context);
		return $this->process($template, $context);
	}
}

function Stencil_Mustache() {
	return new Stencil_Mustache();
}