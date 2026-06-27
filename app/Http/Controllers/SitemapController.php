<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $siteUrl = rtrim(config('tract.website'), '/');
        $posts = Post::published()->latest('published_at')->get();
        $services = Service::where('is_active', true)->whereNotNull('slug')->get();

        $entries = [
            [$siteUrl.'/', now()->toAtomString(), 'weekly', '1.0'],
            [$siteUrl.'/services', now()->toAtomString(), 'weekly', '0.9'],
            [$siteUrl.'/blog', now()->toAtomString(), 'daily', '0.9'],
        ];

        foreach ($services as $service) {
            $entries[] = [
                $siteUrl.'/services/'.$service->slug,
                $service->updated_at->toAtomString(),
                'monthly',
                '0.85',
            ];
        }

        foreach ($posts as $post) {
            $entries[] = [
                $siteUrl.'/blog/'.$post->slug,
                $post->updated_at->toAtomString(),
                'monthly',
                '0.8',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($entries as [$loc, $lastmod, $changefreq, $priority]) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$loc}</loc>\n";
            $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
            $xml .= "    <changefreq>{$changefreq}</changefreq>\n";
            $xml .= "    <priority>{$priority}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
