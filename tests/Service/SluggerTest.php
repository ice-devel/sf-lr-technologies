<?php

namespace App\Tests\Service;

use App\Service\Slugger;
use PHPUnit\Framework\TestCase;

class SluggerTest extends TestCase
{
    public function testSlug(): void
    {
        $titre = "Le titre à slugger !";
        $slugger = new Slugger();
        $slug = $slugger->slug($titre);

        $this->assertEquals('le-titre-a-slugger', $slug);
    }

    public function testNASlug(): void
    {
        $titre = "";
        $slugger = new Slugger();
        $slug = $slugger->slug($titre);

        $this->assertEquals('n-a', $slug);
    }
}
