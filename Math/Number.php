<?php
namespace Math;

/**
 * 数字
 *
 * @author az13js <1654602334@qq.com>
 */
class Number
{
    /** @var float */
    private $val;

    /**
     * 构造方法
     *
     * @param int $val 值
     */
    public function __construct(float $val)
    {
        $this->val = $val;
    }

    /**
     * 返回值
     *
     * @return float
     */
    public function getValue(): float
    {
        return $this->val;
    }

    /**
     * 设置值
     *
     * @param float $val
     * @return bool
     */
    public function setValue(float $val): bool
    {
        $this->val = $val;
        return true;
    }

    /**
     * 减去一个可求得实数值的对象
     *
     * @param object $x
     * @return Number
     */
    public function sub(object $x): Number
    {
        return new static($this->getValue() - $x->getValue());
    }

    /**
     * 2范数
     *
     * @return Number
     */
    public function norm2(): Number
    {
        return new static(abs($this->getValue()));
    }

    /**
     * 平方
     *
     * @return Number
     */
    public function square(): NUmber
    {
        return new static(pow($this->getValue(), 2));
    }

    /**
     * 除法
     *
     * @param object $x 分母
     * @return Number
     */
    public function div(object $x): Number
    {
        $y = $x->getValue();
        if ($y == 0) {
            throw new \Exception('分母不能等于0');
        }
        return new static($this->getValue() / $y);
    }
}
