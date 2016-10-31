<?php

namespace App\Http\AdminControllers;

use App\Http\Requests;
use YuanChao\Editor\EndaEditor;
use App\Http\AdminControllers\Controller;

class UploadController extends Controller
{
    /**
     *上传图片
     *
     *@return json
     */
    public function uploadImage()
    {
        $data = EndaEditor::uploadImgFile('uploads/images');
        return json_encode($data);
    }
}
