<?php
namespace Math;

use \Cache\DistributingCache;
use \Cache\IdServer;

/**
 * 大矩阵对象
 *
 * 假设矩阵很大，同时程序需要实例化多个这样的对象，那么就会出现内存不足的问题。
 * 大矩阵通过将具体的元素保存在缓存的方法大大减少内存的占用，只有需要访问元素
 * 的时候才会去缓存里获取。
 *
 * 为了保证数据唯一性，这里使用了保存在缓存中的自增ID
 *
 * @author az13js <1654602334@qq.com>
 */
class BigMatrix
{
    /** @var int 行数 */
    private $rows;
    /** @var int 列数 */
    private $cols;
    /** @var int 实例化时从ID服务器获得的唯一ID */
    private $id;

    /**
     * 构造方法
     *
     * @param int $rows 行数
     * @param int $cols 列数
     */
    public function __construct(int $rows, int $cols)
    {
        if ($rows < 1 || $cols < 1) {
            throw new \Exception('行数列数不能小于1');
        }
        $this->rows = $rows;
        $this->cols = $cols;
        $this->id = IdServer::getServer()->getId();
    }

    /**
     * 获取矩阵指定位置的值
     *
     * @param int $row
     * @param int $col
     * @return mixed 返回null，如果没有值的话
     */
    public function get(int $row, int $col)
    {
        $this->checkSize($row, $col);
        return DistributingCache::get($this->id.'r'.$row.'c'.$col);
    }

    /**
     * 设置矩阵指定位置的值
     *
     * @param int $row
     * @param int $col
     * @param mixed $val
     * @return bool
     */
    public function set(int $row, int $col, $val): bool
    {
        $this->checkSize($row, $col);
        return DistributingCache::set($this->id.'r'.$row.'c'.$col, $val);
    }

    /**
     * 行数
     *
     * @return int
     */
    public function rowNumber(): int
    {
        return $this->rows;
    }

    /**
     * 列数
     *
     * @return int
     */
    public function colNumber(): int
    {
        return $this->cols;
    }

    /**
     * 用于输出矩阵的值，调试使用
     *
     * @return bool
     */
    public function dump(): bool
    {
        $rows = $this->rowNumber();
        $cols = $this->colNumber();
        if ($rows * $cols > 1000) {
            echo '元素太多' . PHP_EOL;
            return false;
        }
        for ($i = 1; $i <= $rows; $i++) {
            for ($j = 1; $j <= $cols; $j++) {
                $data = $this->get($i, $j);
                if (is_numeric($data)) {
                    echo $data . ' ';
                } elseif (is_object($data)) {
                    echo $data->getValue() . ' ';
                }
            }
            echo PHP_EOL;
        }
        return true;
    }

    /**
     * 检查行和列会不会超过范围
     *
     * @param int $row
     * @param int $col
     * @return void
     * @throw \Exception
     */
    private function checkSize(int $row, int $col)
    {
        if ($row < 1 || $col < 1 || $row > $this->rows || $col > $this->cols) {
            throw new \Exception('矩阵参数超出行数列数的范围');
        }
    }
}
