@extends('admin.layouts.admin')

@section('title')
    create banner
@endsection

@section('script')
    <script>

        // Show File Name
        $('#image').change(function() {
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });

    </script>
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ایجاد محصول</h5>
            </div>
            <hr>

            @include('admin.sections.errors')

            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="title">عنوان</label>
                        <input class="form-control" id="name" name="name" type="text"
                            value="{{ old('name') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="title">اولویت</label>
                        <input class="form-control" id="priority" name="priority" type="text"
                            value="{{ old('priority') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="title">نوع بنر</label>
                        <input class="form-control" id="type" name="type" type="text"
                            value="{{ old('type') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="title">متن دکمه </label>
                        <input class="form-control" id="button_text" name="button_text" type="text"
                            value="{{ old('button_text') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="title">لینک دکمه </label>
                        <input class="form-control" id="button_link" name="button_link" type="text"
                            value="{{ old('button_link') }}">
                    </div><div class="form-group col-md-3">
                        <label for="title">آیکون دکمه </label>
                        <input class="form-control" id="button_icon" name="button_icon" type="text"
                            value="{{ old('button_icon') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" selected>فعال</option>
                            <option value="0">غیرفعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="text">توضیحات</label>
                        <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                    </div>

                    {{-- Product Image Section --}}
                    <div class="col-md-12">
                        <hr>
                        <p>تصاویر محصول : </p>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="image"> انتخاب تصویر </label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="image">
                            <label class="custom-file-label" for="image"> انتخاب فایل </label>
                        </div>
                    </div>

                </div>

        </div>

        <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </form>
    </div>

    </div>
@endsection
