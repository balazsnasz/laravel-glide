<?php

namespace RalphJSmit\Laravel\Glide\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use League\Glide\Filesystem\FileNotFoundException;
use League\Glide\ServerFactory;
use RalphJSmit\Laravel\Glide\Http\Controllers\GlideController\GlideResponseFactory;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GlideController
{
    public function __invoke(Request $request, Application $application, Filesystem $filesystem, string $domainOrSource, ?string $source = null): StreamedResponse
    {
        $source = $source ?? $domainOrSource;
        $disk = $request->query('disk');

        if ($disk && ! config('glide.route.signed')) {
            throw new RuntimeException('Disk parameter requires signed URLs to be enabled in glide config.');
        }

        $server = ServerFactory::create([
            'response' => new GlideResponseFactory($request),
            'source' => glide()->getSourceFilesystem($disk),
            'cache' => glide()->getCachePath(),
            'base_url' => '',
        ]);

        $width = $request->integer('width');

        try {
            return $server->getImageResponse($source, [
                ...$width ? ['w' => $width] : [],
                'fit' => 'crop',
            ]);
        } catch (FileNotFoundException) {
            abort(404);
        }
    }
}
