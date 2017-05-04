<?php

require __DIR__ . '/../vendor/autoload.php';

// header('Content-Type: text/xml');

$output =   '<?xml version="1.0" encoding="UTF-8"?>' .
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' .
            '<url>' .
                '<loc>https://glossz.whotofollow.co/</loc>' .
            '</url>';

$container = $app->getContainer();

$glossaryModel = new \Glossz\Model\Glossary($container['db']);
$userModel = new \Glossz\Model\User($this['db']);

$glossaries = $glossaries->listAll();
$users = $users->listAll();

$glossaries = $glossaries->getValues();
$users = $users->getValues();

foreach ($glossaries as $key => $glossary) {
    $output .=  '<url>' .
                    '<loc>https://glossz.whotofollow.co/glossary/' . $glossary['id'] . '</loc>' .
                    '<lastmod>' . $glossary['updated_at'] ? $glossary['updated_at'] : $glossary['created_at'] . '</lastmod>' .
                '</url>';
}

foreach ($users as $key => $user) {
    $output .=  '<url>' .
                    '<loc>https://glossz.whotofollow.co/user/' . $user['id'] . '</loc>' .
                    '<lastmod>' . $user['updated_at'] ? $user['updated_at'] : $user['created_at'] . '</lastmod>' .
                '</url>';
}


$output .=  '</urlset>';

print($output);

?>