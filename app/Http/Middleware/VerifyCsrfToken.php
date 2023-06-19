<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'bookmarktoggle',
        'createandredirectchat',
        'api/filterelements',
        'api/searchinfilled',
        'api/get_attributes',
        'api/imageupload/*',
        'api/imagedelete/*',
        'imageupload/*',
        'imagedelete/*',
        '/notreadedmessages',
        '/api/deleteservice',
        '/deleteservice'
    ];
}
