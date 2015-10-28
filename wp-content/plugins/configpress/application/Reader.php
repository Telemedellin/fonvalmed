<?php

/**
  Copyright (C) <2015>  Vasyl Martyniuk <vasyl@vasyltech.com>

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

 */

require_once __DIR__ . '/Evaluator.php';

/**
 * ConfigPress Reader
 *
 * Parse configuration string
 *
 * @package ConfigPress
 * @author Vasyl Martyniuk <vasyl@vasyltech.com>
 * @copyright Copyright C 2015 Vasyl Martyniuk
 */
class Reader {

    /**
     * 
     */
    const SEPARATOR = '.';

    /**
     * 
     */
    const INHERIT_KEY = ':';

    /**
     * Parse INI config
     * 
     * Parse configuration string
     *
     * @param  string $string
     * 
     * @return array|bool
     * 
     * @throws Exception
     */
    public function parseString($string) {
        if (!empty($string)) {
            //parse the string
            set_error_handler(array($this, 'parserError'));
            $ini = parse_ini_string($string, true);
            restore_error_handler();

            $response = $this->process($ini);
        } else {
            $response = array();
        }

        return $response;
    }

    /**
     * 
     * @param type $error
     * @param type $message
     * @throws \Exception
     */
    public function parserError($error, $message = '') {
        Throw new \Exception(
            sprintf('Error parsing config string: %s', $message), $error
        );
    }

    /**
     * Process data from the parsed ini file.
     *
     * @param  array $data
     * @return array
     */
    protected function process(array $data) {
        $config = array();
        
        foreach ($data as $section => $data) {
            //check if section has parent section or property
            if (preg_match('/[\s\w]{1}' . self::INHERIT_KEY . '[\s\w]{1}/', $section)) {
                $section = $this->inherit($section, $config);
            } else {
                //evaluate the section and if not false move forward
                $evaluator = new Evaluator($section);
                if ($evaluator->evaluate()) {
                    $section = $evaluator->getAlias();
                    $config[$section] = array();
                } else {
                    continue; //conditional section that did not meet condition
                }
            }

            if (is_array($data)) { //this is a INI section, build the nested tree
                $this->buildNestedSection($data, $config[$section]);
            } else { //single property, no need to do anything
                $config[$section] = $this->parseValue($data);
            }
        }

        return $config;
    }

    /**
     * 
     * @param type $section
     * @param type $config
     * @return type
     */
    protected function inherit($section, &$config) {
        $sections = explode(self::INHERIT_KEY, $section);
        $target = trim($sections[0]);
        $parent = trim($sections[1]);

        if (isset($config[$parent])) {
            $config[$target] = $config[$parent];
        }

        return $target;
    }

    /**
     * 
     * @param type $data
     * @param type $config
     */
    protected function buildNestedSection($data, &$config) {
        foreach ($data as $key => $value) {
            $root = &$config;
            foreach (explode(self::SEPARATOR, $key) as $level) {
                if (!isset($root[$level])) {
                    $root[$level] = array();
                }
                $root = &$root[$level];
            }
            $root = $this->parseValue($value);
        }
    }

    /**
     * 
     * @param type $value
     * @return type
     */
    protected function parseValue($value) {
        return trim($value);
    }

}