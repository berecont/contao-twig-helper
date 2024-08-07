<?php

// src/Twig/AppExtension.php
// templates/theme/rsce_packagelist.html.twig

namespace App\Twig;

use Contao\FilesModel;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters():array
    {
        return [
            new TwigFilter('contao_find_file_by_uuid', [$this, 'findFileByUuid']),
        ];
    }

    public function findFileByUuid($uuid)
    {
        $fileModel = FilesModel::findByUuid($uuid);
        return $fileModel ? $fileModel->path : null;
    }   
}
