<?php
namespace MathInterpreter;

use Math\BigMatrix;

/**
 * 矩阵类
 *
 * @author az13js <1654602334@qq.com>
 */
class Matrix extends BigMatrix
{
    /**
     * 构造方法
     *
     * @param int $rows 行数
     * @param int $cols 列数
     */
    public function __construct(int $rows, int $cols)
    {
        parent::__construct($rows, $cols);
    }
}
