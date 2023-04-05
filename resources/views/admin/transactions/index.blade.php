@extends('admin.layouts.admin')

@section('title')
     صفحه تراکنش ها
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست تراکنش ها  ({{ $transactions->total() }})</h5>

            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>سفارش دهنده</th>
                            <th>شماره سفارش </th>
                            <th>ref_id</th>
                            <th>مبلغ تراکنش </th>
                            <th>درگاه پرداخت</th>
                            <th>وضعیت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $key => $transaction)

                            <tr>
                                <th>
                                    {{ $transactions->firstItem() + $key }}
                                </th>
                                <th>
                                    {{ $transaction->user == null ? 'کاربر' :  $transaction->user->name}}
                                </th>
                                <th>
                                    {{ $transaction->order_id }}
                                </th>
                                <th>
                                    {{ $transaction->ref_id == null ? 'بدون شماره' : $transaction->ref_id }}
                                </th>
                                <th>
                                    {{ $transaction->order == null ? 'بدون مبلغ' : number_format($transaction->order->paying_amount) }}
                                </th>
                                <th>
                                    {{ $transaction->gateway_name == null ? 'بدون درگاه' : $transaction->gateway_name }}
                                </th>
                                <th>
                                    <span
                                        class="{{ $transaction->getRawOriginal('status') ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->status }}
                                    </span>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $transactions->render() }}
            </div>
        </div>
    </div>
@endsection
