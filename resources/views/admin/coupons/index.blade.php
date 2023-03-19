@extends('admin.layouts.admin')

@section('title')
    کوپن های تخفیف
@endsection

@section('content')
<div class="row">

    <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
        <div class="d-flex justify-content-between mb-4">
            <h5 class="font-weight-bold">لیست کوپن ها   ({{ $coupons->total() }})</h5>
            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.coupons.create') }}">
                <i class="fa fa-plus"></i>
                ایجاد کوپن
            </a>
        </div>

        <div>
            <table class="table table-bordered table-striped text-center">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>کد تخفیف</th>
                        <th>تایپ</th>
                        <th>مقدار تخفیف</th>
                        <th>درصد تخفیف</th>
                        <th>بیشترین مبلغ درصد تخفیف</th>
                        <th>تاریخ اتمام</th>
                        <th>توضیحات</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $key => $coupon)
                        <tr>
                            <th>
                                {{ $coupons->firstItem() + $key }}
                            </th>
                            <th>
                                {{ $coupon->name }}
                            </th>
                            <th>
                                {{ $coupon->code }}
                            </th>
                            <th>
                                {{ $coupon->type }}
                            </th>
                            <th>
                                {{ $coupon->amount }}
                            </th>
                            <th>
                                {{ $coupon->percentage }} {{ $coupon->percentage ? '%' : ''}}
                            </th>
                            <th>
                                {{ $coupon->max_percentage_amount }}
                            </th>
                            <th>
                                {{ verta($coupon->expired_at)  }}
                            </th>
                            <th>
                                {{ $coupon->description }}
                            </th>
                            <th>
                                <form action="{{route('admin.coupons.destroy',$coupon->id)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">حذف</button>
                                </form>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $coupons->render() }}
        </div>
    </div>

</div>
@endsection

