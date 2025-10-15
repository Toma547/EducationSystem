<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryTime;
use App\Models\Curriculum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DeliveryController extends Controller
{
    /**
     * 配信日時編集画面
     */
    public function showDeliveryEdit($id)
    {
        $curriculum = Curriculum::with('deliveryTimes')->findOrFail($id);
        // ファイル名 delivery.blade.php に合わせる
        return view('admin.delivery', compact('curriculum'));
    }
    public function store(Request $request, $id)
    {
        $curriculum = Curriculum::findOrFail($id);
    
        $delivery_from = $request->input('delivery_from', []);
        $start_time    = $request->input('start_time', []);
        $delivery_to   = $request->input('delivery_to', []);
        $end_time      = $request->input('end_time', []);
        $delivery_ids  = $request->input('time_ids', []); // ←修正！
    
        $count = max(
            count($delivery_from),
            count($start_time),
            count($delivery_to),
            count($end_time),
            count($delivery_ids)
        );
    
        for ($i = 0; $i < $count; $i++) {
            $fromDateRaw = trim($delivery_from[$i] ?? '');
            $fromTimeRaw = trim($start_time[$i] ?? '');
            $toDateRaw   = trim($delivery_to[$i] ?? '');
            $toTimeRaw   = trim($end_time[$i] ?? '');
            $deliveryId  = $delivery_ids[$i] ?? null;
    
            // 空行はスキップ
            if ($fromDateRaw === '' && $fromTimeRaw === '' && $toDateRaw === '' && $toTimeRaw === '') {
                continue;
            }
    
            // 数字のみ抽出して整形（例: "2025-07-13" や "20250713" どちらでもOK）
            $fromDate = preg_replace('/[^0-9]/', '', $fromDateRaw);
            $toDate   = preg_replace('/[^0-9]/', '', $toDateRaw);
            $fromTime = str_pad(preg_replace('/[^0-9]/', '', $fromTimeRaw), 4, '0', STR_PAD_LEFT);
            $toTime   = str_pad(preg_replace('/[^0-9]/', '', $toTimeRaw), 4, '0', STR_PAD_LEFT);
    
            // 必要な最小長さチェック
            if (strlen($fromDate) < 8 || strlen($toDate) < 8 || strlen($fromTime) < 3) {
                Log::warning("配信日時のフォーマット不正 (index={$i})", compact('fromDateRaw','fromTimeRaw','toDateRaw','toTimeRaw'));
                continue;
            }
    
            try {
                $from = \Carbon\Carbon::createFromFormat('YmdHi', $fromDate . $fromTime);
                $to   = \Carbon\Carbon::createFromFormat('YmdHi', $toDate . $toTime);
            } catch (\Exception $e) {
                Log::warning("Carbon parse failed (index={$i}): " . $e->getMessage());
                continue;
            }
    
            $data = [
                'delivery_from' => $from->toDateTimeString(),
                'delivery_to'   => $to->toDateTimeString(),
            ];
    
            if ($deliveryId) {
                $delivery = DeliveryTime::find($deliveryId);
                if ($delivery) {
                    $delivery->update($data);
                } else {
                    // ID が指定されているが見つからない -> 新規作成（必ず curriculums_id をセット）
                    $data['curriculums_id'] = $curriculum->id;
                    DeliveryTime::create($data);
                }
            } else {
                // 新規作成
                $data['curriculums_id'] = $curriculum->id;
                DeliveryTime::create($data);
            }
        }
    
        return redirect()->route('admin.show.curriculum.list')->with('success', '配信日時を更新しました');
    } 

    /**
     * Ajax削除
     */
    public function destroy($id)
    {
        $delivery = DeliveryTime::find($id);
        if(!$delivery) {
            return response()->json(['success' => false, 'message' => 'データが見つかりません']);
        }

        $delivery->delete();
        return response()->json(['success' => true, 'message' => '削除しました']);
    }
}
