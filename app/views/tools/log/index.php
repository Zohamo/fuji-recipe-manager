<div class="container-fluid">

    <div class="d-lg-flex justify-content-between align-items-center">
        <h1 class="page-title">
            <i class="fa-solid fa-triangle-exclamation me-2" aria-hidden="true"></i> <?= $title ?>
        </h1>
    </div>

    <ul class="nav nav-tabs nav-fill nav-tabs-persistent" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="db-tab" data-bs-toggle="tab" data-bs-target="#db-tab-pane" type="button" role="tab" aria-controls="db-tab-pane" aria-selected="true">
                <i class="fa-solid fa-database me-1" aria-hidden="true"></i> Base de données
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files-tab-pane" type="button" role="tab" aria-controls="files-tab-pane" aria-selected="false">
                <i class="fa-solid fa-file-waveform me-1" aria-hidden="true"></i> Fichiers
            </button>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="db-tab-pane" role="tabpanel" aria-labelledby="db-tab" tabindex="0">
            <div class="data-table-container mb-3">
                <div class="table-responsive bg-light p-3 shadow">
                    <table class="data-table table table-sm table-bordered table-hover align-middle" aria-label="Liste des <?= $title ?>">
                        <thead>
                            <tr>
                                <th scope="col"><?= alias("log", "log_date") ?></th>
                                <th scope="col"><?= alias("log", "log_uti_compte_ldap") ?></th>
                                <th scope="col"><?= alias("log", "log_code") ?></th>
                                <th scope="col">Erreur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log) : ?>
                                <tr>
                                    <td><?= str_replace(" ", "&nbsp;", formatDatetime($log->log_date)) ?></td>
                                    <td>
                                        <?= strtoupper($log->uti_nom) ?>&nbsp;<?= $log->uti_prenom ?><br />
                                        <?= $log->log_uti_compte_ldap ?>
                                    </td>
                                    <td class="text-center"><?= $log->log_code ?></td>
                                    <td>
                                        <?= str_replace(env("APP_ROOT"), "", $log->log_file) ?>::ligne <?= formatNumber($log->log_line) ?>
                                        <small class="text-muted"><?= $log->log_message ?></small>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="files-tab-pane" role="tabpanel" aria-labelledby="files-tab" tabindex="1">
            <div class="d-flex">
                <div class="p-3">
                    <ul class="nav nav-pills flex-column">
                        <?php foreach ($files as $ii => $filename) : ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="file-<?= $ii ?>-tab" data-bs-toggle="tab" data-bs-target="#file-<?= $ii ?>-tab-pane" type="button" data-loaded="false" data-index="<?= $ii ?>" data-filename="<?= $filename ?>">
                                    <?= $filename ?>
                                </button>
                                <a class="nav-link" href="#"></a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <div class="tab-content">
                    <?php foreach ($files as $ii => $filename) : ?>
                        <div class="tab-pane fade p-3" id="file-<?= $ii ?>-tab-pane" role="tabpanel" aria-labelledby="file-<?= $ii ?>-tab" tabindex="<?= $ii ?>">
                            <?php spinner() ?>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(function() {
        /**
         * Charge et affiche le contenu des fichiers
         */
        $("[data-loaded]").on("click", function() {
            const $btn = $(this);
            if ($btn.data("loaded")) {
                return;
            }
            $.get(appUrl + "/tools/logs/files/" + $btn.data("filename"), function(data) {
                $(`#file-${$btn.data("index")}-tab-pane`).html("<samp>" + data.replaceAll("\n", "<br />") + "</samp>");
                $btn.data("loaded", true);
            });
        });
    })
</script>
