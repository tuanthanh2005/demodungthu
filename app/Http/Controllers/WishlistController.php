<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistIds = session()->get('wishlist', []);
        $products = Product::whereIn('id', $wishlistIds)->get();
        return view('shop.wishlist', compact('products'));
    }

    public function add(Request $request)
    {
        $id = $request->id;
        $wishlist = session()->get('wishlist', []);
        
        if(!in_array($id, $wishlist)) {
            $wishlist[] = $id;
            session()->put('wishlist', $wishlist);
            
            if($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => 'Đã thêm vào yêu thích!', 'count' => count($wishlist)]);
            }
            return redirect()->back()->with('success', 'Đã thêm vào danh sách yêu thích');
        } else {
             if($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json(['info' => 'Sản phẩm đã có trong yêu thích', 'count' => count($wishlist)]);
            }
        }
        
        return redirect()->back();
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $wishlist = session()->get('wishlist', []);
        
        if(($key = array_search($id, $wishlist)) !== false) {
            unset($wishlist[$key]);
            session()->put('wishlist', $wishlist);
        }
        
        if($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => 'Đã xóa khỏi yêu thích', 'count' => count($wishlist)]);
        }
        
        return redirect()->back()->with('success', 'Đã xóa khỏi danh sách yêu thích');
    }
}
