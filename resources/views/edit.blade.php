@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">商品編集</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('update') }}" method="POST" onSubmit="return checkSubmit()" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <input type="hidden" name="id" class="form-control" value="{{ $product -> id }}">
                            @if($errors->has('id'))
                                <div class="text-danger">
                                    {{ $errors->first('id') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="product_name">商品名</label>
                            <input type="text" name="product_name" class="form-control" value="{{ $product->product_name }}">
                            @if($errors->has('product_name'))
                                <div class="text-danger">
                                    {{ $errors->first('product_name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                        <label for="company_id">メーカー</label>
                            <select class="form-control" id="company_id" name="company_id">
                            @foreach ($companies as $company)
                            @if ($product->id === $company->id )
                                <option value="{{ $company->id }}" selected="selected">{{ $company->company_name }}</option>
                            @else
                                <option value ="{{$company->id}}">{{ $company->company_name }}</option>
                            @endif
                            @endforeach
                            </select>
                            @if($errors->has('company_id'))
                                <div class="text-danger">
                                    {{ $errors->first('company_id') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="price">価格</label>
                            <input type="text" name="price" class="form-control" value="{{ $product->price }}">
                            @if($errors->has('price'))
                                <div class="text-danger">
                                    {{ $errors->first('price') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="stock">在庫数</label>
                            <input type="text" name="stock" class="form-control" value="{{ $product->stock }}">
                            @if($errors->has('stock'))
                                <div class="text-danger">
                                    {{ $errors->first('stock') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="comment">コメント</label>
                            <textarea type="text" name="comment" class="form-control">{{ $product->comment }}</textarea>
                            @if($errors->has('comment'))
                                <div class="text-danger">
                                    {{ $errors->first('comment') }}
                                </div>
                            @endif
                        </div>
                        <div>
                            @if ($product->img !=='')
                            <img src="{{ \Storage::url($product->img_path) }}" height="80" width="80">
                            @else
                            <img src="{{ \Storage::url('products/no_img.png') }}">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="img_path">商品画像</label>
                            <input type="file" name="img_path" class="form-control">
                            @if($errors->has('img'))
                                <div class="text-danger">
                                    {{ $errors->first('img') }}
                                </div>
                            @endif
                        </div>
                        <div class="product-register">
                            <button class="btn btn-primary" type="submit" class="register-button">更新</button>
                        </div>
                        <div class="back-button">
                            <button class="btn btn-primary" onclick="location.href='{{ $product->id }}'">戻る</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                function checkSubmit(){
                    if(window.confirm('更新してよろしいですか？')){
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
