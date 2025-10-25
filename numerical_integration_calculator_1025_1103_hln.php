<?php
// 代码生成时间: 2025-10-25 11:03:53
 * Numerical Integration Calculator using PHP and Laravel
 *
 * This class provides a simple numerical integration calculator
 * which can calculate the definite integral of a function using the
 * rectangle method (also known as the Riemann sum method).
 *
 * @package NumericalIntegrationCalculator
 * @author Your Name
 * @version 1.0
 */

class NumericalIntegrationCalculator {

    /**
     * Calculate the definite integral of a function using the rectangle method.
     *
     * @param string $function The function to integrate.
     * @param float $a The lower bound of the integral.
     * @param float $b The upper bound of the integral.
     * @param int $n The number of rectangles to use (the more rectangles, the higher the precision).
     * @return float The result of the integral.
     * @throws InvalidArgumentException If the function is invalid or the parameters are out of range.
     */
    public function calculate($function, $a, $b, $n) {
        // Validate input parameters
        if (!is_numeric($a) || !is_numeric($b) || !is_numeric($n) || $a >= $b || $n <= 0) {
            throw new InvalidArgumentException('Invalid parameters for integral calculation.');
        }

        // Define the width of each rectangle
        $width = ($b - $a) / $n;

        // Initialize the sum of the rectangles' areas
        $sum = 0;

        // Calculate the area of each rectangle and add it to the sum
        for ($i = 0; $i < $n; $i++) {
            $x = $a + $i * $width;
            $sum += $this->evaluateFunction($function, $x) * $width;
        }

        // Return the final sum as the result of the integral
        return $sum;
    }

    /**
     * Evaluate the given function at a specific point.
     *
     * @param string $function The function to evaluate.
     * @param float $x The point at which to evaluate the function.
     * @return float The value of the function at the given point.
     * @throws InvalidArgumentException If the function is invalid.
     */
    private function evaluateFunction($function, $x) {
        // Use eval() to evaluate the function, but be cautious as it can be a security risk
        // In a real-world application, consider using a safer alternative, such as a parsing library
        if (!empty($function) && is_numeric($x)) {
            return eval("return (\$function)(\$x);");
        } else {
            throw new InvalidArgumentException('Invalid function or input value for evaluation.');
        }
    }
}

// Example usage:
try {
    $calculator = new NumericalIntegrationCalculator();
    $result = $calculator->calculate('2 * x', 0, 1, 100);
    echo "The result of the integral is: " . $result;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
