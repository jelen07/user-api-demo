<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    public function actionDefault()
    {
        return $this->render('homepage/run.html.twig');
    }
}
