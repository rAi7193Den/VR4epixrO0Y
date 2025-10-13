<?php
// 代码生成时间: 2025-10-14 02:37:25
namespace App\Http\Services;

class SortingAlgorithm {

    /**
     * Sort an array using bubble sort algorithm.
     *
     * @param array $array The array to sort.
     * @return array The sorted array.
     */
    public static function bubbleSort(array $array): array {
        if (empty($array)) {
            throw new \Exception('Array is empty');
        }

        $length = count($array);
        for ($i = 0; $i < $length - 1; $i++) {
            for ($j = 0; $j < $length - $i - 1; $j++) {
                if ($array[$j] > $array[$j + 1]) {
                    // Swap elements
                    $temp = $array[$j];
                    $array[$j] = $array[$j + 1];
                    $array[$j + 1] = $temp;
                }
            }
        }

        return $array;
    }

    /**
     * Sort an array using quick sort algorithm.
     *
     * @param array $array The array to sort.
     * @return array The sorted array.
     */
    public static function quickSort(array $array): array {
        if (empty($array)) {
            throw new \Exception('Array is empty');
        }

        $less = $greater = [];
        $pivot = array_shift($array);
        foreach ($array as $value) {
            if ($value < $pivot) {
                $less[] = $value;
            } elseif ($value > $pivot) {
                $greater[] = $value;
            }
        }

        return array_merge(
            self::quickSort($less),
            [$pivot],
            self::quickSort($greater)
        );
    }

    /**
     * Sort an array using merge sort algorithm.
     *
     * @param array $array The array to sort.
     * @return array The sorted array.
     */
    public static function mergeSort(array $array): array {
        if (count($array) == 1) return $array;

        $mid = count($array) / 2;
        $left = array_slice($array, 0, $mid);
        $right = array_slice($array, $mid);

        return self::merge(
            self::mergeSort($left),
            self::mergeSort($right)
        );
    }

    /**
     * Merge two sorted arrays.
     *
     * @param array $left The first array to merge.
     * @param array $right The second array to merge.
     * @return array The merged array.
     */
    private static function merge(array $left, array $right): array {
        $result = [];
        while (count($left) > 0 && count($right) > 0) {
            if ($left[0] < $right[0]) {
                $result[] = array_shift($left);
            } else {
                $result[] = array_shift($right);
            }
        }

        while (count($left) > 0) {
            $result[] = array_shift($left);
        }

        while (count($right) > 0) {
            $result[] = array_shift($right);
        }

        return $result;
    }
}
