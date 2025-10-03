<?php
// 代码生成时间: 2025-10-04 02:50:31
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;

// 购物车模型
class ShoppingCart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // 关联用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 关联产品
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

// 购物车服务类
class ShoppingCartService
{
    public function addToCart($userId, $productId, $quantity)
    {
        try {
            // 检查产品是否存在
            $product = Product::find($productId);
            if (!$product) {
                throw new \Exception('Product not found');
            }

            // 检查购物车中是否已有该产品
            $cartItem = ShoppingCart::where('user_id', $userId)
                                    ->where('product_id', $productId)
                                    ->first();

            if ($cartItem) {
                // 更新现有产品数量
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                // 添加新产品到购物车
                $cartItem = new ShoppingCart([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity
                ]);
                $cartItem->save();
            }

            return ['status' => 'success', 'message' => 'Product added to cart', 'cart_item' => $cartItem];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function removeFromCart($userId, $productId)
    {
        try {
            $cartItem = ShoppingCart::where('user_id', $userId)
                                    ->where('product_id', $productId)
                                    ->first();

            if (!$cartItem) {
                throw new \Exception('Product not found in cart');
            }

            $cartItem->delete();
            return ['status' => 'success', 'message' => 'Product removed from cart'];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateQuantity($userId, $productId, $quantity)
    {
        try {
            $cartItem = ShoppingCart::where('user_id', $userId)
                                    ->where('product_id', $productId)
                                    ->first();

            if (!$cartItem) {
                throw new \Exception('Product not found in cart');
            }

            if ($quantity <= 0) {
                throw new \Exception('Invalid quantity');
            }

            $cartItem->quantity = $quantity;
            $cartItem->save();
            return ['status' => 'success', 'message' => 'Quantity updated', 'cart_item' => $cartItem];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getCart($userId)
    {
        $cartItems = ShoppingCart::where('user_id', $userId)
                                ->with('product')
                                ->get();

        $totalPrice = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return ['status' => 'success', 'cart_items' => $cartItems, 'total_price' => $totalPrice];
    }
}

// User模型
class User extends Model
{
    use HasFactory;

    // 购物车关系
    public function shoppingCart()
    {
        return $this->hasMany(ShoppingCart::class);
    }
}

// Product模型
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price'];

    // 购物车关系
    public function shoppingCart()
    {
        return $this->hasMany(ShoppingCart::class);
    }
}


/*
 * 购物车功能实现
 *
 * PHP version 8.0
 *
 * @category Cart
 * @package  Cart
 * @author   Your Name <youremail@example.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.example.com
 */
