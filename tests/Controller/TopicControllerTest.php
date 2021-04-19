<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\DataProviderTestSuite;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TopicControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/topic/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("h1", 'Topic index');
    }

    /**
     * @dataProvider providerNew
     */
    public function testNew($titre, $description): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/topic/new');

        $form = $crawler->selectButton('Save')->form();
        $form['topic[title]'] = $titre;
        $form['topic[description]'] = $description;
        $crawler = $client->submit($form);

        $this->assertResponseRedirects();

        $client->followRedirect();
        //$this->assertSelectorExists(".alert.alert-success");
    }

    public function providerNew() {
        return [
            ['titre', 'ma description'],
            ['titre 2', 'ma description deuxième'],
        ];
    }

}
