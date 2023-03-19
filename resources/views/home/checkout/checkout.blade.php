@extends('home.layouts.home')

@section('title')
    checkout page
@endsection

@section('content')
<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="index.html">صفحه ای اصلی</a>
                </li>
                <li class="active"> سفارش </li>
            </ul>
        </div>
    </div>
</div>


<!-- compare main wrapper start -->
<div class="checkout-main-area pt-70 pb-70 text-right" style="direction: rtl;">

    <div class="container">

        <div class="customer-zone mb-20">
            <p class="cart-page-title">
                کد تخفیف دارید؟
                <a class="checkout-click3" href="#"> میتوانید با کلیک در این قسمت کد خود را اعمال کنید </a>
            </p>
            <div class="checkout-login-info3">
                <form action="#">
                    <input type="text" placeholder="کد تخفیف">
                    <input type="submit" value="اعمال کد تخفیف">
                </form>
            </div>
        </div>

        <div class="checkout-wrap pt-30">
            <div class="row">

                <div class="col-lg-7">
                    <div class="billing-info-wrap mr-50">
                        <h3> آدرس تحویل سفارش </h3>

                        <div class="row">
                            <p>
                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
                            </p>
                            <div class="col-lg-6 col-md-6">
                                <div class="billing-info tax-select mb-20">
                                    <label> انتخاب آدرس تحویل سفارش <abbr class="required"
                                            title="required">*</abbr></label>

                                    <select class="email s-email s-wid">
                                        <option> منزل </option>
                                        <option> محل کار </option>
                                        <option> شرکت </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 pt-30">
                                <button class="collapse-address-create" type="submit"> ایجاد آدرس جدید </button>
                            </div>

                            <div class="col-lg-12">
                                <div class="collapse-address-create-content">

                                    <form action="#">

                                        <div class="row">

                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    عنوان
                                                </label>
                                                <input type="text" required="" name="title">
                                            </div>
                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    شماره تماس
                                                </label>
                                                <input type="text">
                                            </div>
                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    استان
                                                </label>
                                                <select class="email s-email s-wid">
                                                    <option>Bangladesh</option>
                                                    <option>Albania</option>
                                                    <option>Åland Islands</option>
                                                    <option>Afghanistan</option>
                                                    <option>Belgium</option>
                                                </select>
                                            </div>
                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    شهر
                                                </label>
                                                <select class="email s-email s-wid">
                                                    <option>Bangladesh</option>
                                                    <option>Albania</option>
                                                    <option>Åland Islands</option>
                                                    <option>Afghanistan</option>
                                                    <option>Belgium</option>
                                                </select>
                                            </div>
                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    آدرس
                                                </label>
                                                <input type="text">
                                            </div>
                                            <div class="tax-select col-lg-6 col-md-6">
                                                <label>
                                                    کد پستی
                                                </label>
                                                <input type="text">
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
                                        <li>
                                            لورم ایپسوم
                                            -
                                            1
                                            <span>
                                                50000
                                                تومان
                                            </span>
                                        </li>
                                        <li>
                                            لورم ایپسوم
                                            -
                                            2
                                            <span>
                                                40000
                                                تومان
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="your-order-info order-subtotal">
                                    <ul>
                                        <li> مبلغ
                                            <span>
                                                90000
                                                تومان
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="your-order-info order-shipping">
                                    <ul>
                                        <li> هزینه ارسال
                                            <span>
                                                8000
                                                تومان
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="your-order-info order-total">
                                    <ul>
                                        <li>جمع کل
                                            <span>
                                                980000
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
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                                        </p>
                                    </div>
                                </div>
                                <div class="pay-top sin-payment">
                                    <input id="pay" class="input-radio" type="radio" value="pay"
                                        name="payment_method">
                                    <label for="pay">درگاه پرداخت پی</label>
                                    <div class="payment-box payment_method_bacs">
                                        <p>
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="Place-order mt-40">
                            <button type="submit">ثبت سفارش</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<!-- compare main wrapper end -->
@endsection
