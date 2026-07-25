<?php

namespace Specdocular\LaravelOpenAPI\Builders;

use Specdocular\LaravelOpenAPI\Support\OperationIdGenerator;
use Specdocular\LaravelOpenAPI\Support\RouteInfo;
use Specdocular\LaravelOpenAPI\Support\SummaryGenerator;
use Specdocular\OpenAPI\Schema\Objects\Operation\Operation;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\AvailableOperation;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\HttpMethod;

final readonly class OperationBuilder
{
    public function __construct(
        private TagBuilder $tagBuilder,
        private ParametersBuilder $parametersBuilder,
        private RequestBodyBuilder $requestBodyBuilder,
        private ResponsesBuilder $responsesBuilder,
        private ExternalDocumentationBuilder $externalDocumentationBuilder,
        private CallbackBuilder $callbackBuilder,
        private SecurityBuilder $securityBuilder,
        private ServerBuilder $serverBuilder,
        private ExtensionBuilder $extensionBuilder,
        private OperationIdGenerator $operationIdGenerator,
        private SummaryGenerator $summaryGenerator,
    ) {
    }

    public function build(RouteInfo $routeInfo): AvailableOperation
    {
        $operation = Operation::create();
        $attribute = $routeInfo->operationAttribute();

        $operation = $operation->operationId($this->operationIdGenerator->resolve($routeInfo));

        $explicitSummary = $attribute?->summary;
        $operation = $operation->summary(
            filled($explicitSummary) ? $explicitSummary : $this->summaryGenerator->generate($routeInfo),
        );

        if (!is_null($attribute)) {
            if (filled($attribute->description)) {
                $operation = $operation->description($attribute->description);
            }
            if (!is_null($attribute->requestBody)) {
                $operation = $operation->requestBody($this->requestBodyBuilder->build($attribute->requestBody));
            }
            if (!is_null($attribute->responses)) {
                $operation = $operation->responses($this->responsesBuilder->build($attribute->responses));
            }
            if (!is_null($attribute->externalDocs)) {
                $operation = $operation->externalDocs(
                    $this->externalDocumentationBuilder->build($attribute->externalDocs),
                );
            }
            if (filled($attribute->security)) {
                $operation = $operation->security($this->securityBuilder->build($attribute->security));
            }
            if (true === $attribute->deprecated) {
                $operation = $operation->deprecated();
            }
            $operation = $operation->tags(...$this->tagBuilder->build(...$attribute->getTags()));
            $operation = $operation->callbacks(...$this->callbackBuilder->build(...$attribute->getCallbacks()));
            $operation = $operation->servers(...$this->serverBuilder->build(...$attribute->getServers()));
            $operationParams = $this->parametersBuilder->buildForOperation($attribute->parameters);
            if (!is_null($operationParams)) {
                $operation = $operation->parameters($operationParams);
            }
        }
        $operation = $this->extensionBuilder->build($operation, $routeInfo->extensionAttributes());

        return AvailableOperation::create(
            HttpMethod::from($routeInfo->method()),
            $operation,
        );
    }
}
