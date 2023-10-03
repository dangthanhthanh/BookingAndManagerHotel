<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\GalleryController as CoreGalleryController;
use Illuminate\Http\Request;
class GalleryController extends CoreGalleryController
{
    public function index(Request $request)
    {
        $query = $this->getAlls()->orderByDesc('created_at');
        $datas = $query->paginate(20);
        return view('admin.page.gallery.index', compact('datas'));
    }
}
