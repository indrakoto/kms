@extends('layouts.app')

@section('title', 'KMS - Analisis')

@section('content')
  
  <section id="analisis" class="analisis section">
    @include('section.page-title')
    
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="mb-4">
            <div class="list-group" style="border-radius: 0;">
              <a href="{{ route('analisis.index') }}" 
                class="list-group-item list-group-item-action {{ !$activeAnalisis ? 'active-analisis' : '' }}">
                Semua Analisis
              </a>
              @foreach($analisisList as $item)

                <a 
                  href="{{ route('detail.show', ['article_slug' => $item->slug, 'id' => $item->id]) }}" 
                  class="list-group-item list-group-item-action {{ $activeAnalisis == $item->id ? 'active' : '' }}" >
                  {{ $item->title }} 
                </a>
              @endforeach
            </div>
          </div>
          <div class="mb-4">
            <div class="list-group" style="border-radius: 0;">
              <a href="#" class="list-group-item list-group-item-action active-analisis">
                Layanan Publik
              </a>
              @foreach($layananList as $item)
                @if($item->redirect_link==1)
                    <a class="list-group-item list-group-item-action" href="{{ $item->embed_link }}" target="_blank">{{ $item->title }}</a>
                @else
                    <a class="list-group-item list-group-item-action" href="{{ route('detail.show', ['article_slug' => $item->slug, 'id' => $item->id]) }}">{{ $item->title }}</a>
                @endif
              @endforeach
            </div>
          </div>
        </div>

        <div class="col-lg-9">
          <div class="row">
            @foreach($analisisList as $aList)
              <div class="col-lg-4 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="100">
                <div class="analisis-item mb-4">
                  <div class="analisis-content">
                    <img src="{{ asset('img/rectangle-23.png') }}" class="img-fluid" alt="...">
                    <h3 class="mt-3"><a href="{{ route('detail.show', ['article_slug' => $aList->slug, 'id' => $aList->id]) }}">{{ $aList->short_title }}</a></h3>

                                        <div class="box-footer d-flex justify-content-between align-items-center pt-1 pb-1 pr-1 pl-3">
                                            <div class="trainer-profile d-flex align-items-center">
                                              <!-- isi dengan institusi -->
                                            </div>
                                            <div class="trainer-rank d-flex align-items-center">
                                                <i class="bi bi-eye eye-icon"></i>&nbsp;0
                                                &nbsp;&nbsp;
                                                <i class="bi bi-star-fill start-icon" style="color:rgb(233, 187, 89);"></i>&nbsp;0
                                            </div>
                                        </div>  
                  </div>
                </div>
              </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-4">
                
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
