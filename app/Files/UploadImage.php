<?php

namespace App\Files;

use Illuminate\Http\Request;
use Storage;
use App\Toolkit\AcImage;

trait UploadImage{
    
    //загрузка аватарки
    private function uploadImage($image, $name, $crop = 'cropCenter'){
        $nameImg = '';
        $folder = config('filesystems.'.$name.'.path');
        $resolutionImages = config('filesystems.'.$name.'.resolution');
        if(!Storage::has($folder)){//проверяем наличие каталога для аватарок, если нету, создаем
            Storage::makeDirectory($folder);
        }
        $quality = 95;//качество изображения
        //если формат png, тогда снижаем качество выходного изображения что бы файл меньше весил. Иначе файлы png после обработки имеют большей вес.
        if($image->getMimeType() == 'image/png') {
            $quality = 10;
        }
        AcImage::setQuality($quality);//задаем качество изображения
        $type = $image->getClientOriginalExtension();//тип
        $nameImg = substr(md5(time()).'.'.$type, 10);//новое имя изображения
        $path = $folder.$nameImg;//путь для изображения
        $imageResize = AcImage::createImage($image->getPathName());//создаем изображение

        $dataImage = getimagesize($image->getPathName()); //данные об изображении, $dataImage[0] - ширина, $dataImage[1] - высота
        
        if($crop == 'cropCenter'){
            //в зависимости ширины и высоты изображения срезаем отпределенную часть картинки что бы получился квадрат
            if($dataImage[0] > $dataImage[1]){//ширина больше высоты
                $imageResize->cropCenter(round(100 / ($dataImage[0] / $dataImage[1])).'%', '100%')->resize($resolutionImages['width'], $resolutionImages['height'])->save($path);
            }
            elseif($dataImage[1] > $dataImage[0]){//высота больше ширины
                $imageResize->cropCenter('100%', round(100 / ($dataImage[1] / $dataImage[0])).'%')->resize($resolutionImages['width'], $resolutionImages['height'])->save($path);
            }
            elseif($dataImage[1] == $dataImage[0]){//ширина и выота равны друг другу
                $imageResize->resize($resolutionImages['width'], $resolutionImages['height'])->save($path);//ресайзим и сохраняем
            }
        }
        elseif($crop == 'resizeByHeight'){//ресайз по высоте
            $imageResize->resizeByHeight($resolutionImages['height'])->save($path);
        }
        elseif($crop == 'resize'){//ресайз по заданной высоте и ширине
            $ratio = $resolutionImages['width'] / $resolutionImages['height'];
            if($resolutionImages['width'] > $resolutionImages['height']){//если в настройках задана ширина больше высоты
                $w = (int)($dataImage[1] * $ratio);
                $h = (int)($dataImage[0] / $ratio);
                $imageResize->cropCenter($w, $h)->resize($resolutionImages['width'], $resolutionImages['height'])->save($path);
            }
            else if($resolutionImages['width'] < $resolutionImages['height']){
                $w = (int)($dataImage[0] * $ratio);
                $h = (int)($dataImage[1] / $ratio);
                $imageResize->cropCenter($w, $h)->resize($resolutionImages['width'], $resolutionImages['height'])->save($path);
            }
            else if($resolutionImages['width'] == $resolutionImages['height']){
                if($dataImage[0] > $dataImage[1]){//ширина исходного изображения больше высоты
                    $imageResize->cropCenter(round(100 / ((int)$dataImage[0] / (int)$dataImage[1])).'%', '100%')->resize((int)$resolutionImages['width'], (int)$resolutionImages['height'])->save($path);
                }
                elseif($dataImage[1] > $dataImage[0]){//высота исходного изображения больше ширины
                    $imageResize->cropCenter('100%', round(100 / ($dataImage[1] / $dataImage[0])).'%')->resize($resolutionImages['width'], $resolutionImages['height'])->save($path);
                }
                elseif($dataImage[1] == $dataImage[0]){//ширина и высота исходного изображения равны друг другу
                    $imageResize->resize($resolutionImages['width'], $resolutionImages['height'])->save($path);//ресайзим и сохраняем
                }
            }
        }
        
        return $nameImg;
    }

    private function removeImage($image, $name){
        if($image){
            $path = config('filesystems.'.$name.'.path').$image;
            $exists = Storage::exists($path);
            if($exists) Storage::delete($path);
        }
    }
}