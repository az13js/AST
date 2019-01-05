<?php
namespace Math;

/**
 * 高斯核函数算子
 *
 * @author az13js <1654602334@qq.com>
 */
class GaussianKernel
{
    /** @var object */
    private $x;
    /** @var object */
    private $xc;
    /** @var Number */
    private $o;
    /** @var float|null */
    private $val = null;

    /**
     * 构造函数
     *
     * @param Number|BigMatrix $x
     * @param Number|BigMatrix $xc
     * @param Numebr $o
     */
    public function __construct(object $x, object $xc, Number $o)
    {
        $this->x = $x;
        $this->xc = $xc;
        $this->o = $o;
    }

    /**
     * 获取计算结果
     *
     * @return Number
     */
    public function getValue(): Number
    {
        if (is_null($this->val)) {
            $two = new Number(2);
            $this->val = $this->x->sub($this->xc)->norm2()->square()->div($two->multi($this->o->square()));
        }
        return $this->val;
    }
}
