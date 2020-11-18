<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Goutte\Client;
use Validator;
use Symfony\Component\HttpClient\HttpClient;

class ScraperContoller extends BaseController
{
    public function index(Request $request)
    {
      $returnData = [];
      $validator = Validator::make($request->all(), [
        'url' => 'required',
      ]);
      if ($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());       
      }
      $client = new Client(HttpClient::create(['timeout' => 60]));
      $crawler = $client->request('GET', $request->url);
      $metas = $crawler->filter('meta')->each(function($node) {
        $name = $node->attr('name')? $node->attr('name'): $node->attr('property');
        if (isset($name)) {
          $replaced_name = str_replace(":","_", $name);
          return  [$replaced_name => $node->attr('content')];
        }
      });

      foreach($metas as $meta) {
        if(is_array($meta)) {
          foreach ($meta as $key=>$value) {
            $returnData[$key] = $value;
          }
        }
        
      }

      return $returnData;
    }
}
