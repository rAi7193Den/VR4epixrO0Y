<?php
// 代码生成时间: 2025-10-07 03:18:23
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Csv\Reader;
use League\Csv\Writer;
use League\Csv\Statement;
use League\Csv\Header\Reader as HeaderReader;
use League\Csv\Header\Writer as HeaderWriter;
use League\Csv\Exception as CsvException;

class CsvBatchProcessor {

    private $sourcePath;
    private $destinationPath;
    private $batchSize;
    private $delimiter;
    private $enclosure;
    private $escape;

    public function __construct($sourcePath, $destinationPath, $batchSize = 100, $delimiter = ',', $enclosure = '