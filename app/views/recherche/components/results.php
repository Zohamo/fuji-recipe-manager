<div class="card shadow mb-3">
    <div class="card-header bg-secondary text-white">
        <h3 class="card-title mb-0"><?= alias($categoryName, $categoryName . "s") ?> <small><em>(<?= count($categoryResults) ?>)</em></small></h3>
    </div>

    <div class="card-body py-0 table-responsive">
        <table class="table table-sm table-hover">
            <caption class="sr-only">Résultats de la recherche de <?= $categoryName ?></caption>
            <thead>
                <?php foreach (array_keys(get_object_vars($categoryResults[0])) as $field) : ?>
                    <th scope="col"><?= alias($categoryName, $field) ?></th>
                <?php endforeach ?>
            </thead>
            <tbody>
                <?php foreach ($categoryResults as $result) : ?>
                    <tr>
                        <?php foreach (get_object_vars($categoryResults[0]) as $value) : ?>
                            <td><?= $value ?></td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
