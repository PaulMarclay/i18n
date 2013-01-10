<?php
    /*
    *   I18N version 1.0
    *
    *   Imagina - Plugin.
    *
    *
    *   Copyright (c) 2012 Dolem Labs
    *
    *   Authors:    Paul Marclay (paul.eduardo.marclay@gmail.com)
    *
    */

    class I18n extends Ancestor {
        
        private $_lang = null;
        
        public function getAcceptLanguages() {
            // Author: http://www.thefutureoftheweb.com/blog/about-me
            $langs = array();
            
            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                // break up string into pieces (languages and q factors)
                preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);

                if (count($lang_parse[1])) {
                    // create a list like "en" => 0.8
                    $langs = array_combine($lang_parse[1], $lang_parse[4]);

                    // set default to 1 for any without q factor
                    foreach ($langs as $lang => $val) {
                        if ($val === '') $langs[$lang] = 1;
                    }

                    // sort list based on value	
                    arsort($langs, SORT_NUMERIC);
                }
            }
            
            return $langs;
        }
        
        public function getPreferredLanguage() {
            $langs = $this->getAcceptLanguages();
            return $langs[0];
        }
        
        public function getDefaultLanguage() {
            $langs = $this->getAcceptLanguages();
            return $langs[0];
        }
        
        public function getText($key) {
            if (!$this->_lang) {
    			$this->_lang = Yaml_SfYaml::load(Api::getPath('locales').$this->getDefaultLanguage().'.yml');
    		}
    		
    		return $this->_lang[$key];
        }
    }