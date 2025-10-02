<?php
// 代码生成时间: 2025-10-02 18:45:47
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Exception;

class UnzipTool {

    /**
     * Unzip a file to a given directory.
     *
     * @param string $filePath The path to the ZIP file.
     * @param string $destination The directory where files will be extracted.
     * @return bool
     * @throws Exception
     */
    public function unzip(string $filePath, string $destination): bool
    {
        // Check if the file exists
        if (!file_exists($filePath)) {
            throw new Exception("File not found: {$filePath}");
        }

        // Create the destination directory if it does not exist
        if (!file_exists($destination)) {
            Storage::makeDirectory($destination);
        }

        $zip = new ZipArchive;

        // Open the ZIP file
        if ($zip->open($filePath) === true) {
            // Extract the contents to the destination directory
            $zip->extractTo($destination);
            // Close the ZIP file
            $zip->close();

            return true;
        } else {
            throw new Exception("Failed to open ZIP file: {$filePath}");
        }
    }

    /**
     * Check if the ZIP file can be opened.
     *
     * @param string $filePath The path to the ZIP file.
     * @return bool
     */
    public function canOpenZip(string $filePath): bool
    {
        $zip = new ZipArchive;

        return $zip->open($filePath) === true;
    }
}
