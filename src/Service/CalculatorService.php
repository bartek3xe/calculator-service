<?php

namespace App\Service;

use App\DBAL\Type\OperatorType;
use Psr\Log\LoggerInterface;

readonly class CalculatorService
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function calculate(string $operator, int $firstNumber, int $secondNumber, &$message = ''): ?int
    {
        $this->validateOperator($operator);

        $this->logger->info('Called the calculate method properly', [
            'operator' => $operator,
            'operand1' => $firstNumber,
            'operand2' => $secondNumber,
        ]);

        if ($operator === OperatorType::DIVIDE_OPERATOR && (!$firstNumber || !$secondNumber)) {
            $message = 'Division by zero is not allowed';
            $this->logger->info($message);

            return null;
        }

        return match ($operator) {
            OperatorType::PLUS_OPERATOR     => $this->add($firstNumber, $secondNumber),
            OperatorType::MINUS_OPERATOR    => $this->deduct($firstNumber, $secondNumber),
            OperatorType::DIVIDE_OPERATOR   => $this->divide($firstNumber, $secondNumber),
            OperatorType::MULTIPLY_OPERATOR => $this->multiply($firstNumber, $secondNumber),
            default => null,
        };

        if (!$result) {
            $this->logger->info('Invalid operator ' . $operator);
        }

        return $result;
    }

    private function add(int $operand1, int $operand2): int
    {
        return $operand1 + $operand2;
    }

    private function deduct(int $operand1, int $operand2): int
    {
        return $operand1 - $operand2;
    }

    private function divide(int $operand1, int $operand2): int
    {
        return $operand1 / $operand2;
    }

    private function multiply(int $operand1, int $operand2): int
    {
        return $operand1 * $operand2;
    }
}
