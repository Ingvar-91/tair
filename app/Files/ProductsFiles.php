<?php

namespace App\Files;

use Illuminate\Http\Request;
use Storage;
use App\Toolkit\AcImage;

trait ProductsFiles{
    
    private function uploadImagesProduct($files){
        $fileNames = '';
        $folder = config('filesystems.products');
        if(!Storage::has($folder)){
            Storage::makeDirectory($folder);
        }
        
        if(!Storage::has($folder.'small')){
            Storage::makeDirectory($folder.'small');
        }
        
        if(!Storage::has($folder.'middle')){
            Storage::makeDirectory($folder.'middle');
        }
        
        if(!Storage::has($folder.'large')){
            Storage::makeDirectory($folder.'large');
        }
        
        $resolutionImages = [
            'x3' => ['width' => 900, 'height' => 900],
            'x2' => ['width' => 600, 'height' => 600],
            'x1' => ['width' => 300, 'height' => 300]
        ];
        
        $mime = ['image/png', 'image/jpeg', 'image/gif'];//допустимый формат файлов
        $quality = 95;//качество изображения
        foreach ($files as $file) {
            if(!is_numeric(array_search($file->getMimeType(), $mime))) continue;
            
            if($file->getMimeType() == 'image/png'){
                //если формат png, тогда снижаем качество выходного изображения что бы файл меньше весил. Иначе файлы png после обработки имеют большей вес.
                $quality = 10;
            }
            AcImage::setRewrite(true);//разрешить перезапись при конфликте имен
            AcImage::setQuality($quality);//задаем качество изображения
            $imageResize = AcImage::createImage($file->getPathName());//создаем изображение
            $uploadedImageName = '';//путь и наименование загруженного большего изображения, из него потом будем ресайзить более мелкие
            
            $extension = $file->getClientOriginalExtension();//расширение
            $dataImage = getimagesize($file); //данные об изображении, $dataImage[0] - ширина, $dataImage[1] - высота
            $nameFile = substr(md5(time() + rand(15, 95)).'.'.$extension, 6);//новое имя изображения
            $fileNames .= $nameFile.'|';
            
            foreach ($resolutionImages as $size => $val){
                if($size == 'x3'){
                    $path = $folder.'large/'.$nameFile;
                    $uploadedImageName = $path;
                    $ratio = $val['width'] / $val['height'];
                    if($val['width'] > $val['height']){//если в настройках задана ширина больше высоты
                        $w = (int)($dataImage[1] * $ratio);
                        $h = (int)($dataImage[0] / $ratio);
                        $imageResize->cropCenter($w, $h)->resize($val['width'], $val['height'])->save($path);
                    }
                    else if($val['width'] < $val['height']){
                        $w = (int)($dataImage[0] * $ratio);
                        $h = (int)($dataImage[1] / $ratio);
                        $imageResize->cropCenter($w, $h)->resize($val['width'], $val['height'])->save($path);
                    }
                    else if($val['width'] == $val['height']){
                        if($dataImage[0] > $dataImage[1]){//ширина исходного изображения больше высоты
                            $imageResize->cropCenter(round(100 / ((int)$dataImage[0] / (int)$dataImage[1])).'%', '100%')->resize((int)$val['width'], (int)$val['height'])->save($path);
                        }
                        elseif($dataImage[1] > $dataImage[0]){//высота исходного изображения больше ширины
                            $imageResize->cropCenter('100%', round(100 / ($dataImage[1] / $dataImage[0])).'%')->resize($val['width'], $val['height'])->save($path);
                        }
                        elseif($dataImage[1] == $dataImage[0]){//ширина и высота исходного изображения равны друг другу
                            $imageResize->resize($val['width'], $val['height'])->save($path);//ресайзим и сохраняем
                        }
                    }
                }
                else if($size == 'x2'){
                    $path = $folder.'middle/'.$nameFile;
                    if($uploadedImageName){
                        AcImage::createImage($uploadedImageName)->resize($val['width'], $val['height'])->save($path);
                    }
                }
                else if($size == 'x1'){
                    $path = $folder.'small/'.$nameFile;
                    if($uploadedImageName){
                        AcImage::createImage($uploadedImageName)->resize($val['width'], $val['height'])->save($path);
                    }
                    $uploadedImageName = '';
                }
            }
        }
        return $fileNames;
    }

    private function removeImagesProduct($data){
        $folder = config('filesystems.products');
        if(is_array($data)){
            $deleteImage = [];
            foreach ($data as $key => $imgName) {
                $deleteImage[] = $folder.'small/'.$imgName;
                $deleteImage[] = $folder.'middle/'.$imgName;
                $deleteImage[] = $folder.'large/'.$imgName;
            }
            return Storage::delete($deleteImage);
        }
        return Storage::delete($folder.$data);
    }
}