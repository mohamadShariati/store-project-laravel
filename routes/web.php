<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Home\CompareController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Home\WishlistController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Home\UserProfileController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\CommentController as HomeCommentController;
use App\Http\Controllers\Home\ProductController as HomeProductController;
use App\Http\Controllers\Home\CategoryController as HomeCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin-panel/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::prefix('admin-panel/management')->name('admin.')->group(function(){

    Route::resource('brands', BrandController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('products', ProductController::class);
    Route::resource('banners',BannerController::class);
    Route::resource('comments',CommentController::class);
    Route::resource('coupons',CouponController::class);

    //approve comment
    Route::get('/comments/{comment}/change-approve',[CommentController::class,'changeApproved'])->name('comments.change-approve');
    // Get Category Attributes
    Route::get('/category-attributes/{category}' ,[CategoryController::class , 'getCategoryAttributes']);

    // Edit Product Image
    Route::get('/products/{product}/images-edit' ,[ProductImageController::class , 'edit'])->name('products.images.edit');
    Route::delete('/products/{product}/images-destroy' ,[ProductImageController::class , 'destroy'])->name('products.images.destroy');
    Route::put('/products/{product}/images-set-primary' ,[ProductImageController::class , 'setPrimary'])->name('products.images.set_primary');
    Route::post('/products/{product}/images-add' ,[ProductImageController::class , 'add'])->name('products.images.add');

    //Edit Product Category
    Route::get('/products/{product}/category-edit',[ProductController::class,'editCategory'])->name('products.category.edit');
    Route::put('/products/{product}/category-update',[ProductController::class,'updateCategory'])->name('products.category.update');

});

Route::prefix('profile')->name('home.')->group(function(){
    Route::get('/',[UserProfileController::class,'index'])->name('users_profile.index');
    Route::get('/comments',[HomeCommentController::class,'usersProfileIndex'])->name('comments.users_profile.index');
    Route::get('/wishlist',[WishlistController::class,'userProfileIndex'])->name('wishlist.user_profile.index');
    // Route::get('/compare',[CompareController::class,'userProfileIndex'])->name('compare.user_profile.index');
});

Route::get('/',[HomeController::class,'index'])->name('home.index');
Route::get('/categories/{category:slug}',[HomeCategoryController::class,'show'])->name('home.categories.show');
Route::post('/comments/{product}',[HomeCommentController::class , 'store'])->name('home.comments.store');

//wishlist
Route::get('/add-to-wishlist/{product}',[WishlistController::class,'add'])->name('home.wishlist.add');
Route::get('/remove-from-wishlist/{product}',[WishlistController::class,'remove'])->name('home.wishlist.remove');

//compare
Route::get('/compare',[CompareController::class,'index'])->name('home.compare.index');
Route::get('/add-to-compare/{product}',[CompareController::class,'add'])->name('home.compare.add');
Route::get('/remove-from-compare/{product}',[CompareController::class,'remove'])->name('home.compare.remove');

//CART
Route::get('/cart',[CartController::class,'index'])->name('home.cart.index');
Route::post('/add-to-cart',[CartController::class,'add'])->name('home.cart.add');
Route::get('/remove-from-cart/{id}',[CartController::class,'remove'])->name('home.cart.remove');
Route::get('/clear-cart',[CartController::class,'clear'])->name('home.cart.clear');
Route::put('/update-cart',[CartController::class,'update'])->name('home.cart.update');
Route::post('/check-coupon',[CartController::class,'checkCoupon'])->name('home.coupons.check');

Route::get('/products/{product:slug}',[HomeProductController::class,'show'])->name('home.products.show');

Route::get('/test',function(){
    auth()->logout();
    return redirect()->route('home.index');
});

Route::get('session',function(){
//    dd(session()->get('compareProduct'));
   session()->forget('coupon');
});

// Route::get('/cart',function(){
//     // \Cart::clear();
//     dd(\Cart::getContent());
// });

Route::get('/login/{provider}',[AuthController::class,'redirectToProvider'])->name('provider.login');
Route::get('/login/{provider}/callback',[AuthController::class,'handleProviderCallback']);
