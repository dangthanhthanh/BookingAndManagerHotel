<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends ClientController
{
    public function __construct() {
        
    }
    public function index(Request $request){
        if(!empty($request->keyword)){
            $blogs=Blog::orderBy('id','desc')->where('title','like',"%$request->keyword%")->where('active',1)->paginate(3);
        }elseif($request->category){
            $blogs=Blog::orderBy('id','desc')->where('category_id',$request->category)->where('active',1)->paginate(3);
        }else{
            $blogs=Blog::orderBy('id','desc')->where('active',1)->paginate(3);
        }
        $blogCategory=BlogCategory::select('id','name')->get();
        return view("client.page.blog",compact('blogs','blogCategory'));
    }
    public function show(string $id){
        $data=Blog::select('description','title')->find($id);
        $description=$data->description;
        $title=$data->title;
        return view("client.page.detail",compact('description','title'));
    }
}
