<?php

/**
 * Class Rectangle
 * 给你四个坐标点，判断它们能不能组成一个矩形，如判断([0,0],[0,1],[1,1],[1,0])能组成一个矩形
 * 解题思路：
 *
 * 1. 4个不重复的点，至少三点不在一条直线上
 *
 * 2. 任意两点间距离为边长, 列出所有边长并放入一个数组中, 对该数组去重, 数组中应该只有3个元素(长方形)或2个元素(正方形)
 *
 * 3. 判断数组里面的元素是否满足勾股定理
 */
class Rectangle
{
    protected $point = [];

    public function __construct(array $points)
    {
        $this->point = $points;
    }

    public function check()
    {
        //首先判断4个不重复的点，至少三点不在一条直线上
        $x_axis=array_map('array_shift',$this->point);
        $y_axis=array_map('array_pop',$this->point);
        if(count(array_unique($x_axis)) < 2 || count(array_unique($y_axis)) < 2){
            return false;
        }

        $pointNum = count($this->point);
        for ($i = 0; $i < $pointNum; $i++) {
            for ($j = $i + 1; $j < $pointNum; $j++) {
                //获取所有两点之间的直线长度
                $length[] = $this->getLength($this->point[$i], $this->point[$j]);
            }

        }
        $length = array_unique($length);

        switch (count($length)) {
            case 3:
                $maxLength = max($length);
                $minLength = min($length);
                $otherLength=array_diff($length,[$maxLength,$minLength]);
                if($maxLength=$minLength*$otherLength){
                    return true;
                }
                return false;
            case 2:
                $maxLength = max($length);
                $minLength = min($length);
                //勾股定理
                if ($maxLength == $minLength * 2) {
                    return true;
                }
                return false;
            default:
                return false;
        }
    }

    //两点之间的直线平方值
    private function getLength($point1, $point2)
    {
        return pow(abs($point1[0] - $point2[0]), 2) + pow(abs($point1[1] - $point2[1]), 2);
    }
}

//$point = [[0, 0], [4, 5], [7, 1], [2, 4]];
$point = [[0,0],[0,1],[1,1],[1,0]];
$Rectangle = new Rectangle($point);
$return = $Rectangle->check();
echo '<pre>';
print_r($return);
exit;
