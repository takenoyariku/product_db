<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Company;
use App\Sale;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\API\SaleController;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this -> middleware('auth');
        $this -> company = new Company();
    }

    /**
     * 商品一覧を表示する
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showList(Request $request) {

        $query = Product::query();

        $query->join('companies', function ($query) use ($request) {
            $query -> on('products.company_id', '=', 'companies.id');
        }) -> select('products.id as product_id','companies.id as company_id','price', 'stock', 'product_name', 'img_path', 'company_name');

        $products = $query -> sortable() -> paginate(5);

        $company_list = Company::all();
        
        
        return view('product', compact('products', 'company_list'));
    }
    /**
     * 商品を検索する
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function exeList(Request $request) {
        //検索機能
        $company = $request -> input('company');
        $keyword_product = $request -> input('keyword_product');
        $min_price = $request -> input('min_price');
        $max_price = $request -> input('max_price');
        $query = Company::query();

        //テーブルの結合
        $query->join('products', function ($query) use ($request) {
            $query -> on('companies.id', '=', 'products.company_id');
        }) -> select('products.id as product_id','companies.id as company_id','price', 'stock', 'product_name', 'img_path', 'company_name');
        // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
        if (!empty($company)) {
                $query -> where('company_name',  $company);
        }
        if (!empty($keyword_product)) {
                $query -> where('product_name', 'like', "%{$keyword_product}%");
        }
        if (!empty($min_price)) {
            $query -> where('price', '>=', $min_price);
        }
        if (!empty($max_price)) {
            $query -> where('price', '<=', $max_price);
        }

        $products = $query -> paginate(5);
        
        return response()->json(compact('products'));
    }
    /**
     * 商品詳細を表示する
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable 
     */
    public function showDetail($id) {
        $product = Product::with('companies') -> find($id);

        $company = Company::find($id);



        if(is_null($product)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('product'));
        }

        return view('detail', compact('product', 'company'));
    }

      /**
     * 商品登録画面を表示する
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function showCreate(Request $request) {
        $companies = Company::all();
        return view('form', compact('companies'));
    }

      /**
     * 商品を登録する
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function exeStore(Request $request) {
        $request->company_id;
        // 商品のデータを受け取る
        $inputs = $request -> all();
        // 画像ファイルの保存場所指定
        if(request('img_path')) {
            $filename = request() -> file('img_path') -> getClientOriginalName();
            $inputs['img_path'] = request('img_path') -> storeAs('public/images', $filename);
        }

        \DB::beginTransaction();
        try {
            // 商品を登録
            Product::create($inputs);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        };
        // ログの処理が必要

        \Session::flash('err_msg', '商品を登録しました。');
        return redirect(route('product'));
    }

    /**
    * 商品編集フォームを表示する
    * @param int $id
    * @return \Illuminate\Contracts\Support\Renderable
    */
   public function showEdit($id) {
       $product = Product::find($id);

       $companies = Company::all();


       if(is_null($product)) {
           \Session::flash('err_msg', 'データがありません。');
           return redirect(route('product'));
       }

       return view('edit', compact('product', 'companies'));
   }

     /**
     * 商品を更新する
     * @return \Illuminate\Contracts\Support\Renderable
     */

   public function exeUpdate(Request $request) {
       // 商品のデータを受け取る
       $inputs = $request -> all();
       // 画像ファイルの保存場所指定
       if(request('img_path')) {
           $filename = request() -> file('img_path') -> getClientOriginalName();
           $inputs['img_path'] = request('img_path') -> storeAs('storage/images/', $filename);
       }

       \DB::beginTransaction();
       try {
           // 商品を更新
           $product = Product::find($inputs['id']);
           $product -> fill([
            'product_name' => $inputs['product_name'],
            'company_id' => $inputs['company_id'],
            'price' => $inputs['price'],
            'stock' => $inputs['stock'],
            'comment' => $inputs['comment'],
            'img_path' => $inputs['img_path'],
           ]);
           $product -> save();
           \DB::commit();
       } catch(\Throwable $e) {
           \DB::rollback();
           abort(500);
       };
       // ログの処理が必要

       \Session::flash('err_msg', '商品を更新しました。');
       return redirect(route('product'));
   }

    /**
    * 商品削除
    * @param int $id
    * @return view
    */
    public function exeDelete(Request $request, Product $product) {
        $product = Product::findOrFail($request->id);
        $product->delete();
    }

}