<?php
// src/Twig/Components/Button.php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;

#[AsTwigComponent('button')]
class Button
{
    public string $text = "";
    public string $btnType = "";
    public string $link = "";
    public bool $disabled = false;
}
