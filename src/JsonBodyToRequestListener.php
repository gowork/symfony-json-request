<?php declare(strict_types=1);

namespace GW\SymfonyJsonRequest;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use function is_array;
use function is_string;
use function Safe\json_decode;

final class JsonBodyToRequestListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->getContentType() !== 'json' || !$event->isMainRequest()) {
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
