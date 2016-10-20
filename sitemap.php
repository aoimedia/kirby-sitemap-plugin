<?php

kirby()->routes(array(
  array(
    'pattern' => 'sitemap',
    'action'  => function() {
      return go('sitemap.xml');
    }
  ),
  array(
    'pattern' => 'sitemap.xml',
    'action'  => function() {
      $sitemap = '<?xml version="1.0" encoding="utf-8"?>'. "\n" .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">'. "\n";

      $excluded = kirby()->site()->pages()->index()->filterBy('template', 'in', ['error']);
      $pages = kirby()->site()->pages()->index()->not($excluded);

      foreach($pages as $p) {
        $sitemap .= '<url>' . "\n";
        $sitemap .= '<loc>' . html($p->url()) . '</loc>' . "\n";

        if (kirby()->site()->languages() && kirby()->site()->languages()->count() > 1) {
          foreach (kirby()->site()->languages() as $language) {
            $code = $language->code();
            if ($code != kirby()->site()->defaultLanguage()->code()) {
              $sitemap .= '<xhtml:link rel="alternate" hreflang="' . $code . '" href="' . $p->url($code) . '" />' . "\n";
            }
          }
        }

        $modified = c::get('date.handler') === 'strftime' ? strftime('%F', $p->modified()) : $p->modified('Y-m-d');
        $sitemap .= '<lastmod>' . $modified . '</lastmod>' . "\n";
        $priority = $p->isHomePage() ? 1 : 0.8 / $p->depth();
        $sitemap .= '<priority>' . $priority . '</priority>' . "\n";
        $sitemap .= '</url>' . "\n";
      }
      $sitemap .= '</urlset>';

      return new Response($sitemap, 'xml');
    }
  )
));
