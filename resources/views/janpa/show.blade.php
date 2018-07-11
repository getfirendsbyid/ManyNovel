@extends('janpa.layouts.app')
@section('title', $chapter->chapter_number.' '.$chapter->name.'[极速阅读].by '.$novel->author.' - 鼠标小说网')
@section('keywords',$novel->keywords)
@section('description',$novel->description)

@section('content')
    <div class="container body-content read-container">
        <ol class="breadcrumb">
            <li><a href="http:/www.{{$host}}"><i class="fa fa-home fa-fw"></i>鼠标小说网</a></li>
            <li><a href="http://{{$novel->enname}}.janpn.com/">{{$novel->name}}</a></li>
            <span class="pagetop">
        <script src="{{url('janpa/pagetop.js')}}"></script>
        <select name="bcolor" id="bcolor" onchange="javascript:saveSet(),document.getElementById(&#39;content&#39;).style.backgroundColor=this.options[this.selectedIndex].value;document.getElementById(&#39;h1&#39;).style.backgroundColor=this.options[this.selectedIndex].value;document.getElementById(&#39;yueduye&#39;).style.backgroundColor=this.options[this.selectedIndex].value;document.getElementById(&#39;readerListADbox&#39;).style.backgroundColor=this.options[this.selectedIndex].value;document.getElementById(&#39;readerFooterNav&#39;).style.backgroundColor=this.options[this.selectedIndex].value;document.getElementById(&#39;readerListADboxs&#39;).style.backgroundColor=this.options[this.selectedIndex].value;document.getElementById(&#39;readerFooterPage&#39;).style.backgroundColor=this.options[this.selectedIndex].value;">
            <option style="background-color: #E9FAFF" value="#E9FAFF">底色</option>
            <option style="background-color: #E9FAFF" value="#E9FAFF">默认</option>
            <option style="background-color: #ffffff" value="#ffffff">白色</option>
            <option style="background-color: #e3e8f7" value="#e3e8f7">淡蓝</option>
            <option style="background-color: #daebfc" value="#daebfc">蓝色</option>
            <option style="background-color: #ebeaea" value="#ebeaea">淡灰</option>
            <option style="background-color: #e7e3e6" value="#e7e3e6">灰色</option>
            <option style="background-color: #dedcd8" value="#dedcd8">深灰</option>
            <option style="background-color: #d8d7d7" value="#d8d7d7">暗灰</option>
            <option style="background-color: #e6fae4" value="#e6fae4">绿色</option>
            <option style="background-color: #f9fbdd" value="#f9fbdd">明黄</option>
        </select>
                <select name="txtcolor" id="txtcolor" onchange="javascript:saveSet(),document.getElementById(&#39;htmlContent&#39;).style.color=this.options[this.selectedIndex].value;">
                    <option value="">字色</option>
                    <option value="#000000">黑色</option>
                    <option value="#ff0000">红色</option>
                    <option value="#006600">绿色</option>
                    <option value="#0000ff">蓝色</option>
                    <option value="#660000">棕色</option>
                </select>
                <select name="fonttype" id="fonttype" onchange="javascript:saveSet(),document.getElementById(&#39;htmlContent&#39;).style.fontSize=this.options[this.selectedIndex].value;">
                    <option value="24px">字号</option>
                    <option value="12px">小号</option>
                    <option value="14px">较小</option>
                    <option value="16px">中号</option>
                    <option value="18px">较大</option>
                    <option value="24px">大号</option>
                </select>
                <select name="scrollspeed" id="scrollspeed" onchange="javascript:saveSet(),setSpeed(this.value)">
                    <option value="5">滚屏</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
        </span>
        </ol>
        <div class="panel panel-default panel-readcontent" id="content" style="background-color: rgb(233, 250, 255);">
            <div class="page-header text-center">
                <h1 class="readTitle"> {{$chapter->name}} </h1>
            </div>
            <!--广告-->
            <!--//广告-->
            <p class="text-center readPager">
                {{dd(empty($novel))}}
                @if(empty($novel))
                <a class="btn btn-default" href="/"><i class="fa fa-arrow-circle-left fa-fw"></i>没有啦</a>
                @else
                    <a class="btn btn-default" href="http://www.{{$host}}/book/{{$novel->id}}/{{$befor_chapter->id}}.html"><i class="fa fa-arrow-circle-left fa-fw"></i>上一章</a>
                    @endif
                <a class="btn btn-default" href="http://www.{{$host}}/book/{{$novel->enname}}.html"><i class="fa fa-list fa-fw"></i>章节目录</a>

                 @if(empty($novel))
                <a class="btn btn-default" href="/">下一章<i class="fa fa-arrow-circle-right fa-fw"></i></a>
                 @else
                 <a class="btn btn-default" href="http://www.{{$host}}/book/{{$novel->id}}/{{$last_chapter->id}}.html">下一章<i class="fa fa-arrow-circle-right fa-fw"></i></a>
                @endif
            </p>
            <p class="text-center readPager">
                <a class="btn btn-default" href="http://www.{{$host}}"><i class="fa fa-home fa-fw"></i>返回首页</a>
                {{--<a class="btn btn-primary" href="http://www.{{$host}}/css/history.html"><i class="fa fa-history fa-fw"></i>阅读记录</a>--}}
            </p>
            <!--广告-->
            <!--//广告-->
            <div class="panel-body" id="htmlContent" style="font-size: 24px;">
                    {!! $chapter->chapter_content!!}
            </div>
            <!--广告-->
            <!--//广告-->
            <p class="text-center readPager">
                <a class="btn btn-default" href="http://www.{{$host}}/book/{{$novel->id}}/{{$befor_chapter->id}}.html"><i class="fa fa-arrow-circle-left fa-fw"></i>上一章</a>
                <a class="btn btn-default" href="http://www.{{$host}}/book/{{$novel->enname}}.html"><i class="fa fa-list fa-fw"></i>章节目录</a>
                <a class="btn btn-default" href="http://www.{{$host}}/book/{{$novel->id}}/{{$last_chapter->id}}.html">下一章<i class="fa fa-arrow-circle-right fa-fw"></i></a>
            </p>
            <p class="text-center readPager">
                <a class="btn btn-default" href="http://www.{{$host}}"><i class="fa fa-home fa-fw"></i>返回首页</a>
                {{--<a class="btn btn-primary" href="http://www.{{$host}}/css/history.html"><i class="fa fa-history fa-fw"></i>阅读记录</a>--}}
            </p>
            <!--广告-->
            <!--//广告-->
        </div>
    </div>
    @endsection