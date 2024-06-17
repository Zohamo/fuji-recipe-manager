<div class="d-flex align-items-center">
    <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseResultat" aria-expanded="false" aria-controls="collapseResultat">
        <i class="fa-solid fa-arrow-left me-2" aria-hidden="true"></i> Résultat
    </button>
    <em class="small ms-2">Temps d'exécution&nbsp;:
        <?php foreach (formatTime($time) as $type => $value) : ?>
            <?php if ($value) : ?>
                <?= $value . $type ?>
            <?php endif ?>
        <?php endforeach ?>
    </em>
</div>

<div class="collapse mt-3" id="collapseResultat">
    <?php dump($result) ?>
</div>

</div>

</div>
</div>
