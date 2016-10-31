                        <div class="form-group">
                            <label for="tag" class="col-md-3 control-label">标题</label>
                            <div class="col-md-5">
                                <input name="title" class="form-control title" placeholder="请输入标题">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tag" class="col-md-3 control-label">分类</label>
                            <div class="col-md-5">
                                <select class="form-control" name="category_id" id="category_id">
                                    @foreach ($categories['top'] as $top_category)
                                        <option value="{{ $top_category->id }}">{{ $top_category->name }}</option>
                                        @if(isset($categories['second'][$top_category->id]))
                                            @foreach ($categories['second'][$top_category->id] as $scategory)
                                                <option value="{{ $scategory->id }}"
                                                        @if(isset($article->category_id) && $scategory->id == $article->category_id)
                                                        selected
                                                        @endif
                                                        >&nbsp;&nbsp;&nbsp;{{ $scategory->name }}</option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tag" class="col-md-3 control-label">内容</label>
                            <div class="col-md-5">
                                <div class="editor">
                                    @include('editor::head')
                                    {!! Form::textarea('content', '', ['class' => 'form-control','id'=>'myEditor']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tag" class="col-md-3 control-label">标签</label>
                            <div class="col-md-5">
                                {!! Form::select('tag_list[]',$tags,null,['id' => 'tag_list','class' => 'form-control','multiple']) !!}
                            </div>
                        </div>
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <br>
