<div class="page-title" data-aos="fade">
  <div class="container">
    <div class="page-title__wrapper">
      <!-- Breadcrumb -->
      <nav class="breadcrumbs">
        <ol>
          <li><a href="/">Beranda</a></li>
          <li><a href="/knowledge">Knowledge</a></li>
          <li>{{ $article->title }}</li>
        </ol>
      </nav>
      
      <!-- Search Form -->
      <form class="page-title__search" action="/search" method="GET">
        <div class="page-title__search-group">
          <input 
            type="text" 
            class="page-title__search-input" 
            placeholder="Search..." 
            name="q"
            aria-label="Search articles"
          >
          <button class="page-title__search-btn" type="submit" aria-label="Submit search">
            Search
          </button>
        </div>
      </form>
    </div>
  </div>
</div>