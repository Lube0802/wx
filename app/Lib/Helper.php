<?php

namespace App\Lib;

use QrCode;

class Helper
{
    /**
     * json数据返回
     * @param int $status
     * @param string $msg
     * @param array $data
     * @return string
     */
    public function sendJson($status = 200, $msg = '', $data = [])
    {
        return json_encode([
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
            'sessionId' => session_id(),
        ], JSON_PRETTY_PRINT);
    }

    /**
     * 模型内方法返回状态信息
     * @param int $status
     * @param string $msg
     * @param array $data
     * @return array
     */
    public function modelReturn($status = 200, $msg = '', $data = [])
    {
        return [
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ];
    }

    /**
     * 取ip地址
     * @return string
     */
    public function getIp()
    {
        $ip = '';
        if (isset($_SERVER)) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                if (strstr($ip, ",")) {
                    $x = explode(',', $ip);
                    $ip = trim(end($x));
                }
            } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } elseif (isset($_SERVER["REMOTE_ADDR"])) {
                $ip = $_SERVER["REMOTE_ADDR"];
            } else {
                $ip = $_SERVER["SSH_CLIENT"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")) {
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            } elseif (getenv("HTTP_CLIENT_IP")) {
                $ip = getenv("HTTP_CLIENT_IP");
            } else {
                $ip = getenv("REMOTE_ADDR");
            }
        }
        return $ip;
    }

    /**
     * curl post
     * @param string $url
     */
    public static function curlPost($url,$post_data,$cert=Array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_NOBODY, false); // remove body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        if($cert){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, $cert['cert']);
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, $cert['key']);
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * 通过get去请求一个网络地址
     * 每次请求等待时间为1秒
     * 如果请求失败或超时则进行重试
     * @param string $url 要请求的地址
     * @param int $retry 请求超时或失败后重试的次数
     * @return mixed
     */
    public function curlGet($url, $retry = 1)
    {
        static $retryCount = 0;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 1000);

        $result = curl_exec($ch);
        curl_close($ch);

        $retryCount++;

        if($result === false && $retryCount <= $retry){
            return $this->curlGet($url, $retry);
        } else {
            return $result;
        }
    }

    /**
     * 写入log文件
     * @param string $logFile 日志文件名
     * @param string $msg 日志内容
     */
    public function log($logFile, $msg)
    {
        $write = date("Y-m-d H:i:s")." :\n{$msg}\n";

        file_put_contents(storage_path("logs/{$logFile}.log"), $write, FILE_APPEND);
    }

    public function makeQrcode($url, $name, $logo = false)
    {
        $path = $_SERVER['DOCUMENT_ROOT'].'/upload/qrcode/';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if (empty($url)) {
            return ['status' => 201, 'msg' => 'url不能为空'];
        }

        $filePath = $path.$name.'.png';

        if ($logo == true) {
            $logo = base_path("public/imgs/tangduo.png");
            QrCode::format('png')->size(400)->merge($logo, .14, true)->margin(1)->generate($url, $filePath);
        } else {
            Qrcode::format('png')->size(400)->margin(1)->generate($url, $filePath);
        }

        // 增加二维码容错率
        QrCode::errorCorrection('H');

        return '/upload/qrcode/'.$name.'.png';
    }

    /**
     * 判断请求是否来自微信浏览器
     * @return bool true是来自微信浏览器，false不是来自微信浏览器
     */
    public function isWechat()
    {
        static $res = 0;

        if($res == 0) {
            if(isset($_SERVER['HTTP_USER_AGENT'])) {
                $userAgent = addslashes($_SERVER['HTTP_USER_AGENT']);

                //不是微信内置浏览器
                if(strpos($userAgent, 'MicroMessenger') == false) {
                    $res = 1;
                } else {
                    //是微信内置浏览器
                    $res = 2;
                }
            }
        } else {
            $res = 1;
        }

        if($res == 1) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 导出excel
     * @param array $res
     * @param $name
     */
    public function setExcel($res = array(), $name){
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$name.".xls");
        echo "<table border='1' width='100%'>";
        if (isset($res['title']) && !empty($res['title'])) {
            $keys = '';
            foreach ($res['title'] as $key => $value) {
                $keys .= "<th>".iconv("UTF-8","GB2312//IGNORE",$value."\t")."</th>";
            }
            echo "<tr>".$keys."</tr>";
        }
        if (isset($res['content']) &&! empty($res['content'])) {
            foreach ($res['content'] as $key => $value) {
                $content = '';
                foreach ($value as $k => $v) {
                    $content .= iconv("UTF-8","GB2312//IGNORE",$v."\t");
                }
                echo "<tr>".$content."</tr>";
            }
        }
        echo "</table>";
    }
}