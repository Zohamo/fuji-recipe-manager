<div class="bg-white text-secondary shadow-sm py-1 d-print-none" data-test="breadcrumbs">
    <div class="container-fluid">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="<?= url() ?>">
                        <i class="fa-solid fa-home" aria-label="Accueil" aria-hidden="true"></i>
                    </a>
                </li>
                <?php if (!empty($breadcrumbs)) : ?>
                    <?php foreach ($breadcrumbs as $ii => $breadcrumb) : ?>
                        <li class="breadcrumb-item">
                            <a href="<?= url() . "/" . $breadcrumb['url'] ?>">
                                <?= $breadcrumb['title'] ?>
                            </a>
                        </li>
                    <?php endforeach ?>
                <?php endif ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <?= $title ?: "Accueil" ?>
                </li>
            </ol>
        </nav>
    </div>
</div>
