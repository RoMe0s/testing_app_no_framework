<?php

namespace App\Validation;

use App\Application;

class Validator
{
    public static function validate(array $data, array $rules, bool $stopOnFirstFail = true): array
    {
        $errors = [];
        foreach ($rules as $attribute => $ruleClasses) {
            $ruleClasses = is_array($ruleClasses) ? $ruleClasses : [$ruleClasses];

            foreach ($ruleClasses as $ruleClass => $validationParameters) {
                if (is_string($validationParameters)) {
                    $ruleClass = $validationParameters;
                    $validationParameters = [];
                }

                if (
                    false === class_exists($ruleClass)
                    || false === is_subclass_of($ruleClass, RuleInterface::class)
                ) {
                    throw new WrongValidationRuleException($ruleClass);
                }

                /** @var RuleInterface $rule */
                $rule = Application::composeClass($ruleClass, $validationParameters);

                if (false === $rule->isValid($attribute, $data)) {
                    $errors[$attribute][] = sprintf($rule->getMessage(), $attribute);

                    if ($stopOnFirstFail) break;
                }
            }
        }
        return $errors;
    }
}