@extends('admin.layouts.base')
@section('content')
    <div class="main animsition">
        <div class="container-fluid">

            <div class="row">
                <div class="">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">编辑文章</h3>
                        </div>
                        <div class="panel-body">

                            @include('admin.partials.errors')
                            @include('admin.partials.success')
{!! Form::open( array('url' => route('admin.article.update',$article->id), 'class' => 'form-horizontal', 'method' => 'put') ) !!}
                                @include('admin.articles._edit_form')
                                 <div class="form-group">
                                     <div class="col-md-7 col-md-offset-3">
                                         <button type="submit" class="btn btn-primary btn-md">
                                             <i class="fa fa-plus-circle"></i>
                                             保存
                                         </button>
                                     </div>
                                 </div>
                    {!!Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
