@extends('janpa.layouts.app')


@section('content')


    @foreach($nav as $key=>$item)
        <!--目录-->
        <div class="clear"></div>
        <div class="copyright_list"></div>
        <div class="titleh_list">{{$item->name}}</div>

        <div class="list">
            @foreach($item->novel as $key1=>$novel)
                <a title="{{$novel->name}}" class="shop" href="http://{{$novel->enname}}.{{$host}}/">
                    <div class="shop-info">
                        <b>《{{$novel->name}}》</b>
                    </div>
                    <div class="shop-info">
                        {{$novel->author}} [著]
                    </div>
                    <div class="shop-info">
                        <span class="glyphicon glyphicon-fire"> 第{{$novel->new_chapter_number}}章 {{$novel->new_chapter_name}}</span>
                    </div>
                </a>
            @endforeach
        </div>
        <!--//目录--><!--目录-->
    @endforeach

@endsection
