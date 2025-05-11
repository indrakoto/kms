@extends('layouts.app')

@section('title', 'KMS Migas')
@section('body-class', 'index-page')

@section('content')
  @include('section.slider')
  @include('section.about')
  @include('section.analisis')
  @include('section.knowledge')
@endsection
