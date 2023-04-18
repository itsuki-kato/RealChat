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
     * @return string $uploaded_file_name
     */
    public function uploadImgAndGetName(UploadedFile $file, string $target_path):string
    {
        if(!$file || !$target_path) { return null; }

        // ファイル名が被らないようにタイムスタンプを付与
        $file_name = $file->getClientOriginalName();
        $uploaded_file_name = time().$file_name;

        // strage配下の指定パスに保存
        $file->storeAs($target_path, $uploaded_file_name, 'public');

        Log::info('ファイルアップロード完了'.$target_path.$uploaded_file_name);

        return $uploaded_file_name;
    }
}
