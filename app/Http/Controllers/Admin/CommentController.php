<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments=Comment::latest()->paginate(10);
        return view('admin.comments.index',compact('comments'));
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return view('admin.comments.show' , compact('comment'));
    }


    public function changeApproved(Comment $comment)
    {
        $comment->approved = $comment->getRawOriginal('approved') ? 0 : 1;
        $result = $comment ->save();

        if($result)
        {
            alert()->success('وضعیت کامنت با موفقیت عوض شد', 'با تشکر');
            return redirect()->route('admin.comments.index');
        }else
        {
            alert()->danger('تغییر وضعیت کامنت با مشکل مواجه شد', 'با تشکر');
            return redirect()->route('admin.comments.index');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        alert()->success('کامنت با موفقیت حذف شد', 'با تشکر');
        return redirect()->back();
    }



}
