@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">商品詳細</div>

                <div class="card-body">
                    @if (session('err_msg'))
                        <div class="text-danger">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-striped">
                        <tr>
                            <th>id</th>
                            <th>商品画像</th>
                            <th>商品名</th>
                            <th>メーカー</th>
                            <th>価格</th>
                            <th>在庫数</th>
                            <th>コメント</th>
                        </tr>
                        <tr>
                            <td>{{ $product -> id }}</td>
                            <td><img src="{{asset(\Storage::url($product -> img_path))}}"alt="" class="products-image"></td>
                            <td style="white-space:nowrap;">{{ $product -> product_name }}</td>
                            <td>{{ $product -> companies->company_name }}</td>
                            <td>{{ $product -> price }}</td>
                            <td>{{ $product -> stock }}</td>
                            <td>{{ $product -> comment }}</td>
                        </tr>
                    </table>
                    <div class="product-edit">
                            <button class="btn btn-primary" onclick="location.href='/edit/{{ $product -> id }}'">編集</button>
                    </div>
                    <div class="product-sale">
                            <button class="btn btn-primary" onclick="location.href='/sale/{{ $product -> id }}'">出荷</button>
                    </div>
                    <div class="back-button">
                            <button class="btn btn-primary" onclick="location.href='{{ route('product') }}'">戻る</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
