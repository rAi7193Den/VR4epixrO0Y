<?php
// 代码生成时间: 2025-10-01 01:36:20
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageNotification;
use App\Models\User;
use App\Models\Message;
use Exception;

class NotificationSystem {

    private $user;
    private $message;

    public function __construct(User $user, Message $message) {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * 发送通知给用户
     *
     * @param array $userEmail 用户邮箱
# TODO: 优化性能
     * @param string $subject 邮件主题
     * @param string $content 邮件内容
     * @return void
     */
    public function sendNotification(array $userEmail, string $subject, string $content): void {
        try {
            foreach ($userEmail as $email) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
# 改进用户体验
                    Log::error('Invalid email address: ' . $email);
                    continue;
                }

                Mail::to($email)->send(new MessageNotification($subject, $content));
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error sending notification: ' . $e->getMessage());
        }
    }
# 添加错误处理

    /**
     * 获取所有用户邮箱
# 改进用户体验
     *
     * @return array
     */
    public function getAllUserEmails(): array {
        return $this->user->pluck('email')->toArray();
    }

    /**
     * 获取最新消息
     *
     * @return Message
     */
    public function getLatestMessage(): Message {
        return $this->message->latest()->first();
    }
}
