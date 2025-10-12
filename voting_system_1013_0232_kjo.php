<?php
// 代码生成时间: 2025-10-13 02:32:24
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// 定义投票模型
class Vote extends Model
{
    use HasFactory;

    // 定义模型属性，使其可以被批量赋值
    protected $fillable = ['option_id', 'user_id'];

    // 定义选项与投票之间的多对多关系
    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class);
    }

    // 定义用户与投票之间的多对多关系
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}

// 定义选项模型
class Option extends Model
{
    use HasFactory;

    // 定义模型属性，使其可以被批量赋值
    protected $fillable = ['name'];

    // 定义选项与投票之间的多对多关系
    public function votes(): BelongsToMany
    {
        return $this->belongsToMany(Vote::class);
    }
}

// 定义用户模型
class User extends Model
{
    use HasFactory;

    // 定义模型属性，使其可以被批量赋值
    protected $fillable = ['name', 'email', 'password'];

    // 定义用户与投票之间的多对多关系
    public function votes(): BelongsToMany
    {
        return $this->belongsToMany(Vote::class);
    }
}

// 投票系统服务类
class VotingSystemService
{
    // 创建投票
    public function createVote($userId, $optionId): bool
    {
        try {
            // 检查用户是否已经为该选项投票
            if (Vote::where('user_id', $userId)->where('option_id', $optionId)->exists()) {
                return false;
            }

            // 创建新的投票记录
            Vote::create(['user_id' => $userId, 'option_id' => $optionId]);
            return true;
        } catch (Exception $e) {
            // 处理异常情况
            Log::error($e->getMessage());
            return false;
        }
    }

    // 获取所有选项及其投票数
    public function getVotesCount(): array
    {
        try {
            $votesCount = Option::withCount('votes')->get();
            return $votesCount->toArray();
        } catch (Exception $e) {
            // 处理异常情况
            Log::error($e->getMessage());
            return [];
        }
    }
}

// 以下为Laravel路由示例
// Route::post('vote', function (VotingSystemService $votingSystemService, Request $request) {
//     $userId = $request->user()->id;
//     $optionId = $request->input('option_id');
//     $result = $votingSystemService->createVote($userId, $optionId);
//     return response()->json(['result' => $result]);
// });

// Route::get('votes-count', function (VotingSystemService $votingSystemService) {
//     return response()->json($votingSystemService->getVotesCount());
// });
