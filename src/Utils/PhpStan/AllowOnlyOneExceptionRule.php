<?php

declare(strict_types=1);

namespace Utils\PhpStan;

use Exception;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;
use ReflectionClass;
use ReflectionException;

/**
 * @implements Rule<Node\Stmt\Class_>
 */
final class AllowOnlyOneExceptionRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Stmt\Class_::class;
    }

    /**
     * @throws ShouldNotHappenException
     * @throws ReflectionException
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (isset($node->name) && 'DetailedException' === $node->name->name) {
            return [];
        }

        if (null === $node->extends) {
            return [];
        }

        // @phpstan-ignore-next-line
        $reflection = new ReflectionClass($node->extends->name);
        if (!$reflection->isInstance(new Exception())) {
            return [];
        }

        return [
            RuleErrorBuilder::message('Can extend only from DetailedException.')
                ->identifier('DetailedException.Exception')
                ->build(),
        ];
    }
}
