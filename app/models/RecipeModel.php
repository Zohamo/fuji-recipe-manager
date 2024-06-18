<?php

namespace App\Models;

use App\Entities\Recipe;
use App\Functions\DirectoryUtils;

class RecipeModel
{
    /**
     * Returns the list of the *.FP1 files in the FUJI_FP1_DIR directory.
     *
     * @see .env
     * @return Recipe[]
     */
    public function all()
    {
        $fp1List = DirectoryUtils::listContent(env("FUJI_FP1_DIR"));
        $arr = [];
        foreach ($fp1List as $fileName) {
            $xml = file_get_contents(env("FUJI_FP1_DIR") . "\\" . $fileName);
            if ($xml) {
                $arr[$fileName] = (new Recipe)->hydrateFromXml($xml);
            }
        }
        return $arr;
    }
}
