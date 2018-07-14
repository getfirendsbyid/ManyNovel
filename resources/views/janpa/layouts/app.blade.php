<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <link rel="shortcut icon" href="{{url('janpa/favicon.ico')}}">
    <link href="{{url('janpa/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('janpa/bootstrap-theme.min.css')}}" rel="stylesheet">
    <link href="{{url('janpa/list.css')}}" rel="stylesheet">
    <script src="{{url('janpa/jquery.min.js')}}"></script>
    <script src="{{url('janpa/bootstrap.min.js')}}"></script>
    <script src="{{url('janpa/bootstrap-hover-dropdown.js')}}"></script>
</head>
<body>

<!--手机版分类-->
<nav class="navbar navbar-default navbar-fixed-top top-bar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="http://www.{{$host}}">
                <img class="hidden-xs" alt="键盘小说网" src="{{url('janpa/logo1.png')}}">
                <img class="visible-xs-inline" alt="键盘小说网" src="{{url('janpa/logo2.png')}}">
            </a>
            <div class="btn-group pull-right visible-xs-inline trigger-overlay" role="group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="glyphicon glyphicon-th"></span> 小说分类 <span class="caret"></span>
                </button>
            </div>
        </div>
        <!--//手机版分类-->

        <div id="navbar" class="collapse navbar-collapse">
            <div class="navbar-form navbar-left fullsearch-form">
                <div class="input-group">
                    <form target="_blank" name="formsearch" action="http://zhannei.{{$host}}/search">
                        <input name="q" type="text" class="form-control" id="search-keyword" placeholder="请输入小说名称..">
                        <span class="input-group-btn btn-head">
                    <button class="btn btn-default" type="submit">搜索</button>
                    </span>
                    </form>
                </div>
            </div>

            <ul class="nav navbar-nav">
                @foreach($nav as $item)
                    <li><a href="http://www.{{$host}}/{{$item->enname}}/">{{$item->name}}</a></li>
                @endforeach
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-th"></span>
                        <span class="hidden-md hidden-sm"> 网站导航 </span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <!--导航-->
                        @foreach($nav as $item)
                            <li><a href="http://www.{{$host}}/{{$item->enname}}/">{{$item->name}}</a></li>
                        @endforeach
                        <!--//导航-->
                    </ul>
                </li>
            </ul>

        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
<!--广告-->
<!--//广告-->

@yield('content')


<div class="clear"></div>
<!--友情链接-->
<div class="list">
    <div class="search-header">
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a>友情链接</a></li>
        </ul>
    </div>
</div>
<!--//友情链接-->

<div class="clear"></div>
<!--广告-->
<!--//广告-->
<footer class="footer hidden-xs">
    <div class="container-fluid">
        <p>
            <a href="javascript:" onclick="window.open(&#39;http://www.janpn.com/templets/ad.html&#39;)" rel="nofollow">广告服务</a> |
            <a href="javascript:" onclick="window.open(&#39;http://www.janpn.com/templets/copyright.html&#39;)" rel="nofollow">版权声明</a> |
            <a href="javascript:" onclick="window.open(&#39;http://www.janpn.com/templets/call.html&#39;)" rel="nofollow">联系我们</a> |
            <a>站长统计使用位置</a>
            <br>
            Copyright © 2018-2020 www.{{$host}} 鼠标小说网 版权所有</p>
    </div>
</footer>
<div class="visible-xs-block footer-bar-placeholder"></div>


<!--手机底部菜单 -->
<div class="overlay overlay-contentscale">
    <div class="row list">
        <div class="col-xs-12 text-center ptb20">
            <div class="input-group col-xs-offset-2 col-xs-7">
                <form target="_blank" name="formsearch" action="http://zhannei.{{$host}}/search">
                    <input name="data" type="text" class="form-control" id="search-keyword" placeholder="请输入小说名称..">
                    <span class="input-group-btn btn-foot">
                        <button class="btn btn-default" type="submit">搜索</button>
                    </span>
                </form>
            </div>
        </div>
        <div class="list-foot">
            @foreach($nav as $item)
                <li class="col-xs-foot text-center"><a href="http://www.{{$host}}/{{$item->enname}}/" rel="nofollow">{{$item->name}}</a></li>
            @endforeach
        </div>
        <div class="col-xs-12 text-center overlay-close">
            <i class="glyphicon glyphicon-remove"></i>
        </div>
    </div>
</div>
<script src="{{url('janpa/nav.overlay.js')}}"></script>
<!--//手机底部菜单 -->

{!! $tdk->baidu_js !!}

</body>
</html>
