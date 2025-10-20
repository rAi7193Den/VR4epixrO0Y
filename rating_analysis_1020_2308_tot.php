<?php
// 代码生成时间: 2025-10-20 23:08:55
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;

// 定义模型User
class User extends Model
{
    use HasFactory, SoftDeletes;

    // 用户模型关联到评价实体
    public function ratings(): BelongsTo
    {
        return $this->belongsTo(Rating::class);
    }
}

// 定义模型Rating
class Rating extends Model
{
    use HasFactory, SoftDeletes;

    // 评价实体关联到用户
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

// 评价分析服务类
class RatingAnalysisService
{
    /**
     * 分析评价数据
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function analyzeRatings(array $filters): Collection
    {
        try {
            // 应用过滤器到查询
            $query = Rating::query()->with('user');

            // 应用其他过滤器条件
            if (isset($filters['user_id'])) {
                $query->where('user_id', $filters['user_id']);
            }

            // 获取评价数据
            return $query->get();
        } catch (\Exception $e) {
            // 错误处理
            report($e);
            return collect(); // 返回空集合
        }
    }
}

// 数据迁移文件
// 用于创建users和ratings表
// database/migrations/xxxx_xx_xx_xxxxxx_create_users_table.php
class CreateRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('score');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}

// 工厂文件
// database/factories/RatingFactory.php
class RatingFactory extends Factory
{
    protected $model = Rating::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'score' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->text,
        ];
    }
}

// Seeder文件
// database/seeders/RatingSeeder.php
class RatingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory()->count(10)->create();

        foreach ($users as $user) {
            Rating::factory()->count(5)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}

// 控制器文件
// app/Http/Controllers/RatingController.php
class RatingController extends Controller
{
    /**
     * 显示评价分析结果
     *
     * @param RatingAnalysisService $service
     * @return \Illuminate\Http\Response
     */
    public function show(RatingAnalysisService $service)
    {
        $filters = request()->all();
        $ratings = $service->analyzeRatings($filters);

        return response()->json($ratings);
    }
}
