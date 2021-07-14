<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\timestamp;
use GuzzleHttp\Client;

class SiteController extends Controller
{
    const API_BASE = 'https://blog-api.stmik-amikbandung.ac.id/api/v2/blog/_table/';
    const API_KEY = 'ef9187e17dce5e8a5da6a5d16ba760b75cadd53d19601a16713e5b7c4f683e1b';
    private $apiClient;
    
    public function __construct(){
        $this->apiClient = new Client ([
            'base_uri' => self::API_BASE,
            'headers' => [
                'X-DreamFactory-API-Key' => self::API_KEY
            ]
        ]);
    }

    public function index(){
        Cache::forget('index');
        $data = Cache::get('index', function(){
            try{
                $reqData = $this->apiClient->get('articles');
                $resource = json_decode($reqData->getBody())->resource;
                Cache::add('index',$resource);
                return $resource;
            }catch (RequestException $e){
                return [];
            }
        });

        return view('index', ['data' => $data]);
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $name = $request->input('frm-name');
            $email = $request->input('frm-email');
            try{
                $reqData = $this->apiClient->get('authors');
                $resource = json_decode($reqData->getBody())->resource;
                Cache::add('login',$resource);

                foreach($resource as $data){
                    if($name == $data->name && $email == $data->email){
                        session()->put('author', $name);
                        return redirect("/");
                    }
                }

            }catch (RequestException $e){
                return [];
            }
        }
        return view('login');
    }

    public function logout(){
        session()->flush();
        return redirect("/");
    }

    public function register(Request $request){
        if($request->isMethod('post')){
            $name = $request->input('frm-name');
            $email = $request->input('frm-email');
            $dataModel = [
                'resource'=>[
                ]
            ];

            $dataModel['resource'][]=[
                'name' => $name,
                'email' => $email,
            ];

            try{
                $reqData = $this->apiClient->post('authors', [
                    'json' => $dataModel
                ]);
                $apiResponse = json_decode($reqData->getBody())->resource;
                $newId = $apiResponse[0]->id;

                Cache::forget('index');
                
                session()->put('author', $name);

                return redirect("/");
            }catch(Exception $e){
                abort(501);
            }
        }
        return view('register');
    }

    public function getArticles($id){
        Cache::forget('comment');
        $key = "articles/{$id}";
        Cache::forget($key);
        $data = Cache::get($key, function() use ($key){
            try{
                $reqData = $this->apiClient->get($key);
                $resource = json_decode($reqData->getBody());
                Cache::add($key, $resource);
                return $resource;
            }catch(Exception $e){
                abort(404);
            }
        });

        $comment = Cache::get('comment', function(){
            try{
                $reqData = $this->apiClient->get('comments');
                $resource = json_decode($reqData->getBody())->resource;
                Cache::add('comment',$resource);
                return $resource;
            }catch (RequestException $e){
                return [];
            }
        });

        return view('viewArticle', ['data' => $data, 
                    'comment' => $comment]
        );
    }

    public function newArticles(Request $request){
        if($request->isMethod('post')){
            $title = $request->input('frm-title');
            $content = $request->input('frm-content');
            $dataModel = [
                'resource'=>[
                ]
            ];

            $dataModel['resource'][]=[
                'author' => 1,
                'title' => $title,
                'content' => $content
            ];

            try{
                $reqData = $this->apiClient->post('articles', [
                    'json' => $dataModel
                ]);
                $apiResponse = json_decode($reqData->getBody())->resource;
                $newId = $apiResponse[0]->id;

                Cache::forget('index');

                return redirect("/articles/{$newId}");
            }catch(Exception $e){
                abort(501);
            }
        }
        return view('newArticle');
    }

    public function Comment(Request $request){
        if($request->isMethod('post')){
            $article = $request->input('frm-article');
            $author = $request->input('frm-author');
            $content = $request->input('frm-content');
            $dataModel = [
                'resource'=>[
                ]
            ];

            $dataModel['resource'][]=[
                'article' => $article,
                'author' => $author,
                'content' => $content
            ];

            try{
                $reqData = $this->apiClient->post('comments', [
                    'json' => $dataModel
                ]);
                $apiResponse = json_decode($reqData->getBody())->resource;
                $newId = $apiResponse[0]->id;

                Cache::forget('index');

                return redirect("/articles/{$article}");
            }catch(Exception $e){
                abort(501);
            }
        }
        return view('viewArticle');
    }

    public function pembaharuanArticles($id){
        $key = "articles/{$id}";
        $data = Cache::get($key, function() use ($key){
            try{
                $reqData = $this->apiClient->get($key);
                $resource = json_decode($reqData->getBody());

                Cache::add($key, $resource);
                return $resource;
            }catch(Exception $e){
                abort(404);
            }
        });
        return view('updateArticle', ['data' => $data]);
    }

    public function updateArticles(Request $request, $id){
        if($request->isMethod('post')){
            $title = $request->input('frm-title');
            $author = $request->input('frm-author');
            $content = $request->input('frm-content');
            $key = "articles/{$id}";
            
            try{
                $this->apiClient->request('PATCH', $key, [
                    'json' => [
                        'author' => $author,
                        'title' => $title,
                        'content' => $content
                    ]
                ]);

                Cache::forget('index');
                Cache::forget($key);

                return redirect("/");
            }catch(Exception $e){
                abort(501);
            }
        }
    }

    public function deleteArticles($id){
        $key = "articles/{$id}";
        try{
            $this->apiClient->delete($key);

            Cache::forget('index');

            return redirect("/");
        }catch(Exception $e){
            abort(501);
        }
    }

    public function publishArticles($id){
        $key = "articles/{$id}";
        
        try{
            $this->apiClient->request('PATCH', $key, [
                'json' => [
                    'published_at' => now()
                ]
            ]);

            return redirect("/");
        }catch(Exception $e){
            abort(501);
        }
    }

}

/*
    public function hello(){

        $hasil = '98%';
        return view('hello', [
            'text' => $hasil
        ]);
    }*/