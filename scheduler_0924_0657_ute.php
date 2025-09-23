<?php
// 代码生成时间: 2025-09-24 06:57:16
use Illuminate\Support\Facades\Schedule;
# NOTE: 重要实现细节
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Scheduler extends ConsoleKernel
{
    protected $commands = [];
# 增强安全性

    /**
     * 定义应用的命令调度任务。
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */