@extends('janpa.layouts.app')
@section('title',$navname.'小说,'.$navname.'[TXT小说下载]-鼠标小说网')
@section('description',$navname.'小说,'.$navname.'[TXT小说下载]-鼠标小说网')
@section('keywords',$navname.'小说,'.$navname.'[TXT小说下载]-鼠标小说网')

@section('content')
    <div class="clear"></div>
    <div class="copyright_list"></div>
    <div class="titleh_list">{{$navname}}小说</div>
    <div class="list">
        @foreach($novel as $item)
            <a title="{{$item->name}}" class="shop" href="http://{{$item->enname}}.{{$host}}">
                <div class="shop-info">
                    <b>《{{$item->name}}》</b>
                </div>
                <div class="shop-info">
                    {{$item->author}} [著]
                </div>
                <div class="shop-info">
                    <span class="glyphicon glyphicon-bullhorn"> {{$item->new_chapter_name}}</span>
                </div>
            </a>
        @endforeach
    </div>
    <div class="clear"></div>
    <div class="text-center">
        {{ $novel->links() }}
    </div>
@endsection