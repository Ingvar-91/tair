<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Youtube;

use Illuminate\Http\Request;

class VideoController extends Controller {

    const tmpl = 'site/video/';
    
    public function index(Request $request){
        $nextToken = null;
        if($request->nextToken){
            $nextToken = $request->nextToken;
        }
        
        $params = [
            'channelId'     => 'UCSID0Loao_aRUuQqY69CFHw',
            'type'          => 'video',
            'part'          => 'id, snippet',
            'maxResults'    => 8
        ];
        $listChannelVideos = Youtube::paginateResults($params, $nextToken);
        
        if($request->ajax()){
            return response()->json($listChannelVideos);
        }
        
        $this->data['listChannelVideos'] = $listChannelVideos;
        return view(self::tmpl.'index', $this->data);
    }
}
