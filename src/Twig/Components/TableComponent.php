<?php
// src/Twig/Components/TableComponent.php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('table')]
class TableComponent
{
    public array $headers = [];
    public array $rows = [];
}
