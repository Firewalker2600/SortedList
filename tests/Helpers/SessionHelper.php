<?php

namespace App\Tests\Helpers;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

trait SessionHelper
{
    public function createSession(KernelBrowser $client, $options = []): Session
    {
        $container = $client->getContainer();

        $session = $container->get('session.factory')->createSession();
        if($options !== []) {
            foreach ($options as $key => $value)
            {
                $session->set($key, $value);
            }

        }
        $session->start();
        $session->save();

        $sessionCookie = new Cookie(
            $session->getName(),
            $session->getId(),
            null,
            null,
            'localhost',
        );
        $client->getCookieJar()->set($sessionCookie);

        return $session;
    }
}
