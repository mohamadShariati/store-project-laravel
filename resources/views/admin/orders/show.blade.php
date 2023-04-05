@extends('admin.layouts.admin')

@section('title')
     نمایش سفارش
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">سفارش : {{ $order->user->name }}</h5>
            </div>
            <hr>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>نام کاربر</label>
                            <input class="form-control" type="text" value="{{ $order->user->name == null ? 'کاربر ' : $order->user->name}}" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label>کد کوپن</label>
                            <input class="form-control" type="text" value="{{ $order->coupon == null ? 'استفاده نشده' : $order->coupon->name }}" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label>وضعیت</label>
                            <input class="form-control" type="text" value="{{ $order->payment_status }}" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label> مبلغ</label>
                            <input class="form-control" type="text" value="{{ number_format($order->total_amount) }}" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label> هزینه ارسال</label>
                            <input class="form-control" type="text" value="{{ number_format($order->delivery_amount) }}" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label> مبلغ کد تخفیف </label>
                            <input class="form-control" type="text" value="{{ number_format($order->coupon_amount == null ? '0' : $order->coupon_amount) }}" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label> مبلغ پرداختی  </label>
                            <input class="form-control" type="text" value="{{ number_format($order->paying_amount) }}" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label>نوع پرداخت</label>
                            <input class="form-control" type="text" value="{{ $order->payment_type }}" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label>وضعیت پرداخت</label>
                            <input class="form-control" type="text" value="{{ $order->payment_status }}" disabled>
                        </div>
                    </div>

            <hr>
                <div>
                    <table class="table table-bordered table-striped text-center">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>تصویر محصول</th>
                                <th>نام محصول</th>
                                <th>ویزگی</th>
                                <th>قیمت</th>
                                <th>تعداد</th>
                                <th>مجموع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items()->with('product')->with('variation')->get() as $key => $item)
                                <tr>
                                    <th>
                                        {{ $loop->iteration }}
                                    </th>
                                    <th>
                                        <a href="{{route('home.products.show',$item->product->slug)}}"><img width="120" src="{{asset('upload/files/products/images/'.$item->product->primary_image)}}" alt=""></a>
                                    </th>
                                    <th>
                                        {{ $item->product->name }}
                                    </th>
                                    <th>
                                        {{$item->variation->value}}
                                    </th>
                                    <th>
                                        {{number_format($item->price)}}
                                    </th>
                                    <th>
                                        {{$item->quantity}}
                                    </th>
                                    <th>
                                        {{number_format($item->subtotal)}}

                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



            <a href="{{ route('admin.orders.index') }}" class="btn btn-dark mt-5">بازگشت</a>

        </div>

    </div>

@endsection
