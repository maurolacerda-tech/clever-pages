<?php

namespace Modules\Pages\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

use App\Helpers\Functions;
use App\Models\Menu;
use Modules\Pages\Models\Page;

class PagesController extends Controller
{
    protected $menu_id;

    public function __construct()
    {
        $slug = Functions::get_menuslug();
        $menu = Menu::where('slug',$slug)->first();
        if($menu)
            $this->menu_id = $menu->id;
        else
            $this->menu_id = null;

    }   

    public function index()
    {        
        if(!is_null($this->menu_id)){
            $page = Page::where('menu_id', $this->menu_id)->first();
            if(!$page)
                $page = new \stdClass;
            return view('Page::index', compact('page'));            
        }else{
            abort(403, 'Página não encontrada');
        }
    }

    public function store(Request $request)
    {
        if(isset($request->slug) && !is_null($request->slug) )
            $request->merge(['slug' => Str::slug($request->slug)]);
        else
            $request->request->add(['slug' => Str::slug($request->name)]);       

        if(!is_null($this->menu_id)){
            $page = Page::where('menu_id', $this->menu_id)->first();
            if($page){
                $data = $this->_validate($request, $page->id);
                $data['image'] = _uploadImage($request, $page->image);
                $page->fill($data);
                $page->save();
            }else{
                $data = $this->_validate($request);
                $data['image'] = _uploadImage($request);
                Page::create($data);
            }
            return redirect()->back()->with('success','Página atualizada com sucesso!');    
        }else{
            abort(403, 'Não existe nenhum menu chamando esta página');
        }

    }

    protected function _uploadImage(Request $request, $nameImage = null){
        if($request->image){           
            $responseUpload = \Upload::imagePublic($request, 'image', 'pages', 'peq,150,150;med,480,480', $nameImage);
            if($responseUpload->original['success']){
                return $responseUpload->original['file'];
            }
            return null;
        }
    }

    protected function _validate(Request $request, $id = null)
    {
        if(is_null($id)){
            return $this->validate($request, [
                'name' => 'required|max:191',
                'slug' => 'required|max:191|unique:brands',
                'status' => 'required',
                'image' => 'required',
                'categories' => 'nullable',
                'summary' => 'nullable',
                'description' => 'nullable',
                'seo_title' => 'nullable|max:90',
                'meta_description' => 'nullable|max:255',
                'meta_keywords' => 'nullable|max:255',
                'order' => 'nullable|numeric'
            ]);
        }else{
            return $this->validate($request, [
                'name' => 'required|max:191',
                'slug' => "required|max:191|unique:brands,slug,{$id},id",
                'status' => 'required',
                'image' => 'nullable',
                'categories' => 'nullable',
                'summary' => 'nullable',
                'description' => 'nullable',
                'seo_title' => 'nullable|max:90',
                'meta_description' => 'nullable|max:255',
                'meta_keywords' => 'nullable|max:255',
                'order' => 'nullable|numeric'
            ]);
        }
    }
    
}