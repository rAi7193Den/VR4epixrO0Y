<?php
// 代码生成时间: 2025-09-24 00:32:38
// JSON Converter
// Converts JSON data to an array and vice versa.

/**
 * Convert JSON data to an associative array.
 *
 * @param string $jsonData The JSON data to convert.
 * @return array|null
 * @throws Exception If the JSON data is invalid.
 */
function jsonToArray(string $jsonData): ?array
{
    try {
        // Decode the JSON data to an associative array.
        $data = json_decode($jsonData, true);
        // Check if the JSON data is valid.
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON data.');
        }
        return $data;
    } catch (Exception $e) {
        // Handle any exceptions that occur during the decoding process.
        throw new Exception('Failed to convert JSON to array: ' . $e->getMessage());
    }
}

/**
 * Convert an associative array to JSON data.
 *
 * @param array $data The array to convert.
 * @param int $options Options for encoding.
 * @return string
 * @throws Exception If the data cannot be encoded to JSON.
 */
function arrayToJson(array $data, int $options = JSON_UNESCAPED_UNICODE): string
{
    try {
        // Encode the array to JSON data.
        $jsonData = json_encode($data, $options);
        // Check if the encoding was successful.
        if ($jsonData === false) {
            throw new Exception('Failed to encode data to JSON.');
        }
        return $jsonData;
    } catch (Exception $e) {
        // Handle any exceptions that occur during the encoding process.
        throw new Exception('Failed to convert array to JSON: ' . $e->getMessage());
    }
}

// Example usage:
// $json = '{"name":"John", "age":30}';
// $array = jsonToArray($json);
// print_r($array);
// $jsonConverted = arrayToJson($array);
// echo $jsonConverted;