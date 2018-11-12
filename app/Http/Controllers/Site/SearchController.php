<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Site\Products;

use vladkolodka\phpMorphy\Morphy;

use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;

class SearchController extends Controller{

    const tmpl = 'site/search/';

    public function index(Request $request){
        $this->data['searchType'] = $request->searchType;
        
        /*if($request->searchType == 'google'){
            //$parameters = array(
                //'start' => 10,
                //'num' => 10
            //);
            
            $fulltext = new LaravelGoogleCustomSearchEngine();
            $this->data['resultsGoogle'] = $fulltext->getResults(trim($request->search));
        }
        else{
            $morphy = new Morphy('ru');
            $searchArrayWord = explode(' ', trim($request->search));
            $arrayWord = collect();
            foreach ($searchArrayWord as $i => $word) {
                $arrayWord->push( collect($morphy->getPseudoRoot(mb_strtoupper($word, 'UTF-8'))) );
            }
            $this->data['resultsInner'] = Products::search($arrayWord->collapse());
        }*/
		
		$morphy = new Morphy('ru');
		$searchArrayWord = explode(' ', trim($request->search));
		$arrayWord = collect();
		foreach ($searchArrayWord as $i => $word) {
			$arrayWord->push( collect($morphy->getPseudoRoot(mb_strtoupper($word, 'UTF-8'))) );
		}
		$this->data['resultsInner'] = Products::search($arrayWord->collapse());
		
        return view(self::tmpl.'index', $this->data);
    }

}
