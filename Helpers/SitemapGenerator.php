<?php

namespace Glossz\Helpers;

//======================================================================
// Sitemap Generator: Dynamically generates an xml sitemap based on glossaries/users
//
//      Functions: construct($users, $glossaries)     - Sets the users and glossaries
//                 invoke()                           - Generates and returns the sitemap content
//======================================================================

class SitemapGenerator {

    protected $users;
    protected $glossaires;

    public function __construct($users, $glossaires) {
        $this->users = $users;
        $this->glossaries = $glossaires;
    }

    public function __invoke() {
        $output =   '<?xml version="1.0" encoding="UTF-8"?>' .
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' .
            '<url>' .
                '<loc>https://glossz.whotofollow.co/</loc>' .
            '</url>';

        foreach ($this->glossaries as $key => $glossary) {
            $output .=  '<url>' .
                            '<loc>https://glossz.whotofollow.co/glossary/' . $glossary['id'] . '</loc>' .
                            '<lastmod>' . ($glossary['updated_at'] ? $glossary['updated_at'] : $glossary['created_at']) . '</lastmod>' .
                        '</url>';
        }

        foreach ($this->users as $key => $user) {
            $output .=  '<url>' .
                            '<loc>https://glossz.whotofollow.co/user/' . $user['id'] . '</loc>' .
                            '<lastmod>' . ($user['updated_at'] ? $user['updated_at'] : $user['created_at']) . '</lastmod>' .
                        '</url>';
        }

        $output .=  '</urlset>';

        return $output;
    }
}