<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class FileService
{
    /**
     * フロント側からアップロードされた画像を指定パスに保存する
     * NOTE：formからアップロードした画像しか使用できない
     *
     * @param UploadedFile $file
     * @param string $target_path(storage/app/publicの下の階層から指定する)
     * @return string $upload_file_name
     */
    public function uploadImg(UploadedFile $file, $target_path)
    {
        if(!$file || !$target_path) { return null; }

        // ファイル名が被らないようにタイムスタンプを付与
        $file_name = $file->getClientOriginalName();
        $upload_file_name = time().$file_name;

        // strage配下の指定パスに保存
        $file->storeAs($target_path, $upload_file_name, 'public');

        Log::info('ファイルアップロード完了'.$target_path.$upload_file_name);

        return $upload_file_name;
    }
}
