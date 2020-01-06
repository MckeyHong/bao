<?php

namespace App\Traits;

trait ApiTraits
{
    /**
     * [API串接] 參數加密
     *
     * @param  string $encyptData [先將參數陣列用http_build_query處理]
     * @param  string $encryptKey
     * @return string
     */
    public function doApiEncrypt($encyptData, $encryptKey)
    {
        try {
            return base64_encode(openssl_encrypt($encyptData, 'AES-256-CBC', $encryptKey, OPENSSL_RAW_DATA, $encryptKey));
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * [API串接] 參數解密
     *
     * @param  string $decryptData
     * @param  string $encryptKey
     * @return array
     */
    public function doApiDecrypt($decryptData, $encryptKey)
    {
        try {
            $decryptData = openssl_decrypt(base64_decode($decryptData), 'AES-256-CBC', $encryptKey, OPENSSL_RAW_DATA, $encryptKey);
            parse_str($decryptData, $response);
            return $response;
        } catch (\Exception $e) {
            return [];
        }
    }
}
