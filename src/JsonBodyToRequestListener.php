<?php declare(strict_types=1);

namespace GW\SymfonyJsonRequest;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use function is_array;
use function is_string;
use function method_exists;
use function Safe\json_decode;

final class JsonBodyToRequestListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $contentType = null;

        // https://github.com/symfony/symfony/commit/57b24fec9627045e827883d4a501691d2d6976fe
        // could be dropped after drop support for symfony 6.x

        if (method_exists($request, 'getContentType')) {
            $contentType = $request->getContentType();
        }

        if (method_exists($request, 'getContentTypeFormat')) {
            $contentType = $request->getContentTypeFormat();
        }

        if ($contentType !== 'json' || !$event->isMainRequest()) {
            return;
        }

        $content = $request->getContent();

        if (!is_string($content) || $content === '') {
            return;
        }

        $data = json_decode($content, true);

        if (is_array($data)) {
            $request->request->replace($data);
        }
    }
}
