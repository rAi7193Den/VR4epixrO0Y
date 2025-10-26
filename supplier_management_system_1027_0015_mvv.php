<?php
// 代码生成时间: 2025-10-27 00:15:28
// 使用命名空间来组织代码
namespace App\Http\Controllers;

use Illuminate\Http\Request;
# NOTE: 重要实现细节
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

// 控制器类
class SupplierController extends Controller
{
    // 显示供应商列表
    public function index()
    {
# 增强安全性
        // 获取所有供应商信息
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }

    // 显示创建供应商的表单
    public function create()
    {
        // 这里可以返回视图文件，展示创建表单
        return view('suppliers.create');
# 增强安全性
    }

    // 保存新供应商数据
    public function store(Request $request)
    {
        // 数据验证
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        // 验证失败则返回错误信息
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // 创建供应商实例
        $supplier = new Supplier;
# NOTE: 重要实现细节
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->save();

        // 返回成功响应
        return response()->json(['message' => 'Supplier created successfully.'], 201);
    }

    // 显示供应商信息
    public function show($id)
    {
        // 根据ID查找供应商
        $supplier = Supplier::find($id);

        // 如果供应商不存在则返回错误
# 扩展功能模块
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found.'], 404);
# 改进用户体验
        }

        // 返回供应商信息
        return response()->json($supplier);
    }

    // 显示编辑供应商的表单
# NOTE: 重要实现细节
    public function edit($id)
    {
        // 根据ID查找供应商
        $supplier = Supplier::find($id);

        // 如果供应商不存在则返回错误
# 添加错误处理
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found.'], 404);
        }

        // 返回视图文件，展示编辑表单
        return view('suppliers.edit', compact('supplier'));
    }

    // 更新供应商信息
# 改进用户体验
    public function update(Request $request, $id)
    {
# 优化算法效率
        // 根据ID查找供应商
        $supplier = Supplier::find($id);

        // 如果供应商不存在则返回错误
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found.'], 404);
        }
# 扩展功能模块

        // 数据验证
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        // 验证失败则返回错误信息
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
# TODO: 优化性能

        // 更新供应商信息
# 改进用户体验
        $supplier->name = $request->name;
# TODO: 优化性能
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->save();

        // 返回成功响应
        return response()->json(['message' => 'Supplier updated successfully.']);
    }
# 添加错误处理

    // 删除供应商
# 添加错误处理
    public function destroy($id)
    {
        // 根据ID查找供应商
        $supplier = Supplier::find($id);
# NOTE: 重要实现细节

        // 如果供应商不存在则返回错误
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found.'], 404);
        }

        // 删除供应商
        $supplier->delete();

        // 返回成功响应
        return response()->json(['message' => 'Supplier deleted successfully.']);
    }
}
