<!DOCTYPE html>
<!-- saved from url=(0030)http://zuowubusheng.janpn.com/ -->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$yuming->webname}}</title>
    <meta name="description" content="{{$yuming->description}}">
    <meta name="keywords" content="{{$yuming->keyword}}">
    <link rel="shortcut icon" href="http://www.janpn.com/favicon.ico">
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
            <a href="{{$host}}">
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
                    <form target="_blank" name="formsearch" action="http://zhannei.janpn.com/cse/search">
                        <input name="q" type="text" class="form-control" id="search-keyword" placeholder="请输入小说名称..">
                        <input name="s" value="15947871991047423724" type="hidden">
                        <span class="input-group-btn btn-head">
                    <button class="btn btn-default" type="submit">搜索</button>
                    </span>
                    </form>
                </div>
            </div>
            <ul class="nav navbar-nav">
                <ul class="nav navbar-nav">
                    @foreach($nav as $item)
                        <li><a href="http://{{$host}}/{{$item->enname}}/">{{$item->name}}</a></li>
                    @endforeach
                </ul>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-th"></span>
                        <span class="hidden-md hidden-sm"> 网站导航 </span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <!--导航-->
                            @foreach($nav as $item)
                                <li><a href="{{$host}}/{{$item->enname}}/">{{$item->name}}</a></li>
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

<!--手机上下篇-->
<div class="row visible-xs-inline footer-bar">
    <div class="col-xs-3 text-center"><a title="上一章" class="btn btn-default" href="http://sibiao.janpn.com/"><span class="glyphicon glyphicon-chevron-left"></span></a>
    </div>
    <div class="col-xs-6 text-center"></div>
    <div class="col-xs-3 text-center"><a title="下一章" class="btn btn-default" href="http://hexuchengshi.janpn.com/"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div>
</div>
<!--//手机上下篇-->

<div class="container">
    <h3>{{$novel->nav}}：《{{$novel->name}}》</h3>
    <div class="row movie">
        <div class="col-md-12 info">
            <p><span class="header">{{$novel->name}} [小说作者]:</span> <span id="header_title">{{$novel->author}}</span></p>
            <p><span class="header">{{$novel->name}} [最新章节]:</span> 第{{$novel->new_chapter_number}}章 {{$novel->new_chapter}} </p>
            <p><span class="header">{{$novel->name}} [更新时间]:</span> {{$novel->updated_at}} </p>
            <p><span class="header">{{$novel->name}} [小说简介]:</span> {{$novel->description}}</p>
            <p><a class="btn btn-primary" href="http://{{$host}}/book/zuowubusheng.html" target="_blank">
                    <span class="glyphicon glyphicon-book"></span> 免费在线阅读 </a>
                <script src="./《氪无不胜》氪无不胜[TXT小说下载] - 键盘小说网_files/down.js.下载"></script>
                <a style="margin-left:10px;" class="btn btn-primary" href="http://{{$host}}/css/history.html" target="_blank">
                    <span class="glyphicon glyphicon-time"></span> 阅读记录
                </a>
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
                <a class="btn btn-lg btn-primary btn-block" href="http://{{$host}}/book/zuowubusheng.html" target="_blank">
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
            <p><span class="header str-over-dot">{{$novel->name}} [小说目录] 更新时间：{{$novel->updated_at}}</span> </p>
            {{--@foreach($chapter as $item)--}}
            {{--<li>第{{$item->chapter_number}}章 {{$item->name}}</li>--}}
            {{--@endforeach--}}
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
<!--广告-->
<!--//广告-->
<footer class="footer hidden-xs">
    <div class="container-fluid">
        <p><a href="javascript:" onclick="window.open(&#39;http://www.janpn.com/templets/ad.html&#39;)" rel="nofollow">广告服务</a> | <a href="javascript:" onclick="window.open(&#39;http://www.janpn.com/templets/copyright.html&#39;)" rel="nofollow">版权声明</a> | <a href="javascript:" onclick="window.open(&#39;http://www.janpn.com/templets/call.html&#39;)" rel="nofollow">联系我们</a> |  <script>document.writeln("<a href=\'http://new.cnzz.com/v1/login.php?siteid=1260419850\' target=\'_blank\'>站长统计</a>");</script><a href="http://new.cnzz.com/v1/login.php?siteid=1260419850" target="_blank">站长统计</a>
            | 冀ICP备12007938号-2 <br>
            Copyright © 2018-2020 www.janpn.com 键盘小说网 版权所有</p>
    </div>
</footer>
<div class="visible-xs-block footer-bar-placeholder"></div>


<!--手机底部菜单 -->
<div class="overlay overlay-contentscale">
    <div class="row list">
        <div class="col-xs-12 text-center ptb20">
            <div class="input-group col-xs-offset-2 col-xs-7">
                <form target="_blank" name="formsearch" action="http://zhannei.janpn.com/cse/search">
                    <input name="q" type="text" class="form-control" id="search-keyword" placeholder="请输入小说名称..">
                    <input name="s" value="15947871991047423724" type="hidden">
                    <span class="input-group-btn btn-foot">
<button class="btn btn-default" type="submit">搜索</button>
</span>
                </form>
            </div>
        </div>
        <div class="list-foot">
            <li class="col-xs-foot text-center"><a href="http://www.janpn.com/xuanhuanqihuan/" rel="nofollow">玄幻奇幻</a></li>
            <li class="col-xs-foot text-center"><a href="http://www.janpn.com/wuxiaxiuzhen/" rel="nofollow">武侠修真</a></li>
            <li class="col-xs-foot text-center"><a href="http://www.janpn.com/xiandaidushi/" rel="nofollow">现代都市</a></li>
            <li class="col-xs-foot text-center"><a href="http://www.janpn.com/lishijunshi/" rel="nofollow">历史军事</a></li>
            <li class="col-xs-foot text-center"><a href="http://www.janpn.com/youxijingji/" rel="nofollow">游戏竞技</a></li>
            <li class="col-xs-foot text-center"><a href="http://www.janpn.com/kehuanlingyi/" rel="nofollow">科幻灵异</a></li>
            <li class="col-xs-foot text-center"><a href="http://www.janpn.com/nvshengyanqing/" rel="nofollow">女生言情</a></li>
            <li class="col-xs-foot text-center"><a href="http://www.janpn.com/qitaleixing/" rel="nofollow">其他类型</a></li>
        </div>
        <div class="col-xs-12 text-center overlay-close">
            <i class="glyphicon glyphicon-remove"></i>
        </div>
    </div>
</div>
<script src="./《氪无不胜》氪无不胜[TXT小说下载] - 键盘小说网_files/nav.overlay.js.下载"></script>
<!--//手机底部菜单 -->
<script>recordedclick(7349);</script>

</body></html>
