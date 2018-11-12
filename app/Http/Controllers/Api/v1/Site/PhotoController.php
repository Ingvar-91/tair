<?php

namespace App\Http\Controllers\Api\v1\Site;

use App\Http\Controllers\Api\v1\RestController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use ATehnix\VkClient\Client;
use ATehnix\VkClient\Auth as AuthVK;
use ATehnix\VkClient\Requests\Request as RequestVK;

class PhotoController extends RestController {

    public function getAllAlbum(Request $request): Response {
        $offset = 0;
        if($request->offset){
            $offset = $request->offset;
        }
        $api = new Client;
        $api->setDefaultToken(config('app.apiVk.access_token'));
        
        $albums = $api->request('photos.getAlbums', [
            'group_id' => config('app.apiVk.group_id'),
            'offset' => $offset,
            'count' => 12
        ]);
        
        $data= '';
        if(isset($albums['response']['items'])){
            //получаем превьюхи альбомов
            $thumbIds = [];
            foreach ($albums['response']['items'] as $album){
                $thumbIds[] = '-'.config('app.apiVk.group_id').'_'.$album['thumb_id'];
            }
            
            $thumbs = $api->request('photos.getById', [
                'photos' => implode(',', $thumbIds)
            ]);
            
            foreach ($albums['response']['items'] as $i => $album){
                foreach ($thumbs['response'] as $thumb){
                    if($thumb['album_id'] == $album['id']) $albums['response']['items'][$i]['thumb'] = $thumb;
                }
            }
            
            $data = $albums['response']['items'];
        }
        return $this->success($data);
    }
    
    public function getPhotosAlbum(Request $request){
        $api = new Client;
        $api->setDefaultToken(config('app.apiVk.access_token'));
        $photo = $api->request('photos.get', [
            'group_id' => config('app.apiVk.group_id'),
            'album_id' => $request->id
        ]);
        
        $this->data['photo'] = '';
        
        if(isset($photo['response']['items'])){
            $this->data['photo'] = $photo['response']['items'];
        }
        
        //album info
        $albumInfo = $api->request('photos.getAlbums', [
            'group_id' => config('app.apiVk.group_id'),
            'album_ids' => $request->id
        ]);
        $this->data['album_title'] = $albumInfo['response']['items'][0]['title'];
        $this->data['album_id'] = $request->id;
        
        return $this->success($this->data);
    }

}
