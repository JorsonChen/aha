                        <div class="form-group">
                            <label for="tag" class="col-md-3 control-label">标题</label>
                            <div class="col-md-5">
                                <input name="title" class="form-control title" placeholder="请输入标题" @if(isset($article->title)) value="{{$article->title}}" @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tag" class="col-md-3 control-label">分类</label>
                            <div class="col-md-5">
                                <select class="form-control" name="category_id" id="category_id">
                                    @foreach ($categories['top'] as $top_category)
                                        <option value="{{ $top_category->id }}"
                                                @if(isset($article->category_id) && $top_category->id == $article->category_id)
                                                selected
                                                @endif
                                                >{{ $top_category->name }}</option>
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
                                    {!! Form::textarea('content',$article->content, ['class' => 'form-control','id'=>'myEditor']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tag" class="col-md-3 control-label">标签</label>
                            <div class="col-md-5">
                                <select  id="tag_list" class="form-control" multiple="multiple" name="tag_list[]">
                                    @foreach($tags as $tag)
                                        <option value="{{$tag->id}}"  @if(in_array($tag->id,$article_tags)) selected @endif>{{$tag->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <br>
