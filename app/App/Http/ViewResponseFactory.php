<?php

namespace App\Http;

use App\FileHelper;
use Symfony\Component\HttpFoundation\Response;

class ViewResponseFactory
{
    private const LAYOUT_VIEW = 'layout';

    public static function createResponse(string $view, array $data = [], int $status = 200, array $headers = []): Response
    {
        $content = static::createView($view, $data);
        $layout = static::createView(static::LAYOUT_VIEW, compact('content'));

        return new Response($layout, $status, $headers);
    }

    private static function createView(string $view, array $data = []): string
    {
        ob_start();
        extract($data);
        require FileHelper::viewPath($view);
        $view = ob_get_contents();
        ob_get_clean();

        return $view;
    }
}