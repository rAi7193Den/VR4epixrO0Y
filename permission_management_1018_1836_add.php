<?php
// 代码生成时间: 2025-10-18 18:36:06
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// 用户权限管理系统模型
class Permission extends Model
{
    // 定义权限表
    protected $table = 'permissions';
    // 禁用时间戳
    public $timestamps = false;
}

// 用户权限管理系统控制器
class PermissionController extends Controller
{
    public function __construct()
    {
        // 检查用户是否登录
        $this->middleware('auth');
    }

    // 获取所有权限
    public function index()
    {
        // 检查用户是否有权限查看权限列表
        if (!auth()->user()->can('view-permissions')) {
            abort(403);
        }

        // 获取所有权限
        $permissions = Permission::all();

        return response()->json(['permissions' => $permissions]);
    }

    // 存储新权限
    public function store(Request $request)
    {
        // 验证请求数据
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        // 检查是否有验证错误
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 检查用户是否有权限添加权限
        if (!auth()->user()->can('create-permissions')) {
            abort(403);
        }

        // 创建新权限
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->description = $request->description;
        $permission->save();

        return response()->json(['permission' => $permission]);
    }

    // 更新权限
    public function update(Request $request, $id)
    {
        // 验证请求数据
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        // 检查是否有验证错误
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 检查用户是否有权限更新权限
        if (!auth()->user()->can('update-permissions')) {
            abort(403);
        }

        // 检查权限是否存在
        $permission = Permission::find($id);
        if (!$permission) {
            return response()->json(['error' => 'Permission not found'], 404);
        }

        // 更新权限
        $permission->name = $request->name;
        $permission->description = $request->description;
        $permission->save();

        return response()->json(['permission' => $permission]);
    }

    // 删除权限
    public function destroy($id)
    {
        // 检查用户是否有权限删除权限
        if (!auth()->user()->can('delete-permissions')) {
            abort(403);
        }

        // 检查权限是否存在
        $permission = Permission::find($id);
        if (!$permission) {
            return response()->json(['error' => 'Permission not found'], 404);
        }

        // 删除权限
        $permission->delete();

        return response()->json(['message' => 'Permission deleted successfully']);
    }
}
