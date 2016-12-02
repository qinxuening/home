<?php 
    class encrypt {  
        private $key = "95780b1d30b62754f6aab6f4c7cecceb"; 
        public function setKey($key = NULL) {  
            $this->key = (! $key) ? $this->key : $key;  
        }  
      
        public function encrypt($input, $is_id = FALSE) { // 数据加密  
            $_map = array ();  
            if ($is_id)  
                $input = base_convert ( $input, 10, 36 );  
            $hashkey = md5 ( $input . $this->key );  
            if (isset ( $_map [$hashkey] ))  
                return $_map [$hashkey];  
            $size = mcrypt_get_block_size ( MCRYPT_3DES, 'ecb' );  
            $input = $this->pkcs5_pad ( $input, $size );  
            $key = str_pad ( $this->key, 24, '0' );  
            $td = mcrypt_module_open ( MCRYPT_3DES, '', 'ecb', '' );  
            $iv = @mcrypt_create_iv ( mcrypt_enc_get_iv_size ( $td ), MCRYPT_RAND );  
            @mcrypt_generic_init ( $td, $key, $iv );  
            $data = mcrypt_generic ( $td, $input );  
            mcrypt_generic_deinit ( $td );  
            mcrypt_module_close ( $td );  
            $tmp = '';  
            if ($is_id) {  
                $len = strlen ( $data );  
                for($i = 0; $i < $len; $i ++)  
                    $tmp = $tmp . str_pad ( dechex ( ord ( $data {$i} ) ), 2, 0, STR_PAD_LEFT );  
                $_map [$hashkey] = $tmp;  
                return $tmp;  
            }  
            $_map [$hashkey] = $tmp;  
            $data = base64_encode ( $data );  
            return $data;  
        }  
        public function decrypt($encrypted, $is_id = FALSE) { // 数据解密  
            $_map = array ();  
            if ($is_id) {  
                $len = strlen ( $encrypted );  
                $tmp = '';  
                for($i = 0; $i < $len; $i = $i + 2)  
                    $tmp = $tmp . chr ( hexdec ( $encrypted {$i} . $encrypted {$i + 1} ) );  
                $encrypted = $tmp;  
            } else  
                $encrypted = base64_decode ( $encrypted );  
            $hashkey = md5 ( $encrypted . $this->key );  
            if (isset ( $map [$hashkey] ))  
                return $_map [$hashkey];  
            $key = str_pad ( $this->key, 24, '0' );  
            $td = mcrypt_module_open ( MCRYPT_3DES, '', 'ecb', '' );  
            $iv = @mcrypt_create_iv ( mcrypt_enc_get_iv_size ( $td ), MCRYPT_RAND );  
            $ks = mcrypt_enc_get_key_size ( $td );  
            @mcrypt_generic_init ( $td, $key, $iv );  
            $decrypted = mdecrypt_generic ( $td, $encrypted );  
            mcrypt_generic_deinit ( $td );  
            mcrypt_module_close ( $td );  
            $y = $this->pkcs5_unpad ( $decrypted );  
            if ($is_id)  
                $y = base_convert ( $y, 36, 10 );  
            $_map [$hashkey] = $y;  
            return $y;  
        }  
      
        private function pkcs5_pad($text, $blocksize) {  
            $pad = $blocksize - (strlen ( $text ) % $blocksize);  
            return $text . str_repeat ( chr ( $pad ), $pad );  
        }  
        private function pkcs5_unpad($text) {  
            $pad = ord ( $text {strlen ( $text ) - 1} );  
            if ($pad > strlen ( $text )) {  
                return false;  
            }  
            if (strspn ( $text, chr ( $pad ), strlen ( $text ) - $pad ) != $pad) {  
                return false;  
            }  
            return substr ( $text, 0, - 1 * $pad );  
        }
    }
?>