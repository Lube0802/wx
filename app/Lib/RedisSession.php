<?php

namespace App\Lib;

/**
 * 基于redis的会话管理器
 * Class RedisSession
 * @package App\Lib
 */
class RedisSession implements \SessionHandlerInterface
{
    private $redis;

    public function __construct()
    {
        $this->redis = app('redis');
    }

    /**
     * 启用session
     * @param string $save_path
     * @param string $session_id
     * @return bool
     */
    public function open($save_path, $session_id)
    {
        return true;
    }

    /**
     * 关闭session
     * @return bool
     */
    public function close()
    {
        return true;
    }

    /**
     * 销毁session
     * @param string $session_id
     */
    public function destroy($session_id)
    {
        $this->redis->del('session:'.$session_id);
    }

    /**
     * 回收机制
     * @param int $maxlifetime
     * @return bool
     */
    public function gc($maxlifetime)
    {
        return true;
    }

    /**
     * 读取session
     * @param string $session_id
     * @return $this|string
     */
    public function read($session_id)
    {
        $result = $this->redis->get('session:'.$session_id);

        if (!$result) {
            $result = '';
        }

        return $result;
    }

    /**
     * 写入session
     * @param string $session_id
     * @param string $session_data
     * @param int $expire_time
     * @return bool
     */
    public function write($session_id, $session_data, $expire_time = 3600*24)
    {
        $this->redis->set('session:'.$session_id, $session_data);
        $this->redis->expire('session:'.$session_id, $expire_time);
        return true;
    }
}