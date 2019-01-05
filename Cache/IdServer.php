<?php
namespace Cache;

/**
 * 获取一个全局的唯一ID
 *
 * 这是单例模式，使用方法：
 * $server = IdServer::getServer();
 * $id = $server->getId();
 *
 * @author az13js <1654602334@qq.com>
 */
class IdServer
{
    /** @var IdServer|null 保存自身的实例 */
    private static $server = null;

    /** @var \Redis 保存Redis实例 */
    private $redis;

    /**
     * 构造函数
     *
     * 创建一个Redis的实例
     */
    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1', 6379);
        /* 使用持续连接会不会比较好呢 */
        /* $this->redis->pconnect('127.0.0.1', 6379); */
    }

    /**
     * 实例方法
     *
     * @return IdServer 自身的唯一实例
     */
    public static function getServer(): IdServer
    {
        if (is_null(self::$server)) {
            self::$server = new static();
        }
        return self::$server;
    }

    /**
     * 获取一个唯一的ID
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->redis->incr('idserver');
    }
}
