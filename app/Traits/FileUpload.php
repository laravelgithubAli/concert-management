<?php

namespace App\Traits;

use http\Env\Request;

trait FileUpload
{

    public function uploader(Request $request,$directory,$fileName)
    {
      return  $request->file($fileName)->storePubliclyAs(
            "{$directory}",
            $request->file($fileName)->getClientOriginalName());
    }


}
