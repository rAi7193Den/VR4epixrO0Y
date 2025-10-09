<?php
// 代码生成时间: 2025-10-09 15:47:43
use Illuminate\Support\Facades\Http;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Docker Orchestrator Class
 * This class provides functionality for managing Docker containers, images, and networks.
 */
class DockerOrchestrator {

    /**
     * The path to the Docker Compose file.
     *
     * @var string
     */
    protected $composeFilePath;

    /**
     * The path to the Docker executable.
     *
     * @var string
     */
    protected $dockerBinaryPath;

    /**
     * Create a new DockerOrchestrator instance.
     *
     * @param string $composeFilePath The path to the Docker Compose file.
     * @param string $dockerBinaryPath The path to the Docker executable.
     */
    public function __construct($composeFilePath, $dockerBinaryPath = '/usr/bin/docker') {
        $this->composeFilePath = $composeFilePath;
        $this->dockerBinaryPath = $dockerBinaryPath;
    }

    /**
     * Deploy a Docker stack using Docker Compose.
     *
     * @param string $stackName The name of the stack to deploy.
     * @return void
     */
    public function deployStack($stackName) {
        try {
            $process = new Process([$this->dockerBinaryPath, 'compose', '-f', $this->composeFilePath, 'up', '-d']);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            info("Stack [$stackName] deployed successfully.");
        } catch (ProcessFailedException $exception) {
            error("Failed to deploy stack [$stackName]: " . $exception->getMessage());
            throw $exception;
        }
    }

    /**
     * Remove a Docker stack.
     *
     * @param string $stackName The name of the stack to remove.
     * @return void
     */
    public function removeStack($stackName) {
        try {
            $process = new Process([$this->dockerBinaryPath, 'compose', '-f', $this->composeFilePath, 'down']);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            info("Stack [$stackName] removed successfully.");
        } catch (ProcessFailedException $exception) {
            error("Failed to remove stack [$stackName]: " . $exception->getMessage());
            throw $exception;
        }
    }

    /**
     * Get the current state of a Docker stack.
     *
     * @param string $stackName The name of the stack to check.
     * @return array
     */
    public function getStackState($stackName) {
        try {
            $process = new Process([$this->dockerBinaryPath, 'compose', '-f', $this->composeFilePath, 'ps']);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $output = $process->getOutput();
            return Yaml::parse($output);
        } catch (ProcessFailedException $exception) {
            error("Failed to get stack state [$stackName]: " . $exception->getMessage());
            throw $exception;
        }
    }
}
