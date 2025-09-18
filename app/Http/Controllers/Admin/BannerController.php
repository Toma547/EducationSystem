<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();

        try {
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
            DB::commit();
            \Log::debug('更新成功');
            return redirect()->route('admin.show.banner.edit');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('バナー更新失敗：' . $e->getMessage());
            return redirect()->back();
        }
    }
}
