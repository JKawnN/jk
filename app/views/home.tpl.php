<section class="py-5 text-center container white-to-dark">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light text-dark-to-white">JKawn's Website</h1>
        <p class="lead text-muted">Site  purement experimental, ci-dessous plusieurs tests affichés par ordre chronologique inverse</p>
        <p>
          <a href="#" class="btn btn-primary my-2">Main call to action</a>
          <a href="#" class="btn btn-secondary my-2">Secondary action</a>
        </p>
      </div>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <div class="col">
          <div class="card shadow-sm card-border-white-to-dark">
            <img class="card-images" src="<?= $viewData['urlPrefix'] ?>/assets/images/articles_images/drumkit.jpg" alt="">

            <div class="card-body white-to-dark ">
              <p class="card-text text-dark-to-white">Faire de la batterie avec ses touches de clavier? C'est possible !</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="<?= $viewData['urlPrefix'] ?>drumkit">
                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>  
                  </a>
                </div>
                <small class="text-muted">9 mins</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>
