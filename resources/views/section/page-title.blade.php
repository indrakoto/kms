<div class="page-title" data-aos="fade">
  <div class="container">
    <div class="page-title__wrapper">
      <!-- Breadcrumb -->
      <nav class="breadcrumbs">
        <ol>
          <li><a href="/">Beranda</a></li>
          <li><a href="/knowledge">Knowledge</a></li>
          @php
          if(isset($article->title)) {
            $title = '<li>'.$article->title.'</li>';
          } else if(isset($institusi->name)) {
            $title = '<li>'.$institusi->name.'</li>';
          } else {
            $title = "";
          }
          @endphp
          {!! $title !!}
        </ol>
      </nav>
    </div>
  </div>
</div>