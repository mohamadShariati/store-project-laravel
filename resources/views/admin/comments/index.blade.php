@extends('admin.layouts.admin')

@section('title')
    comments index
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
        <div class="d-flex justify-content-between mb-4">
            <h5 class="font-weight-bold">لیست کامنت ها ({{ $comments->total() }})</h5>
        </div>

        <div>
            <table class="table table-bordered table-striped text-center">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام کاربر</th>
                        <th>محصول</th>
                        <th>متن کامنت</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comments as $key => $comment)
                        <tr>
                            <th>
                                {{ $comments->firstItem() + $key }}
                            </th>
                            <th>
                                {{ $comment->user->name ==null ? $comment->user->cellphone : $comment->user->name}}
                            </th>
                            <th>
                                <a href="{{route('admin.products.show',$comment->product->id)}}">
                                    {{ $comment->product->name }}
                                </a>
                            </th>
                            <th>
                                {{ Str::limit($comment->text, 10, '...') }}
                            </th>
                            <th>
                                <span
                                        class="{{ $comment->getRawOriginal('approved') ? 'text-success' : 'text-danger' }}">
                                        {{ $comment->approved }}
                                </span>
                            </th>
                            <th>
                                <a class="btn btn-sm btn-outline-success mb-2"
                                    href="{{ route('admin.comments.show', ['comment' => $comment->id]) }}">نمایش
                                </a>
                                    <form action="{{ route('admin.comments.destroy', ['comment' => $comment->id]) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"> حذف</button>
                                    </form>
                            </th>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $comments->render() }}
        </div>
    </div>
</div>
@endsection
