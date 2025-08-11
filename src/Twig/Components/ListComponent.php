<?php
// src/Twig/Components/ListComponent.php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('list')]
class ListComponent
{
    public array $data = [];
}
