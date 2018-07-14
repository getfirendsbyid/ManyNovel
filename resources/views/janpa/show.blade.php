<!DOCTYPE html>
<!-- saved from url=(0050)http://www.janpn.com/book/177/177138/36401873.html -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>《{{$novel->name}}》{{$chapter->name}} [极速阅读].by {{$novel->author}}  - 鼠标小说网'</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <link rel="shortcut icon" href="http://www.janpn.com/favicon.ico">
    <link href="{{url('janpa/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('janpa/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{url('janpa/site.css')}}" rel="stylesheet">
    <script src="{{url('janpa/jquery.min.js')}}"></script>
    <script src="{{url('janpa/bootstrap.min.js')}}"></script>
    <!--[if lt IE 9]><script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.js"></script><![endif]-->
    <script src="{{url('janpa/dialog.js')}}"></script>
    <script src="{{url('janpa/book.js')}}"></script>
    <script src="{{url('janpa/profit.js')}}"></script>
</head>
<body>

<div class="navbar navbar-inverse" id="header">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="http://www.janpn.com/" class="navbar-brand logo" title="键盘小说网">鼠标小说网</a></div>
            <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation" id="nav-header">
            <div class="nav search">
                <form target="_blank" name="formsearch" action="http://zhannei.zbtorch.cn">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="请输入小说名称.." id="bdcsMain" name="q">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="fa fa-search fa-fw"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="clear"></div>
            <ul class="nav navbar-nav">
                @foreach($nav as $item)
                    <li><a href="http://www.{{$host}}/{{$item->enname}}/">{{$item->name}}</a></li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>



<div class="container body-content read-container">
    <ol class="breadcrumb">
        <li><a href="http://www.{{$host}}/"><i class="fa fa-home fa-fw"></i>鼠标小说网</a></li>
        <li><a href="http://{{$novel->enname}}.{{$host}}">{{$novel->name}}</a></li>
        <span class="pagetop">
        <script src="{{url('janpa/pagetop.js')}}"></script>
        </span>
    </ol>
    <div class="panel panel-default panel-readcontent" id="content" style="background-color: rgb(249, 251, 221);">
        <div class="page-header text-center">
            <h1 class="readTitle"> {{$chapter->name}}</h1>
        </div>
        <!--广告-->
        <!--//广告-->
        <p class="text-center readPager">
            @if(empty($befor_chapter))
                <a class="btn btn-default" href="/"><i class="fa fa-arrow-circle-left fa-fw"></i>没有啦</a>
            @else
                <a class="btn btn-default" href="http://www.{{$host}}/book/{{$novel->id}}/{{$befor_chapter->id}}.html"><i class="fa fa-arrow-circle-left fa-fw"></i>上一章</a>
            @endif
            <a class="btn btn-default" href="http://www.{{$host}}/book/{{$novel->enname}}.html"><i class="fa fa-list fa-fw"></i>章节目录</a>

            @if(empty($last_chapter))
                <a class="btn btn-default" href="/">下一章<i class="fa fa-arrow-circle-right fa-fw"></i></a>
            @else
                <a class="btn btn-default" href="http://www.{{$host}}/book/{{$novel->id}}/{{$last_chapter->id}}.html">下一章<i class="fa fa-arrow-circle-right fa-fw"></i></a>
            @endif
        </p>
        <p class="text-center readPager">
            <a class="btn btn-default" href="http://www.janpn.com/index"><i class="fa fa-home fa-fw"></i>返回首页</a>
        </p>
        <!--广告-->
        <!--//广告-->
        <div class="panel-body" id="htmlContent" style="font-size: 14px; color: rgb(102, 0, 0);">
                {!! $chapter->content !!}
        </div>
        <!--广告-->
        <!--//广告-->
        <p class="text-center readPager">
            @if(empty($befor_chapter))
                <a class="btn btn-default" href="/"><i class="fa fa-arrow-circle-left fa-fw"></i>没有啦</a>
            @else
                <a class="btn btn-default" href="http://www.{{$host}}/book/{{$novel->id}}/{{$befor_chapter->id}}.html"><i class="fa fa-arrow-circle-left fa-fw"></i>上一章</a>
            @endif
            <a class="btn btn-default" href="http://www.{{$host}}/book/{{$novel->enname}}.html"><i class="fa fa-list fa-fw"></i>章节目录</a>

            @if(empty($last_chapter))
                <a class="btn btn-default" href="/">下一章<i class="fa fa-arrow-circle-right fa-fw"></i></a>
            @else
                <a class="btn btn-default" href="http://www.{{$host}}/book/{{$novel->id}}/{{$last_chapter->id}}.html">下一章<i class="fa fa-arrow-circle-right fa-fw"></i></a>
            @endif
        </p>
        <p class="text-center readPager">
            <a class="btn btn-default" href="http://www.{{$host}}"><i class="fa fa-home fa-fw"></i>返回首页</a>
        </p>
        <!--广告-->
        <!--//广告-->
    </div>
</div>


<p class="fs-12 text-muted text-center hidden-xs">温馨提示：关闭浏览器时，请加入浏览器书签方便您下次继续阅读。</p>
<div class="back-to-top" title="返回顶部">
    <a href="http://www.{{$host}}/book/{{$novel->id}}/{{$chapter->id}}.html#"><i class="fa fa-chevron-up"></i></a>
</div>
<footer>
    <p>
        <a href="http://www.{{$host}}" target="_blank">广告服务</a> |
        <a href="http://www.{{$host}}" target="_blank">版权声明</a> |
        <a href="http://www.{{$host}}" target="_blank">联系我们</a> |
        | 冀ICP备12007938号-2
    </p>
    <p>Copyright © 2018-2020 www.{{$host}} 小说小说网 版权所有.</p>
</footer>
<script src="{{url('janpa/pagebottom(1).js')}}"></script>
<script src="{{url('janpa/yuedu.js')}}"></script>


</body></html>