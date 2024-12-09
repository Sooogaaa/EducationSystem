<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showBannerEdit()
    {
        $banners = DB::table('banners')->get();

        return view('admin.banner_edit', compact('banners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function showBannerStore(BannerRequest $request)
    {
        $request->validated();
        $count = 0;

        DB::beginTransaction();

        try {
            if ($request->hasFile('banner_images')) {
                foreach ($request->file('banner_images') as $file) {
                    $path = $file->store('banners', 'public');
                    DB::table('banners')->insert([
                        'image' => $path,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $count++;
                }
            }
            if ($count === 1) {
                $message = '画像ファイルを保存しました。';
            } elseif ($count > 1) {
                $message = "画像ファイルを{$count}件保存しました。";
            } else {
                $message = '画像ファイルが選択されていません。';
            }

            DB::commit();
            return redirect()->back()->with('success',  $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', '登録に失敗しました。');
        }
        //     DB::commit();
        //     return response()->json(['success' => $message]);

        // }catch (\Exception $e) {
        //         DB::rollback();
        //         return response()->json(['error' => '登録に失敗しました。'], 500);
        //     }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function showBannerDelete($id)
    {
        try {
            $banner = DB::table('banners')->where('id', $id)->first();
            if ($banner) {
                Storage::delete('public/' . $banner->image);
                DB::table('banners')->where('id', $id)->delete();
                return response()->json(['success' => '画像ファイルが削除されました。']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => '削除に失敗しました。'], 500);
        }
    }
}
