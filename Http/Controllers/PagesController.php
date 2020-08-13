<?php

namespace Modules\Pages\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

use App\Helpers\Functions;
use App\Models\Menu;
use App\Models\Language;
use Modules\Pages\Models\Page;

class PagesController extends Controller
{
    protected $menu_id;
    protected $slug;
    protected $folder;
    protected $resize;
    protected $combine_filds;

    public function __construct()
    {
        $slug = Functions::get_menuslug();
        $menu = Menu::where('slug',$slug)->first();
        $this->slug = $slug;
        $this->folder = config('pages.folder');
        $this->resize = config('pages.resize');
        if($menu){
            $this->menu_id = $menu->id;
            $keysFilds = explode(',',$menu->fields_active);
            $titlesFilds = explode(',',$menu->fields_title);
            $combineFilds = array_combine($keysFilds, $titlesFilds);
            $this->combine_filds = $combineFilds;

        }else{
            $this->menu_id = null;
        }
    }   

    public function index()
    {  
        $combine_filds = $this->combine_filds;
        $images_more = '';        
        $slug = $this->slug; 
        $menu_id = $this->menu_id;
        if(!is_null($menu_id)){
            $languages = Language::where('status', 'active')->orderBy('order', 'asc')->get();
            $page = Page::where('menu_id', $menu_id)->first();
            if(!$page)
                $page = new \stdClass;
            return view('Page::index', compact('page', 'slug', 'combine_filds', 'languages', 'menu_id'));            
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

                if(isset($request->image))
                    $data['image'] = $this->_uploadImage($request, $page->image);

                $images_restantes = !is_null($page->more_images) ? $page->more_images.',' : '';
                if(isset($request->image_remove) && !empty($request->image_remove) ){
                    $images_restantes = $this->_removeImage($request->image_remove, $page->more_images );
                } 

                if(isset($request->more_images))
                    $data['more_images'] = $images_restantes.$this->_uploadMultImage($request);
                elseif(!isset($request->more_images) && $images_restantes!='')
                    $data['more_images'] = $images_restantes;


                $page->fill($data);
                $page->save();
            }else{
                $data = $this->_validate($request);

                $data['image'] = $this->_uploadImage($request);
                $data['more_images'] = $this->_uploadMultImage($request);

                $data['menu_id'] = $this->menu_id;
                Page::create($data);
            }
            return redirect()->back()->with('success','Página atualizada com sucesso!');    
        }else{
            abort(403, 'Não existe nenhum menu chamando esta página');
        }

    }

    protected function _removeImage($image_remove, $more_images)
    {
        $image_removeArray = explode(',', $image_remove);
        $more_images = explode(',', $more_images);
        $diferenca = array_diff($more_images, $image_removeArray);
        if(count($diferenca) > 0){
            $retorno = implode(',',$diferenca);
            return $retorno.',';
        }else{
            return '';
        }
    }

    protected function _uploadMultImage(Request $request)
    {
        if(isset($request->more_images)){
            $responseUpload = \Upload::imageMultPublic($request, 'more_images', $this->folder, $this->resize);
            if(count($responseUpload) > 0){
                return implode(',',$responseUpload);
            }
            return null;
        }else{
            return null;
        }
    }

    protected function _uploadImage(Request $request, $nameImage = null)
    {
        if(isset($request->image)){           
            $responseUpload = \Upload::imagePublic($request, 'image', $this->folder, $this->resize, $nameImage);
            if($responseUpload->original['success']){
                return $responseUpload->original['file'];
            }
            return null;
        }else{
            return null;
        }
    }

    protected function _validate(Request $request, $id = null)
    {
        if(is_null($id)){
            return $this->validate($request, [
                'name' => 'required|max:191',
                'slug' => 'required|max:191|unique:pages',
                'image' => 'nullable',
                'summary' => 'nullable',
                'body' => 'nullable',
                'seo_title' => 'nullable|max:90',
                'meta_description' => 'nullable|max:255',
                'meta_keywords' => 'nullable|max:255',
                'more_images' => 'nullable',
                'menu_id' => 'nullable'
            ]);
        }else{
            return $this->validate($request, [
                'name' => 'required|max:191',
                'slug' => "required|max:191|unique:pages,slug,{$id},id",
                'image' => 'nullable',
                'summary' => 'nullable',
                'body' => 'nullable',
                'seo_title' => 'nullable|max:90',
                'meta_description' => 'nullable|max:255',
                'meta_keywords' => 'nullable|max:255',
                'more_images' => 'nullable',
                'menu_id' => 'nullable'
            ]);
        }
    }
    
}