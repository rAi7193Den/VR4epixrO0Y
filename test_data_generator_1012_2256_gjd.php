<?php
// 代码生成时间: 2025-10-12 22:56:45
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Str;
use Exception;

class TestDataGenerator {

    /**
     * Generate a specified number of test users.
     *
     * @param int $count The number of users to generate.
     * @return void
     */
    public function generateUsers(int $count): void {
        try {
            for ($i = 0; $i < $count; $i++) {
                User::create([
                    'name' => 'Test User ' . ($i + 1),
                    'email' => 'test' . ($i + 1) . '@example.com',
                    'password' => bcrypt('password'),
                    'remember_token' => Str::random(10),
                ]);
            }
        } catch (Exception $e) {
            // Handle the error appropriately
            // Log the error, or return an error response
            echo 'Error generating users: ' . $e->getMessage();
        }
    }

    /**
     * Generate a specified number of test posts for each user.
     *
     * @param int $count The number of posts to generate per user.
     * @return void
     */
    public function generatePosts(int $count): void {
        try {
            $users = User::all();
            foreach ($users as $user) {
                for ($i = 0; $i < $count; $i++) {
                    Post::create([
                        'user_id' => $user->id,
                        'title' => 'Test Post ' . ($i + 1),
                        'body' => 'This is a test post body.',
                    ]);
                }
            }
        } catch (Exception $e) {
            echo 'Error generating posts: ' . $e->getMessage();
        }
    }

    /**
     * Generate a specified number of test comments for each post.
     *
     * @param int $count The number of comments to generate per post.
     * @return void
     */
    public function generateComments(int $count): void {
        try {
            $posts = Post::all();
            foreach ($posts as $post) {
                for ($i = 0; $i < $count; $i++) {
                    Comment::create([
                        'post_id' => $post->id,
                        'user_id' => $post->user_id,
                        'content' => 'This is a test comment.',
                    ]);
                }
            }
        } catch (Exception $e) {
            echo 'Error generating comments: ' . $e->getMessage();
        }
    }
}
