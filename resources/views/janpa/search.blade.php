@section('title','搜索结果-鼠标小说网')
@section('description','搜索结果-鼠标小说网')
@section('keywords','搜索结果-鼠标小说网')

@extends('janpa.layouts.app')

@section('content')

    <div class="list">
        @foreach($novel as $key1=>$item)
            <a title="{{$item->name}}" class="shop" href="http://{{$item->enname}}.{{$host}}/">
                <div class="shop-info">
                    <b>《{{$item->name}}》</b>
                </div>
                <div class="shop-info">
                    {{$item->author}} [著]
                </div>
                <div class="shop-info">
                    <span class="glyphicon glyphicon-fire"> 第{{$item->new_chapter_number}}章 {{$item->new_chapter_name}}</span>
                </div>
            </a>
        @endforeach
    </div>
    @endsection