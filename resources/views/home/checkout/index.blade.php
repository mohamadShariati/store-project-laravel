@extends('home.layouts.home')

@section('title')
    checkout page
@endsection

@section('script')
    <script>

        $('#address-input').val($('#address-select').val());

        $('#address-select').change(function(){
            $('#address-input').val($(this).val());
        });

        $('.province-select').change(function() {

            var provinceID = $(this).val();

            if (provinceID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-province-cities-list') }}?province_id=" + provinceID,
                    success: function(res) {
                        if (res) {
                            $(".city-select").empty();

                            $.each(res, function(key , city) {
                                $(".city-select").append('<option value="' + city.id + '">' +
                                    city.name + '</option>');
                            });

                        } else {
                            $(".city-select").empty();
                        }
                    }
                });
            } else {
                $(".city-select").empty();
            }
        });
    </script>
@endsection

@section('content')
<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="{{route('home.index')}}">صفحه ای اصلی</a>
                </li>
                <li class="active"> سفارش </li>
            </ul>
        </div>
    </div>
</div>


<!-- compare main wrapper start -->

<div class="checkout-main-area pt-70 pb-70 text-right" style="direction: rtl;">

    <div class="container">
        @if (!session()->has('coupon'))

        <div class="customer-zone mb-20">
            <p class="cart-page-title">
                کد تخفیف دارید؟
                <a class="checkout-click3" href="#"> میتوانید با کلیک در این قسمت کد خود را اعمال کنید </a>
            </p>
            <div class="checkout-login-info3">
                <form action="{{route('home.coupons.check')}}" method="POST">
                    @csrf
                    <input type="text" name="code" placeholder="کد تخفیف">
                    {{-- <input type="submit" value="اعمال کد تخفیف"> --}}
                    <button class="btn btn-danger" type="submit">اعمال کد تخفیف</button>
                </form>
            </div>
        </div>
        @endif

        <div class="checkout-wrap pt-30">
            <div class="row">

                <div class="col-lg-7">
                    <div class="billing-info-wrap mr-50">
                        <h3> آدرس تحویل سفارش </h3>

                        <div class="row">
                            <p class="col-lg-12 col-md-12">
                               {{auth()->user()->address->first()->address}}
                            </p>
                            <div class="col-lg-6 col-md-6 mb-4">
                                <div class="billing-info tax-select mb-20">
                                    <label> انتخاب آدرس تحویل سفارش <abbr class="required"
                                            title="required">*</abbr></label>

                                    <select class="email s-email s-wid" id="address-select">
                                        @foreach ($addresses as $address)
                                        <option value="{{$address->id}}"> {{$address->title}} </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 pt-30">
                                <button class="collapse-address-create" type="submit"> ایجاد آدرس جدید </button>
                            </div>

                            <div class="col-lg-12">
                                <div class="collapse-address-create-content">

                                    <form action="{{route('home.address.store')}}" method="POST">
                                        @csrf
                                        <div class="row">

                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    عنوان
                                                </label>
                                                <input type="text" name="title">
                                                @error('title')
                                                <p class="input-error-validation">
                                                    <strong>{{ $message }}</strong>
                                                </p>
                                                @enderror
                                            </div>
                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    شماره تماس
                                                </label>
                                                <input name="cellphone" type="text">
                                                @error('cellphone')
                                                <p class="input-error-validation">
                                                    <strong>{{ $message }}</strong>
                                                </p>
                                            @enderror
                                            </div>
                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    استان
                                                </label>
                                                <select name="province_id" class="email s-email s-wid province-select">
                                                    <option value="">استان را انتخاب کنید</option>
                                                    @foreach ($provinces as $province)
                                                    <option value="{{$province->id}}">{{$province->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('province_id')
                                                 <p class="input-error-validation">
                                                    <strong>{{$message}}</strong>
                                                 </p>
                                                @enderror
                                            </div>
                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    شهر
                                                </label>
                                                <select class="email s-email s-wid city-select" name="city_id">
                                                </select>
                                                @error('city_id')
                                                    <p class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                @enderror
                                            </div>


                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    آدرس
                                                </label>
                                                <input name="address" type="text">
                                                 @error('address')
                                                    <p class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    کد پستی
                                                </label>
                                                <input name="postal_code" type="text">
                                                @error('postal_code')
                                                <p class="input-error-validation">
                                                    <strong>{{ $message }}</strong>
                                                </p>
                                                @enderror
                                            </div>

                                            <div class=" col-lg-12 col-md-12">

                                                <button class="cart-btn-2" type="submit"> ثبت آدرس جدید
                                                </button>
                                            </div>

                                        </div>

                                    </form>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="your-order-area">
                            <form action="{{route('home.payment')}}" method="POST">
                                @csrf

                            <h3> سفارش شما </h3>
                            <div class="your-order-wrap gray-bg-4">
                                <div class="your-order-info-wrap">
                                    <div class="your-order-info">
                                        <ul>
                                            <li> محصول <span> جمع </span></li>
                                        </ul>
                                    </div>
                                    <div class="your-order-middle">
                                        <ul>
                                            @foreach (\Cart::getContent() as $item)
                                                <li class="d-flex justify-content-between">
                                                    <div>
                                                        {{ $item->name }}
                                                        -
                                                        {{ $item->quantity }}
                                                        <p class="mb-0" style="font-size: 12px; color:red">
                                                            {{ \App\Models\Attribute::find($item->attributes->attribute_id)->name }}
                                                            :
                                                            {{ $item->attributes->value }}
                                                        </p>
                                                    </div>
                                                    <span>
                                                        {{ number_format($item->price) }}
                                                        تومان
                                                        @if ($item->attributes->is_sale)
                                                            <p style="font-size: 12px ; color:red">
                                                                {{ $item->attributes->percent_sale }}%
                                                                تخفیف
                                                            </p>
                                                        @endif
                                                    </span>

                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="your-order-info order-subtotal">
                                        <ul>
                                            <li> مبلغ
                                                <span>
                                                    {{ number_format(\Cart::getTotal() + cartTotalSaleAmount()) }}
                                                    تومان
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    @if (cartTotalSaleAmount() > 0)
                                        <div class="your-order-info order-subtotal">
                                            <ul>
                                                <li>
                                                    مبلغ تخفیف کالا ها :
                                                    <span style="color: red">
                                                        {{ number_format(cartTotalSaleAmount()) }}
                                                        تومان
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                    @if (session()->has('coupon'))
                                        <div class="your-order-info order-subtotal">
                                            <ul>
                                                <li>
                                                    مبلغ کد تخفیف :
                                                    <span style="color: red">
                                                        {{ number_format(session()->get('coupon.amount')) }}
                                                        تومان
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="your-order-info order-shipping">
                                        <ul>
                                            <li> هزینه ارسال
                                                @if (cartTotalDeliveryAmount() == 0)
                                                    <span style="color: red">
                                                        رایگان
                                                    </span>
                                                @else
                                                    <span>
                                                        {{ number_format(cartTotalDeliveryAmount()) }}
                                                        تومان
                                                    </span>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="your-order-info order-total">
                                        <ul>
                                            <li>جمع کل
                                                <span>
                                                    {{ number_format(cartTotalAmount()) }}
                                                    تومان </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="payment-method">
                                    <div class="pay-top sin-payment">
                                        <input id="zarinpal" class="input-radio" type="radio" value="zarinpal"
                                            checked="checked" name="payment_method">
                                        <label for="zarinpal"> درگاه پرداخت زرین پال </label>
                                        <div class="payment-box payment_method_bacs">
                                            <p>
                                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                                                طراحان گرافیک است.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="pay-top sin-payment">
                                        <input id="pay" class="input-radio" type="radio" value="pay" name="payment_method">
                                        <label for="pay">درگاه پرداخت پی</label>
                                        <div class="payment-box payment_method_bacs">
                                            <p>
                                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                                                طراحان گرافیک است.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="Place-order mt-40">
                                <button type="submit">ثبت سفارش</button>
                            </div>
                            <input type="hidden" name="address_id" id="address-input">
                        </form>
                        </div>
                    </div>


            </div>
        </div>

    </div>

</div>

<!-- compare main wrapper end -->
@endsection
