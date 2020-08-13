@extends('admin.layout.default')

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-lock bg-orange"></i>
                <div class="d-inline">
                    <h5>Página</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard.index')}}"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Página</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Quem Somos</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="row clearfix">
    <div class="card table-card">
        
        <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active show" id="pills-timeline-tab" data-toggle="pill" href="#tab-pt-br" role="tab" aria-controls="pills-timeline" aria-selected="true">
                    Português Brasil
                </a>
            </li>
            @foreach ($languages as $language)
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#tab-{{$language->code}}" role="tab" aria-controls="pills-profile" aria-selected="false">
                    {{$language->name}}
                </a>
            </li>
            @endforeach
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade active show" id="tab-pt-br" role="tabpanel" aria-labelledby="pills-timeline-tab">
                <div class="card-body">
                    {{ Form::model($page, ['url' => ['/panel/'.$slug], 'method' => 'POST', 'files' => true ]) }}
                    @csrf
                    <input type="hidden" name="image_remove" id="image_remove">

                    @isset ($combine_filds['image'])
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {{ Form::label('image', $combine_filds['image']) }}
                                <input type="file" name="image" class="dropify" @if(isset($page->image)) data-default-file="{{ url("storage/pages/".$page->image) }}"@endif data-height="150" data-max-file-size="2M" data-allowed-file-extensions="jpg png jpeg"  />
                            </div>
                        </div>
                    </div>
                    @endisset

                    @isset ($combine_filds['name'])
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {{ Form::label('name', $combine_filds['name']) }}
                                {{ Form::text('name', null, ['class' => $errors->has('name') ?  'form-control is-invalid' : 'form-control', 'onkeyup' => "slugGenerate(this,'Modules\\\Pages\\\Models\\\Page')"]) }}
                                @include('admin.partials._help_block',['field' => 'name'])
                            </div>
                        </div>
                    </div>
                    @endisset

                    @isset ($combine_filds['summary'])
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {{ Form::label('summary', $combine_filds['summary']) }}
                                {{ Form::textarea('summary', null, ['class' => $errors->has('summary') ?  'form-control is-invalid' : 'form-control']) }}
                                @include('admin.partials._help_block',['field' => 'summary'])
                            </div>
                        </div>
                    </div>
                    @endisset

                    @isset ($combine_filds['body'])
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {{ Form::label('body', $combine_filds['body']) }}
                                {{ Form::textarea('body', null, ['class' => $errors->has('body') ?  'form-control is-invalid html-editor' : 'form-control html-editor']) }}
                                @include('admin.partials._help_block',['field' => 'body'])
                            </div>
                        </div>
                    </div>
                    @endisset

                    @isset ($combine_filds['more_images'])
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {{ Form::label('more_images', $combine_filds['more_images']) }}
                                <input type="file" name="more_images[]" class="multiple_images" multiple="multiple"  />
                            </div>
                        </div>
                    </div>
                    @endisset

                    @if (isset($combine_filds['slug']) || isset($combine_filds['seo_title']) || isset($combine_filds['meta_description']) || isset($combine_filds['meta_keywords']) )
                        <h6>Meta Tags</h6>
                        <div class="row">
                            @isset ($combine_filds['slug'])
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('slug', $combine_filds['slug'], ['class' => 'form-label']) }} 
                                    {{ Form::text('slug', null, ['class' => $errors->has('slug') ?  'form-control is-invalid' : 'form-control']) }}                            
                                    @include('admin.partials._help_block',['field' => 'slug'])
                                </div>
                            </div>
                            @endisset

                            @isset ($combine_filds['seo_title'])
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('seo_title', $combine_filds['seo_title']) }} 
                                    {{ Form::text('seo_title', null, ['class' => $errors->has('seo_title') ?  'form-control is-invalid' : 'form-control']) }}
                                    @include('admin.partials._help_block',['field' => 'seo_title'])
                                </div>
                            </div>
                            @endisset

                        </div>

                        @isset ($combine_filds['meta_description'])
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{ Form::label('meta_description', $combine_filds['meta_description']) }} 
                                    {{ Form::text('meta_description', null, ['class' => $errors->has('meta_description') ?  'form-control is-invalid' : 'form-control']) }}
                                    @include('admin.partials._help_block',['field' => 'meta_description'])
                                </div>
                            </div>
                        </div>
                        @endisset

                        @isset ($combine_filds['meta_keywords'])
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{ Form::label('meta_keywords', $combine_filds['meta_keywords']) }} <p>Para adicionar o próximo item use a tecla <code>enter</code> ou <code>,</code> </p>
                                    {{ Form::text('meta_keywords', null, ['class' => $errors->has('meta_keywords') ?  'form-control tags is-invalid ' : 'form-control tags']) }}
                                    @include('admin.partials._help_block',['field' => 'meta_keywords'])
                                </div>
                            </div>
                        </div>
                        @endisset
                    @endif
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn2 btn-dark ml-2">Atualizar</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            @foreach ($languages as $language)
            <div class="tab-pane fade" id="tab-{{$language->code}}" role="tabpanel" aria-labelledby="pills-timeline-tab">
                <div class="card-body">
                    @php
                        $colectionTranslation = $language->translation($menu_id, $page->id);
                    @endphp
                    {{ Form::model($colectionTranslation, ['route' => ['admin.translations.store'], 'method' => 'POST']) }}
                    @csrf
                    <input type="hidden" name="image_remove" id="image_remove">
                    <input type="hidden" name="menu_id" value="{{$menu_id}}">
                    <input type="hidden" name="code" value="{{$language->code}}">
                    <input type="hidden" name="parent_id" value="{{$page->id}}">

                    
                    @isset ($combine_filds['name'])
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {{ Form::label('name', $combine_filds['name']) }}
                                {{ Form::text('name', null, ['class' => $errors->has('name') ?  'form-control is-invalid' : 'form-control', 'onkeyup' => "slugGenerate(this,'Modules\\\Pages\\\Models\\\Page')"]) }}
                                @include('admin.partials._help_block',['field' => 'name'])
                            </div>
                        </div>
                    </div>
                    @endisset

                    @isset ($combine_filds['summary'])
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {{ Form::label('summary', $combine_filds['summary']) }}
                                {{ Form::textarea('summary', null, ['class' => $errors->has('summary') ?  'form-control is-invalid' : 'form-control']) }}
                                @include('admin.partials._help_block',['field' => 'summary'])
                            </div>
                        </div>
                    </div>
                    @endisset

                    @isset ($combine_filds['body'])
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {{ Form::label('body', $combine_filds['body']) }}
                                {{ Form::textarea('body', null, ['class' => $errors->has('body') ?  'form-control is-invalid html-editor' : 'form-control html-editor']) }}
                                @include('admin.partials._help_block',['field' => 'body'])
                            </div>
                        </div>
                    </div>
                    @endisset                  

                    @if (isset($combine_filds['seo_title']) || isset($combine_filds['meta_description']) || isset($combine_filds['meta_keywords']) )
                        <h6>Meta Tags</h6>
                        <div class="row">
                            @isset ($combine_filds['seo_title'])
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('seo_title', $combine_filds['seo_title']) }} 
                                    {{ Form::text('seo_title', null, ['class' => $errors->has('seo_title') ?  'form-control is-invalid' : 'form-control']) }}
                                    @include('admin.partials._help_block',['field' => 'seo_title'])
                                </div>
                            </div>
                            @endisset

                            @isset ($combine_filds['meta_description'])
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('meta_description', $combine_filds['meta_description']) }} 
                                    {{ Form::text('meta_description', null, ['class' => $errors->has('meta_description') ?  'form-control is-invalid' : 'form-control']) }}
                                    @include('admin.partials._help_block',['field' => 'meta_description'])
                                </div>
                            </div>
                            @endisset

                        </div>

                        @isset ($combine_filds['meta_keywords'])
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{ Form::label('meta_keywords', $combine_filds['meta_keywords']) }} <p>Para adicionar o próximo item use a tecla <code>enter</code> ou <code>,</code> </p>
                                    {{ Form::text('meta_keywords', null, ['class' => $errors->has('meta_keywords') ?  'form-control tags is-invalid ' : 'form-control tags']) }}
                                    @include('admin.partials._help_block',['field' => 'meta_keywords'])
                                </div>
                            </div>
                        </div>
                        @endisset
                    @endif
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn2 btn-dark ml-2">Atualizar</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            @endforeach
        </div>
        
            
    </div>
</div>
@endsection



@section('scriptjs')
    @isset ($combine_filds['more_images'])
        @php
            $more_images_json = isset($page->more_images_json) ? $page->more_images_json : '';
        @endphp
        <script>
            $(document).ready(function() {
                carregaMultiplasImages( {!! $more_images_json !!} );
            });
        </script>
    @endisset
@endsection