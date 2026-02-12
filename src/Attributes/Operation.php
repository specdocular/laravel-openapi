<?php

namespace Specdocular\LaravelOpenAPI\Attributes;

use Specdocular\LaravelOpenAPI\Contracts\Factories\ExternalDocumentationFactory;
use Specdocular\LaravelOpenAPI\Contracts\Factories\ParametersFactory;
use Specdocular\LaravelOpenAPI\Contracts\Factories\ResponsesFactory;
use Specdocular\LaravelOpenAPI\Contracts\Factories\SecurityFactory;
use Specdocular\LaravelOpenAPI\Contracts\Factories\ServerFactory;
use Specdocular\LaravelOpenAPI\Contracts\Factories\TagFactory;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\CallbackFactory;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\RequestBodyFactory;

#[\Attribute(\Attribute::TARGET_METHOD)]
final readonly class Operation
{
    /**
     * @param class-string<TagFactory>|array<array-key, class-string<TagFactory>>|null $tags
     * @param class-string<ParametersFactory>|null $parameters
     * @param class-string<RequestBodyFactory>|null $requestBody
     * @param class-string<ResponsesFactory>|null $responses
     * @param class-string<ExternalDocumentationFactory>|null $externalDocs
     * @param class-string<CallbackFactory>|array<array-key, class-string<CallbackFactory>>|null $callbacks
     * @param class-string<SecurityFactory>|null $security
     * @param class-string<ServerFactory>|array<array-key, class-string<ServerFactory>>|null $servers
     */
    public function __construct(
        private string|array|null $tags = null,
        public string|null $summary = null,
        public string|null $description = null,
        public string|null $parameters = null,
        public string|null $requestBody = null,
        public string|null $responses = null,
        public string|null $externalDocs = null,
        public string|array|null $callbacks = null,
        public bool|null $deprecated = null,
        public string|null $security = null,
        private string|array|null $servers = null,
        public string|null $operationId = null,
    ) {
    }

    /**
     * @return array<array-key, class-string<TagFactory>>
     */
    public function getTags(): array
    {
        if (is_string($this->tags)) {
            return [$this->tags];
        }

        return when(blank($this->tags), [], $this->tags);
    }

    /**
     * @return array<array-key, class-string<ServerFactory>>
     */
    public function getServers(): array
    {
        if (is_string($this->servers)) {
            return [$this->servers];
        }

        return when(blank($this->servers), [], $this->servers);
    }

    /**
     * @return array<array-key, class-string<CallbackFactory>>
     */
    public function getCallbacks(): array
    {
        if (is_string($this->callbacks)) {
            return [$this->callbacks];
        }

        return when(blank($this->callbacks), [], $this->callbacks);
    }
}
