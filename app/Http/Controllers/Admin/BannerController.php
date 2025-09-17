<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerController extends Controller
{
    public function showBannerEdit()
    {
        $model = new Banner();
        $banners = $model->getAllBanners();
        return view('admin.banner_edit', compact('banners'));
    }

    public function updateBanners(Request $request)
    {
        $model = new Banner();
        $model->deleteAll();

        if ($request->has('banners')) {
            foreach ($request->banners as $bannerData) {
                $path = null;

                if (isset($bannerData['file'])) {
                    $path = $bannerData['file']->store('public/banners');
                    $path = str_replace('public/', 'storage/', $path);
                } elseif (!empty($bannerData['existing_path'])) {
                    $path = $bannerData['existing_path'];
                }

                if ($path) {
                    $model->insertBanner($path);
                }
            }
        }
        return redirect()->route('admin.show.banner.edit')->with('success', 'バナーを更新しました');
    }
}
