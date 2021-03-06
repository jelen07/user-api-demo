<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Parsedown as Parsedown;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomepageController.
 */
class HomepageController extends Controller
{
    /**
     * @Route("/", name="index")
     *
     * @return Response
     */
    public function default(): Response
    {
        $parser = new Parsedown();
        $parser->setSafeMode(true)
            ->setMarkupEscaped(true);
        $readme = $parser->parse(file_get_contents(__DIR__.'/../../README.md'));

        return $this->render('homepage/default.html.twig', [
            'readme' => $readme,
        ]);
    }
}
