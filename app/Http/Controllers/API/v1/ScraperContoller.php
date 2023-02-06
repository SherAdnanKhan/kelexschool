<?php

namespace App\Http\Controllers\API\v1;

use Validator;
use Goutte\Client;
use Illuminate\Http\Request;
use App\Http\Traits\ScrapedDataTrait;
use Symfony\Component\HttpClient\HttpClient;
use App\Http\Controllers\API\v1\BaseController;

class ScraperContoller extends BaseController
{
  use ScrapedDataTrait;
  
    public function index(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'url' => 'required',
      ]);
      if ($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());       
      }

      $returnData= $this->scrapeddata($request->url);

      return $returnData;

    }
    
}
