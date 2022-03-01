<?php

declare(strict_types=1);

namespace App\Controller;

use App\Config\RouteName;
use App\Contract\AbstractNftController;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route(
    '/',
    name: RouteName::ROOT,
)]
final class RootController extends AbstractNftController
{
    public function __invoke(): Response
    {
        $websiteUrl = $this->getParameter('app.collection_website');

        if (! is_string($websiteUrl)) {
            throw new RuntimeException('Invalid collection website.');
        }

        return $this->redirect($websiteUrl);
    }
}
