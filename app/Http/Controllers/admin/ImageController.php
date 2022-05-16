<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Image;

class ImageController extends Controller
{
    public function resizeImage($image,$id,$path){
        $name=$id.'.'.$image->getClientOriginalExtension();
        $des['1']='upload/'.$path.'/small';
        $des['2']='upload/'.$path.'/medium';
        $des['3']='upload/'.$path.'/large';
        $width['1']=100;
        $width['2']=500;
        $width['3']=1000;
        for($i=1;$i<=3;$i++){
            $img=Image::make($image->path());
            $status=$img->resize($width[$i],$width[$i])->save($des[$i].'/'.$name);
        }
        return 1;
    }
}
