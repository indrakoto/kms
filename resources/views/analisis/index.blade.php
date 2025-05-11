@extends('layouts.app')

@section('title', 'KMS - Analisis')

@section('content')
  <section id="courses" class="courses section">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="list-group">
            
            @foreach($analisisList as $analisis)
              <a 
                href="{{ route('analisis.show', $analisis) }}" 
                class="list-group-item list-group-item-action {{ $activeAnalisis == $analisis->id ? 'active' : '' }}" >
                {{ $analisis->name }} 
              </a>
            @endforeach
          </div>
        </div>

        <div class="col-lg-9">
          <div class="row">
            @if($activeAnalisis)
              <h3>Analisis: {{ $analisisList->find($activeAnalisis)->name }}</h3>
            @else
                <h4>Analisis</h4>
            @endif

            <!-- Daftar Neraca -->
            @foreach($neracas as $neraca)
              <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="100">
                <div class="course-item mb-4">
                  <div class="course-content">
                    <img src="{{ asset('img/rectangle-23.png') }}" class="img-fluid" alt="...">
                    <h3 class="mt-4"><a href="{{ route('analisis.show', $neraca) }}">{{ $neraca->name }}</a></h3>
                    <small class="text-muted">
                        Kategori: {{ $neraca->analisis->name }}
                    </small>
                  </div>
                </div>
              </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-4">
                {{ $neracas->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
