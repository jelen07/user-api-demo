<?php

namespace App\Controller;

use Nette\Utils\FileSystem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Parsedown as Parsedown;
use Symfony\Component\Finder\Finder;

class HomepageController extends Controller
{
    public function actionDefault()
    {
        $parser = new Parsedown();
        $parser->setSafeMode(true)
            ->setMarkupEscaped(true);
        $readme = $parser->parse(file_get_contents(__DIR__ . '/../../README.md'));

        return $this->render('homepage/run.html.twig', [
            'readme' => $readme,
        ]);
    }
}
