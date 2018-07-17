@extends('janpa.layouts.app')

@section('title','《'.$novel->name.'》'.$novel->name.'[免费阅读] - 鼠标小说网')
@section('keywords', implode(',',explode("\r\n",chunk_split($chapter[0]->name,6))).','.implode(',',explode("\r\n",chunk_split($chapter[1]->name,6))))
@section('description',$novel->description)

@section('content')
    <!--手机上下篇-->
    <div class="row visible-xs-inline footer-bar">
        @if(empty($befo_novel))
            <div class="col-xs-3 text-center">
                <a title="没有啦" class="btn btn-default" href="/">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
            </div>
        @else
            <div class="col-xs-3 text-center">
                <a title="上一章" class="btn btn-default" href="http://{{$befor_novel->enname}}.{{$host}}/">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
            </div>
        @endif
        <div class="col-xs-6 text-center"></div>
        @if(empty($last_novel))
            <div class="col-xs-3 text-center">
                <a title="没有啦" class="btn btn-default" href="/"><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
        @else
            <div class="col-xs-3 text-center">
                <a title="下一章" class="btn btn-default" href="http://{{$last_novel->enname}}.{{$host}}/"><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
        @endif
    </div>
    <!--//手机上下篇-->

    <div class="container">
        <h3>{{$navname}}:《{{$novel->name}}》</h3>
        <div class="row movie">
            <div class="col-md-12 info">
                <p><span class="header">{{$novel->name}} [小说作者]:</span> <span id="header_title">{{$novel->author}}</span></p>
                <p><span class="header">{{$novel->name}} [最新章节]:</span> 第{{$novel->new_chapter_number}}章 {{$novel->new_chapter}} </p>
                <p><span class="header">{{$novel->name}} [更新时间]:</span> {{$novel->updated_at}} </p>
                <p><span class="header">{{$novel->name}} [小说简介]:</span> {{$novel->description}}</p>
                <p><a class="btn btn-primary" href="http://{{$host}}/book/{{$novel->enname}}.html" target="_blank">
                        <span class="glyphicon glyphicon-book"></span> 免费在线阅读 </a>
                    {{--<a style="margin-left:10px;" class="btn btn-primary" href="http://{{$host}}/css/history.html" target="_blank">--}}
                        {{--<span class="glyphicon glyphicon-time"></span> 阅读记录--}}
                    {{--</a>--}}
                </p>
                <!--分享-->
                <p></p>
                <!--//分享-->
            </div>
        </div>
    </div>

    <!--广告-->
    <!--//广告-->

    <div class="container">
        <div class="col-md-12 info">
            <div class="row ptb10">
                <div class="col-xs-go text-center">
                    <a class="btn btn-lg btn-default btn-block" href="javascript:" onclick="window.open(&#39;http://txt.janpn.com/to/txt/7/7349.txt&#39;,&#39;_self&#39;)" rel="nofollow"><span class="glyphicon glyphicon-save"></span> 小说下载 </a>
                </div>
                <div class="col-xs-go text-center">
                    <a class="btn btn-lg btn-primary btn-block" href="http://{{$host}}/book/{{$novel->id}}/{{$chapter[0]->id}}.html" target="_blank">
                        <span class="glyphicon glyphicon-list-alt"></span> 极速阅读
                    </a>
                </div>
                <!--广告-->
                <!--//广告-->
            </div>
        </div>
    </div>

    <!--广告-->
    <!--//广告-->

    <div class="container">
        <div class="row movie">
            <div class="col-md-12 info">
                <p><span class="header str-over-dot">{{$novel->name}} [小说目录]1 更新时间：{{$novel->updated_at}}</span> </p>
                @foreach($chapter as $item)
                    <li><a href="http://www.{{$host}}/book/{{$novel->id}}/{{$item->id}}"> {{$item->name}}</a></li>
                @endforeach
            </div>
        </div>
    </div>

    <!--广告-->
    <!--//广告-->

    <div class="clear"></div>
    <div class="copyright"></div>
    <div class="titleh3">同类小说</div>
    <div class="list">
        @foreach($othernovel as $item)
            <a title="{{$item->name}}" class="shop" href="http://{{$item->enname}}.{{$host}}/">
                <div class="shop-info">
                    <b>《{{$item->name}}》</b>
                </div>
                <div class="shop-info">
                    {{$item->author}} [著]
                </div>
                <div class="shop-info">
                    <span class="glyphicon glyphicon-bullhorn"> 第{{$item->new_chapter_number}}章 {{$item->new_chapter_name}}</span>
                </div>
            </a>
        @endforeach
    </div>
    <!--评论-->
    <div class="clear"></div>
    <div class="copyright"></div>
    <div class="titleh3">评论</div>

    <!--//评论-->

    <div class="clear"></div>
    @endsection