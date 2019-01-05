<?php
namespace Cache;

/**
 * 分布式 Key-Value 存储系统
 *
 * TODO az13js 这里只是简单实现，没有真的做成哈希分布式的
 *
 * @author az13js <1654602334@qq.com>
 */
class DistributingCache
{
    /** @var array Redis服务器列表 */
    private static $serverInstance = [];

    /**
     * 根据键获取值
     *
     * @param string $key
     * @return mixed 获取失败返回 null
     */
    public static function get(string $key)
    {
        $server = self::getServerInstance($key);
        $val = $server->get($key);
        if (false !== $val) {
            return unserialize($val);
        }
        return null;
    }

    /**
     * 保存任意一个值到缓存系统
     *
     * @param string $key
     * @param mixed $val
     * @return bool
     */
    public static function set(string $key, $val): bool
    {
        $server = self::getServerInstance($key);
        return $server->set($key, serialize($val));
    }

    /**
     * 获取保存有Key键的服务器实例
     *
     * TODO az13js 根据key进行哈希，从已知的服务器中返回其中一台
     *
     * @param string $key
     * @return \Redis
     */
    private static function getServerInstance(string $key): \Redis
    {
        if (empty(self::$serverInstance)) {
            self::$serverInstance[] = new \Redis();
            self::$serverInstance[0]->connect('127.0.0.1', 6379);
        }
        return self::$serverInstance[0];
    }
}
