<?php

namespace App\Files;

use Illuminate\Http\Request;
use Storage;
use App\Toolkit\AcImage;

use Image;

trait UploadImages{
    
    private function uploadImages($files, $name, $return = false, $crop = 'cropCenter'){
        $folder = config('filesystems.'.$name.'.path');
        $resolutionImages = config('filesystems.'.$name.'.resolution');
        
        if(!Storage::has($folder)){
            Storage::makeDirectory($folder);
        }
        
        if(isset($resolutionImages['x1'])){
            if(!Storage::has($folder.'small')){
                Storage::makeDirectory($folder.'small');
            }
        }
        
        if(isset($resolutionImages['x2'])){
            if(!Storage::has($folder.'middle')){
                Storage::makeDirectory($folder.'middle');
            }
        }
        
        if(isset($resolutionImages['x3'])){
            if(!Storage::has($folder.'large')){
                Storage::makeDirectory($folder.'large');
            }
        }
        
        $mime = ['image/png', 'image/jpeg', 'image/gif'];//допустимый формат файлов
        
        if(is_array($files)){
            foreach($files as $file){
                if(!is_numeric(array_search($file->getMimeType(), $mime))) continue;
                $fileNames = $this->uploadFile($file, $resolutionImages, $folder, $return, $crop);
            }
        }
        else{
            $fileNames = $this->uploadFile($files, $resolutionImages, $folder, $return, $crop);
        }
        return $fileNames;
    }
    
    private function uploadFile($file, $resolutionImages, $folder, $return, $crop){
        $quality = 100;//качество изображения
        $fileNames;
        
        if($file->getMimeType() == 'image/png'){
            //если формат png, тогда снижаем качество выходного изображения что бы файл меньше весил. Иначе файлы png после обработки имеют большей вес.
            $quality = 10;
        }
        //AcImage::setRewrite(true);//разрешить перезапись при конфликте имен
        //AcImage::setQuality($quality);//задаем качество изображения
        //$imageResize = AcImage::createImage($file->getPathName());//создаем изображение
        $uploadedImageName = '';//путь и наименование загруженного большего изображения, из него потом будем ресайзить более мелкие

        $extension = $file->getClientOriginalExtension();//расширение
        $dataImage = getimagesize($file); //данные об изображении, $dataImage[0] - ширина, $dataImage[1] - высота
        $nameFile = substr(md5(time() + rand(15, 95)).'.'.$extension, 6);//новое имя изображения
        
        if($return === 1){
            $fileNames = $nameFile;
        }
        elseif($return === 2){
            $fileNames[] = $nameFile;
        }
        else{
            $fileNames = '';
            $fileNames .= $nameFile.'|';
        }

        foreach ($resolutionImages as $size => $val){
            if($size == 'x3'){
                $path = $folder.'large/'.$nameFile;

                $uploadedImageName = $path;
                
                if($val['width'] == null){
                    Image::make($file->getPathName())->heighten($val['height'])->save($path);
                }
                else if($val['height'] == null){
                    Image::make($file->getPathName())->widen($val['width'])->save($path);
                }
                else if($val['width'] > $val['height']){//если в настройках задана ширина больше высоты
                    //->orientate()
                    //$w = (int)($dataImage[1] * $ratio);
                    //$h = (int)($dataImage[0] / $ratio);
                    
                    Image::make($file->getPathName())->orientate()->fit($val['width'], $val['height'])->save($path);
                    
                    /*$w = (int)($dataImage[1] * $ratio);
                    $h = (int)($dataImage[0] / $ratio);
                    $imageResize->cropCenter($w, $h)->resize($val['width'], $val['height'])->save($path);*/
                }
                else if($val['width'] < $val['height']) {//если в настройках задана высота больше ширины
                    //$w = (int)($dataImage[0] * $ratio);
                    //$h = (int)($dataImage[1] / $ratio);
                    //$imageResize->cropCenter($w, $h)->resize($val['width'], $val['height'])->save($path);
                    //Image::make($file->getPathName())->crop($w, $h, $val['width'], $val['height'])->save($path);
                    
                    Image::make($file->getPathName())->orientate()->fit($val['height'], $val['width'])->save($path);
                }
                else if($val['width'] == $val['height']){//если в настройках равно
                    if($dataImage[0] > $dataImage[1]){//ширина исходного изображения больше высоты
                        if($crop == 'cropCenter'){
                            $img = Image::make($file->getPathName())->orientate()->fit($val['height']);//в значении можно указать, либо ширину, либо высоту
                        }
                        elseif($crop == 'imposition'){
                            $img = Image::make($file->getPathName())->orientate()->widen($val['width']);
                            $img->resizeCanvas(0, $img->width() - $img->height(), 'center', true)->save($path);
                        }
                    }
                    elseif($dataImage[1] > $dataImage[0]){//высота исходного изображения больше ширины
                        if($crop == 'cropCenter'){
                            $img = Image::make($file->getPathName())->orientate()->fit($val['height']);//в значении можно указать, либо ширину, либо высоту
                        }
                        elseif($crop == 'imposition'){
                            $img = Image::make($file->getPathName())->orientate()->heighten($val['height']);
                            $img->resizeCanvas($img->height() - $img->width(), 0, 'center', true)->orientate()->save($path);
                        }
                    }
                    elseif($dataImage[1] == $dataImage[0]){//ширина и высота исходного изображения равны друг другу
                        Image::make($file->getPathName())->orientate()->resize($val['width'], $val['height'])->save($path);
                    }
                }
            }
            else if($size == 'x2'){
                $path = $folder.'middle/'.$nameFile;
                if($uploadedImageName){
                    if($val['width'] == null){
                        Image::make($uploadedImageName)->heighten($val['height'])->save($path);
                    }
                    else if($val['height'] == null){
                        Image::make($uploadedImageName)->widen($val['width'])->save($path);
                    }
                    else{
                        Image::make($uploadedImageName)->resize($val['width'], $val['height'])->save($path);
                    }
                }
            }
            else if($size == 'x1'){
                $path = $folder.'small/'.$nameFile;
                if($uploadedImageName){
                    if($val['width'] == null){
                        Image::make($uploadedImageName)->heighten($val['height'])->save($path);
                    }
                    else if($val['height'] == null){
                        Image::make($uploadedImageName)->widen($val['width'])->save($path);
                    }
                    else{
                        Image::make($uploadedImageName)->resize($val['width'], $val['height'])->save($path);
                    }
                }
                $uploadedImageName = '';
            }
        }
        
        return $fileNames;
    }
    
    private function removeImages($images, $name){
        if($images){
            $folder = config('filesystems.'.$name.'.path');
            $data = array_diff(explode('|', $images), ['']);
            if(is_array($data)){
                $deleteImage = [];
                foreach ($data as $key => $imgName) {
                    if(Storage::has($folder.'small')){
                        if(Storage::exists($folder.'small/'.$imgName)){
                            $deleteImage[] = $folder.'small/'.$imgName;
                        }
                    }
                    
                    if(Storage::has($folder.'middle')){
                        if(Storage::exists($folder.'middle/'.$imgName)){
                            $deleteImage[] = $folder.'middle/'.$imgName;
                        }
                    }
                    
                    if(Storage::has($folder.'large')){
                        if(Storage::exists($folder.'large/'.$imgName)){
                            $deleteImage[] = $folder.'large/'.$imgName;
                        }
                    }
                }
                return Storage::delete($deleteImage);
            }
            return Storage::delete($folder.$data);
        }
    }
}