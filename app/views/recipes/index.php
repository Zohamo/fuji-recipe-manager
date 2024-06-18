<?php

/** @var \App\Entities\Recipe[] $recipes */
$props = ["Label", "FilmSimulation", "MonochromaticColor_RG", "GrainEffect", "GrainEffectSize", "ChromeEffect", "ColorChromeBlue", "WhiteBalance", "WBShiftR", "WBShiftB", "DynamicRange", "HighlightTone", "ShadowTone", "Color", "Sharpness", "NoisReduction", "Clarity"];
// dump($recipes['Aerocolor Lomo.FP1']);
?>
<div class="container-fluid">
    <div class="data-table-container mb-3">
        <div class="table-responsive bg-light p-3 shadow">
            <table class="data-table table table-sm table-bordered table-hover align-middle" id="recipeTable" aria-label="Recipe list">
                <thead>
                    <tr>
                        <td></td>
                        <th colspan="2" class="text-center text-muted text-uppercase">Film</th>
                        <th colspan="2" class="text-center text-muted text-uppercase">Grain</th>
                        <th colspan="2" class="text-center text-muted text-uppercase">Effects</th>
                        <th colspan="3" class="text-center text-muted text-uppercase">White Balance</th>
                        <th class="text-center text-muted text-uppercase">Dyn.</th>
                        <th colspan="2" class="text-center text-muted text-uppercase">Tone</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="col">Label</th>
                        <th scope="col">Simulation</th>
                        <th scope="col">Mono. Col.</th>
                        <th scope="col">Effect</th>
                        <th scope="col">Size</th>
                        <th scope="col">Chr.FX</th>
                        <th scope="col">Chr.FX Blue</th>
                        <th scope="col">Mode/Temp.</th>
                        <th scope="col">Red</th>
                        <th scope="col">Blue</th>
                        <th scope="col">Range</th>
                        <th scope="col">High.</th>
                        <th scope="col">Shad.</th>
                        <th scope="col">Color</th>
                        <th scope="col">Sharp.</th>
                        <th scope="col">Noise Red.</th>
                        <th scope="col">Clarity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recipes as $fileName => $recipe) : ?>
                        <tr id="<?= $fileName ?>">
                            <?php foreach ($props as $i => $prop) : ?>
                                <?php if ($i === 0) : ?>
                                    <th scope="row"><?= $recipe->$prop ?></th>
                                <?php else : ?>
                                    <td><?= $recipe->$prop ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
