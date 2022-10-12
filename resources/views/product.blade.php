@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">商品一覧</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table border="1">
                        <tr>
                            <th>id</th>
                            <th>商品画像</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>在庫数</th>
                            <th>メーカー名</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td><img src="{{asset('image/' .$product->img_path)}}"alt="" class="products-image" height="80" width="80"></td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td></td>
                            <td><input type="button" value="詳細表示" onclick="product.detail()"></td>
                            <td><input type="button" value="削除" onclick="product.delete()"></td>
                        </tr>
                        @endforeach
                    </table>
                    <div class="product-register">
                        <button onclick="location.href='/product.register'">新規登録</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
