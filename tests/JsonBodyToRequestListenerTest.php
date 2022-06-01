<?php

namespace tests\GW\SymfonyJsonRequest;

use GW\SymfonyJsonRequest\JsonBodyToRequestListener;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class JsonBodyToRequestListenerTest extends TestCase
{
    function test_converts_json_body_to_request_array(): void
    {
        $listener = new JsonBodyToRequestListener();
        $request = new Request([], [], [], [], [], ['HTTP_CONTENT_TYPE' => 'application/json'], '{"foo":1, "bar":2}');
        $event = $this->createEvent($request);
        $listener->onKernelRequest($event);
        Assert::assertEquals($request->request->all(), ['foo' => 1, 'bar' => 2]);
    }

    function test_does_not_converts_json_body_to_request_array_if_content_type_not_json(): void
    {
        $listener = new JsonBodyToRequestListener();
        $request = new Request([], [], [], [], [], [], '{"foo":1, "bar":2}');
        $event = $this->createEvent($request);
        $listener->onKernelRequest($event);
        Assert::assertEquals($request->request->all(), []);
    }

    function test_does_not_converts_json_body_to_request_array_if_content_is_empty(): void
    {
        $listener = new JsonBodyToRequestListener();
        $request = new Request([], [], [], [], [], ['HTTP_CONTENT_TYPE' => 'application/json'], '');
        $event = $this->createEvent($request);
        $listener->onKernelRequest($event);
        Assert::assertEquals($request->request->all(), []);
    }

    function test_does_not_converts_json_body_to_request_array_for_sub_request(): void
    {
        $listener = new JsonBodyToRequestListener();
        $request = new Request([], [], [], [], [], ['HTTP_CONTENT_TYPE' => 'application/json'], '{"foo":1, "bar":2}');
        $event = $this->createEvent($request, HttpKernelInterface::SUB_REQUEST);
        $listener->onKernelRequest($event);
        Assert::assertEquals($request->request->all(), []);
    }

    private function createEvent(Request $request, int $type = HttpKernelInterface::MAIN_REQUEST): RequestEvent
    {
        return new RequestEvent($this->mockKernel(), $request, $type);
    }

    private function mockKernel(): HttpKernelInterface
    {
        return new class implements HttpKernelInterface {
            public function handle(Request $request, int $type = self::MAIN_REQUEST, bool $catch = true): Response
            {
                return new Response();
            }
        };
    }
}
