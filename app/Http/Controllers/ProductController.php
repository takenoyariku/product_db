<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Company;
use App\Sale;
use App\Http\Requests\ProductRequest;

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

        $query = Company::query();

        $query->join('products', function ($query) use ($request) {
            $query -> on('companies.id', '=', 'products.company_id');
        }) -> select('products.id as product_id','companies.id as company_id','price', 'stock', 'product_name', 'img_path', 'company_name');

        $products = $query -> paginate(5);

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
        $query = Company::query();

        // 全角スペースを半角に変換
        $spaceConversion = mb_convert_kana($company, 's');
        // 単語を半角スペースで区切り、配列にする
        $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
        //テーブルの結合
        $query->join('products', function ($query) use ($request) {
            $query -> on('companies.id', '=', 'products.company_id');
        }) -> select('products.id as product_id','companies.id as company_id','price', 'stock', 'product_name', 'img_path', 'company_name');
        // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
        if (!empty($company)) {
            foreach($wordArraySearched as $value) {
                $query -> where('company_name',  $company);
            }
        }
        if (!empty($keyword_product)) {
                $query->where('product_name', 'like', "%{$keyword_product}%");
        }

        $products = $query -> paginate(5);

        $company_list = Company::all();
        
        
        return response()->json(compact('products', 'company', 'keyword_product', 'company_list'));
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
        // $request->company_id;
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
           $inputs['img_path'] = request('img_path') -> storeAs('public/images', $filename);
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
    public function exeDelete($id) {
        
        if(empty($id)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('product'));
        }
        try {
            // 商品を削除
            Product::destroy($id);
        } catch(\Throwable $e) {
            abort(500);
        };
 
        \Session::flash('err_msg', '削除しました。');
        return redirect(route('product'));
    }
}
