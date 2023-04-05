@extends('admin.layouts.admin')

@section('title')
    index brands
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست سفارشات  ({{ $orders->total() }})</h5>

            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>سفارش دهنده</th>
                            <th>نوع پرداخت</th>
                            <th>مبلغ سفارش</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                        
                            <tr>
                                <th>
                                    {{ $orders->firstItem() + $key }}
                                </th>
                                <th>
                                    {{ $order->user->name == null ? 'کاربر' :  $order->user->name}}
                                </th>
                                <th>
                                    {{ $order->payment_type }}
                                </th>
                                <th>
                                    {{ number_format($order->paying_amount) }}
                                </th>
                                <th>
                                    <span
                                        class="{{ $order->getRawOriginal('payment_status') ? 'text-success' : 'text-danger' }}">
                                        {{ $order->payment_status }}
                                    </span>
                                </th>
                                <th>
                                    <a class="btn btn-sm btn-outline-success"
                                        href="{{ route('admin.orders.show', ['order' => $order->id]) }}">نمایش</a>

                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $orders->render() }}
            </div>
        </div>
    </div>
@endsection
