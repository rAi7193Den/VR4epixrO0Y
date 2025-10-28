<?php
// 代码生成时间: 2025-10-29 01:45:22
class MonteCarloSimulator {
    // 蒙特卡洛模拟的方法
    public function simulatePi(int $iterations): float {
        $circleCount = 0;
        for ($i = 0; $i < $iterations; $i++) {
            if ($this->isInsideCircle()) {
                $circleCount++;
            }
        }

        // 蒙特卡洛模拟计算π的公式：4 * (圆内点数 / 总点数)
        return 4 * ($circleCount / $iterations);
    }

    // 判断点是否在单位圆内
    private function isInsideCircle(): bool {
        $x = Random::float(0, 1); // 生成0到1之间的随机数
        $y = Random::float(0, 1); // 生成0到1之间的随机数

        return $x * $x + $y * $y <= 1;
    }
}
?