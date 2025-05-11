    <!-- Hero Section -->
    <section class="sliders">

      <div class="container">
                <div id="imageSlider" class="carousel slide" data-bs-ride="carousel">

                    <!-- Indicators -->
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#imageSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#imageSlider" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#imageSlider" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>

                    <!-- Slides -->
                    <div class="carousel-inner rounded">
                        <div class="carousel-item active">
                          <img src="{{ asset('img/mask-group.png') }}" class="d-block w-100" alt="...">
                          <div class="carousel-caption d-none d-md-block">
                              <h5>Beautiful Mountain</h5>
                              <p>A stunning view of a snow-capped mountain during sunset.</p>
                          </div>
                        </div>
                        <div class="carousel-item">
                          <img src="{{ asset('img/mask-group.png') }}" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                          <img src="{{ asset('img/mask-group.png') }}" class="d-block w-100" alt="...">
                        </div>
                    </div>

                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#imageSlider" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#imageSlider" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
      </div>

    </section>
    <!-- /Hero Section -->