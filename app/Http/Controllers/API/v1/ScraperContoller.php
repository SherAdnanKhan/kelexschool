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
      $title = $description = $image = $favicon = $url =  "";
      $find_slash = '/';
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

      $links = $crawler->filter('link')->each(function($node) {
        $name = $node->attr('rel')? $node->attr('rel'): $node->attr('name');
        if (isset($name)) {
          return  [$name => $node->attr('href')];
        }
      });

      foreach($metas as $meta) {
        if(is_array($meta)) {
          foreach ($meta as $key=>$value) {
            //$returnData[$key] = $value;
            if (!isset($title) || $title == '') {
              if($key == 'og_title' || $key == 'twitter_title' || $key == 'title') {
                $title = $value;
              }
            }

            if (!isset($description) || $description == '') {
              if($key == 'og_description' || $key == 'twitter_description' || $key == 'description') {
                $description = $value;
              }
            }

            if (!isset($image) || $image == '') {
              if($key == 'og_image' || $key == 'image') {
                $image = $value;
              }
            }

          }
        } 
      }

      foreach($links as $link) {
        if(is_array($link)) {
          foreach ($link as $key=>$value) {
            if (!isset($favicon) || $favicon == '') {
              if($key == 'icon') {
                $favicon = $value;
              }
            }
          }
        }
        
      }
      $web_url_parse = parse_url($request->url);
      foreach($web_url_parse as $key=>$value) {
        if($key == "scheme"){
          $url = $value;
        }
        if($key == "host" && $url != '') {
          $url .= "://".$value;
        }
      }

      if ($favicon != '') {
        if (!filter_var($favicon, FILTER_VALIDATE_URL)) {
          $favicon = $url.$favicon;
        }
      }

      if ($image != '') {
        if (!filter_var($image, FILTER_VALIDATE_URL)) {
          //$image = $url.$image;
          $cut_string = substr($image, 1);
          $check_slash = stripos($image, $find_slash);
          if ($check_slash == 0) {
            $image = $url.$firstIndex;
          }else {
            $image = $url.$image;
          }

          //return $firstIndex;
        }
      }
      $returnData['title'] = $title;
      $returnData['description'] = $description;
      $returnData['image'] = $image;
      $returnData['favicon'] = $favicon;
      $returnData['url'] = $url;

      return $returnData;
    }
}
