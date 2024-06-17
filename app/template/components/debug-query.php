<div class="card text-white bg-dark m-4 d-print-none">
    <div class="card-body d-flex">

        <i class="fa-solid fa-bug fa-4x mt-4" aria-hidden="true"></i>

        <div class="ms-4">

            <h5 class="card-title"><i class="fa-solid fa-arrow-right me-2" aria-hidden="true"></i> Requête</h5>

            <table class="table table-sm table-secondary" aria-label="Données de la requête">
                <tr>
                    <th scope="row">Requête SQL</th>
                    <td><code><?= $query ?></code></td>
                </tr>
                <?php if ($className) : ?>
                    <tr>
                        <th scope="row">Entité à instancier</th>
                        <td><code><?= $className ?></code></td>
                    </tr>
                <?php endif ?>
                <?php if (!empty($values)) : ?>
                    <tr>
                        <th scope="row">Valeurs</th>
                        <td>
                            <pre class="bg-light px-2"><?php dump($values) ?></pre>
                        </td>
                    </tr>
                <?php endif ?>
            </table>
