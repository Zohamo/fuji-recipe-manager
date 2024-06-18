<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow" role="navigation">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= url() ?>">
            <i class="fa-solid fa-photo-film me-2" aria-hidden="true"></i>
            <span><?= env("APP_TITLE") ?></span>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Ouvrir/fermer le menu de navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="flex-shrink-0 ms-auto d-md-flex align-items-center">
                <!-- Recherche -->
                <form class="form-horizontal form-recherche mb-0" method="POST" action="<?= url() ?>/recherche" role="form">
                    <div class="nav-search my-3 my-md-0 mx-lg-3">
                        <label for="recherche" class="sr-only form-label">Recherche</label>
                        <div class="input-group">
                            <input type="search" class="form-control form-control-sm" minlength="3" id="search" name="search" placeholder="Rechercher&hellip;" aria-label="Recherche" />
                            <button type="submit" class="btn btn-dark" aria-label="Rechercher">
                                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</nav>
