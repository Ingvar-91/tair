<?php

namespace App\Http\Controllers\Api\v1\Site;

use App\Http\Controllers\Api\v1\RestController;
use Illuminate\Http\Request;

class UploadController extends RestController {

    public function upload(Request $request) {
        $path = $request->file('file')->store('upload_test');

        return $this->success($this->data);
    }

}
