<?php

namespace App\Files;

use Illuminate\Http\Request;
use Storage;
use App\Toolkit\AcImage;

trait CkeditorFiles{
    
    private function uploadCkeditorFiles($file){
        $folder = config('filesystems.ckeditor');
        if(!Storage::has($folder)){
            Storage::makeDirectory($folder);
        }
        $quality = 95;//качество изображения
        //если формат png, тогда снижаем качество выходного изображения что бы файл меньше весил. Иначе файлы png после обработки имеют большей вес.
        if($file->getMimeType() == 'image/png') {
            $quality = 10;
        }
        AcImage::setQuality($quality);//задаем качество изображения
        $type = $file->getClientOriginalExtension();//тип
        $nameImg = substr(md5(time()).'.'.$type, 10);//новое имя изображения
        $path = $folder.$nameImg;//путь для изображения
        
        $imageResize = AcImage::createImage($file->getPathName());//создаем изображение

        //$dataImage = getimagesize($file->getPathName()); //данные об изображении, $dataImage[0] - ширина, $dataImage[1] - высота
        //урезаем изображение по ширине
        $imageResize->resizeByWidth(1200)->save($path);
        return $nameImg;
        
        
    }

    /*private function removeCkeditorFiles($file){
        $folder = config('filesystems.avatars');
        Storage::delete($folder.$file);
    }*/
}