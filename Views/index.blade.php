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
        <div class="card-block">
            <form method="post" action="/panel/{{$slug}}/store">
                @csrf

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('image', 'Imagem') }}
                            <input type="file" name="image" class="dropify" @if(isset($page->image)) data-default-file="{{ url("storage/pages/".$page->image) }}"@endif data-height="150" data-max-file-size="2M" data-allowed-file-extensions="jpg png jpeg"  />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('name', 'Título') }} <code>*</code>
                            {{ Form::text('name', null, ['class' => $errors->has('name') ?  'form-control is-invalid' : 'form-control']) }}
                            @include('admin.partials._help_block',['field' => 'name'])
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('summary', 'Resumo') }}
                            {{ Form::textarea('summary', null, ['class' => $errors->has('summary') ?  'form-control is-invalid' : 'form-control']) }}
                            @include('admin.partials._help_block',['field' => 'summary'])
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('body', 'Descrição') }}
                            {{ Form::textarea('body', null, ['class' => $errors->has('body') ?  'form-control is-invalid' : 'form-control']) }}
                            @include('admin.partials._help_block',['field' => 'body'])
                        </div>
                    </div>
                </div>

                <h6>Meta Tags</h6>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('seo_title', 'Title') }} 
                            {{ Form::text('seo_title', null, ['class' => $errors->has('seo_title') ?  'form-control is-invalid' : 'form-control', 'onkeyup' => "slugGenerate(this,'Modules\Pages\Models\Page')"]) }}
                            @include('admin.partials._help_block',['field' => 'seo_title'])
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('slug', 'URL Amigável', ['class' => 'form-label']) }} 
                            {{ Form::text('slug', null, ['class' => $errors->has('slug') ?  'form-control is-invalid' : 'form-control']) }}                            
                            @include('admin.partials._help_block',['field' => 'slug'])
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('meta_description', 'Meta Description') }} 
                            {{ Form::text('meta_description', null, ['class' => $errors->has('meta_description') ?  'form-control is-invalid' : 'form-control']) }}
                            @include('admin.partials._help_block',['field' => 'meta_description'])
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('meta_keywords', 'Meta Keywords') }} <p>Para adicionar o próximo item use a tecla <code>enter</code> ou <code>,</code> </p>
                            {{ Form::text('meta_keywords', null, ['class' => $errors->has('meta_keywords') ?  'form-control tokenfield is-invalid' : 'form-control tokenfield']) }}
                            @include('admin.partials._help_block',['field' => 'meta_keywords'])
                        </div>
                    </div>
                </div>



                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
</div>
@endsection