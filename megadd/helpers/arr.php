<?php
namespace megadd\helpers {
if (!defined('MEGADD')) die ('Error 404 Not Found');
	class arr {
		static function get($arr , $name, $default) {
			return isset($arr[$name]) ? $arr[$name] : $default;
		}
		
		static function array_add($array, $key, $value) {
			if ( ! isset($array[$key])) $array[$key] = $value;
			return $array;
		}
		
		static function array_build($array, Closure $callback) {
			$results = array();
			foreach ($array as $key => $value) {
				list($innerKey, $innerValue) = call_user_func($callback, $key, $value);
				$results[$innerKey] = $innerValue;
			}
			return $results;
		}

		static function array_divide($array) {
			return array(array_keys($array), array_values($array));
		}

		static function array_dot($array, $prepend = '') {
			$results = array();
			foreach ($array as $key => $value) {
				if (is_array($value)) {
					$results = array_merge($results, array_dot($value, $prepend.$key.'.'));
				} else {
					$results[$prepend.$key] = $value;
				}
			}
			return $results;
		}

		static function array_except($array, $keys) {
			return array_diff_key($array, array_flip((array) $keys));
		}

		static function array_fetch($array, $key) {
			foreach (explode('.', $key) as $segment) {
				$results = array();
				foreach ($array as $value) {
					$value = (array) $value;
					$results[] = $value[$segment];
				}
				$array = array_values($results);
			}
			return array_values($results);
		}

		static function array_first($array, $callback, $default = null) {
			foreach ($array as $key => $value) {
				if (call_user_func($callback, $key, $value)) return $value;
			}
			return value($default);
		}

		static 	function array_last($array, $callback, $default = null) {
			return array_first(array_reverse($array), $callback, $default);
		}

		static function array_flatten($array) {
			$return = array();
			array_walk_recursive($array, function($x) use (&$return) { $return[] = $x; });
			return $return;
		}

		static function array_forget(&$array, $key) {
			$keys = explode('.', $key);
			while (count($keys) > 1) {
				$key = array_shift($keys);
				if ( ! isset($array[$key]) || ! is_array($array[$key])) {
					return;
				}
				$array =& $array[$key];
			}
			unset($array[array_shift($keys)]);
		}	
	
		static function array_get($array, $key, $default = null) {
			if (is_null($key)) return $array;
			if (isset($array[$key])) return $array[$key];
			foreach (explode('.', $key) as $segment) {
				if ( ! is_array($array) || ! array_key_exists($segment, $array)) {
					return value($default);
				}
				$array = $array[$segment];
			}
			return $array;
		}

		static function array_only($array, $keys) {
			return array_intersect_key($array, array_flip((array) $keys));
		}

		static function array_pluck($array, $value, $key = null) {
			$results = array();
			foreach ($array as $item) {
				$itemValue = is_object($item) ? $item->{$value} : $item[$value];
				if (is_null($key)) {
					$results[] = $itemValue;
				} else {
					$itemKey = is_object($item) ? $item->{$key} : $item[$key];
					$results[$itemKey] = $itemValue;
				}
			}
			return $results;
		}

		static function array_pull(&$array, $key, $default = null) {
			$value = array_get($array, $key, $default);
			array_forget($array, $key);
			return $value;
		}

		static function array_set(&$array, $key, $value) {
			if (is_null($key)) return $array = $value;
			$keys = explode('.', $key);
			while (count($keys) > 1) {
				$key = array_shift($keys);
				if ( ! isset($array[$key]) || ! is_array($array[$key])) {
					$array[$key] = array();
				}
				$array =& $array[$key];
			}
			$array[array_shift($keys)] = $value;
			return $array;
		}

		static function array_where($array, Closure $callback) {
			$filtered = array();
			foreach ($array as $key => $value) {
				if (call_user_func($callback, $key, $value)) $filtered[$key] = $value;
			}
			return $filtered;
		}		
	}
}
?>