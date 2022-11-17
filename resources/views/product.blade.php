@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div>
                    <form action="{{ route('product') }}" method="GET" style="text-align:center">
                        <input type="text" name="keyword_product" value="@if (isset($keyword_product)) {{ $keyword_product }} @endif">
                        <select name="company">
                        <option value="">全て</option>
                            @foreach ($company_list as $company_item)
                                <option value="{{ $company_item->company_name }}" @if($company == '{{ $company_item->company_name }}') selected @endif>{{ $company_item->company_name }}</option>
                            @endforeach
                        </select>
                        @csrf
                        <button type="submit" class="btn btn-primary" onclick=>検索</button>
                    </form>
                </div>
                <div class="card-header">商品一覧</div>

                <div class="card-body">
                    @if (session('err_msg'))
                    <p class="text-danger">
                        {{ session('err_msg') }}
                    </p>
                    @endif

                    @if($products->count())
                    <table class="table table-striped">
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
                            <td>{{ $product->product_id }}</td>
                            <td><img src="{{asset(\Storage::url($product->img_path))}}"alt="" class="products-image" height="80" width="80"></td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->company_name }}</td>
                            <td>                        
                                <button class="btn btn-primary" onclick="location.href='/product/{{ $product->product_id }}'">詳細</button>
                            </td>
                            <td>                        
                                <form action="{{ route('delete', $product->product_id) }}" method="POST" onSubmit="return checkDelete()" enctype="multipart/form-data">
                                @csrf
                                <button type="submit" class="btn btn-primary" onclick=>削除</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    @else
                    <p>見つかりませんでした。</p>
                    @endif

                    <div class="product-register">
                        <button class="btn btn-primary" onclick="location.href='{{ route('create') }}'">新規登録</button>
                    </div>
                </div>
            </div>
            <script>
                function checkDelete(){
                    if(window.confirm('削除してよろしいですか？')){
                        return true;
                    } else {
                        return false;
                    }
                }
            </script>
        </div>
    </div>
</div>
@endsection
