<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LocaleRedirectController extends AbstractController
{
    public function redirectToLocale(Request $request): RedirectResponse
    {
        // Get preferred language from browser (Accept-Language header)
        $preferredLanguage = $request->getPreferredLanguage(['en', 'fr']);

        // Default to 'en' if no preference detected
        $locale = $preferredLanguage ?: 'en';

        // Redirect to home page with detected locale
        return $this->redirectToRoute('home', ['_locale' => $locale]);
    }
}
