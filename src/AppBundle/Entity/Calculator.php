<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Operation\Add;
use AppBundle\Entity\Operation\Divide;
use AppBundle\Entity\Operation\Multiply;
use AppBundle\Entity\Operation\Subtract;
use Symfony\Component\Validator\Constraints as Assert;

class Calculator
{
    /**
     * @Assert\NotEqualTo("0")
     */
    public $expresion;

    /**
     * @Assert\Type("integer")
     * @Assert\NotEqualTo("0")
     */
    public $firstNumber;

    /**
     * @Assert\Type("integer")
     * @Assert\NotEqualTo("0")
     */
    public $secondNumber;

    /**
     * @Assert\Choice({"add", "subtract", "multiply", "divide"})
     */
    public $operand;

    /**
     * @return mixed
     */
    public function getFirstNumber()
    {
        return $this->firstNumber;
    }

    /**
     * @param mixed $firstNumber
     */
    public function setFirstNumber($firstNumber)
    {
        $this->firstNumber = $firstNumber;
    }

    /**
     * @return mixed
     */
    public function getSecondNumber()
    {
        return $this->secondNumber;
    }

    /**
     * @param mixed $secondNumber
     */
    public function setSecondNumber($secondNumber)
    {
        $this->secondNumber = $secondNumber;
    }

    /**
     * @return mixed
     */
    public function getOperand()
    {
        return $this->operand;
    }

    /**
     * @return mixed
     */
    public function getExpresion()
    {
        return $this->expresion;
    }

    /**
     * @param mixed $expresion
     */
    public function setExpresion($expresion)
    {
        $this->expresion = $expresion;
    }

    /**
     * @param mixed $operand
     */
    public function setOperand($operand)
    {
        $this->operand = $operand;
    }

    public function calculate(){
        $input = preg_replace_callback("#(\(.+)\)#isU", 'self::parenthese', $this->expresion);
        return self::exec($input);
    }

    private function parenthese($input)
    {
        $input = str_replace('(', '', (str_replace(')', '', $input[0])));
       return self::exec($input);
    }

    private function exec($input)
    {
        if(preg_match('/(\d+)(?:\s*)([\+\-\*\/])(?:\s*)(\d+)/', $input, $matches) !== FALSE){
            $operator = $matches[2];

            switch($operator){
                case '+':
                    $operation = new Add();
                    break;
                case '-':
                    $operation = new Subtract();
                    break;
                case '*':
                    $operation = new Multiply();
                    break;
                case '/':
                    $operation = new Divide();
                    break;
            }
            return $operation->runCalculation($matches[1], $matches[3]);
        }
    }


    public function performCalculation()
    {
        if($this->expresion !== "") {
            return $this->calculate();
        }
        else {
            switch ($this->getOperand())
            {
                case "add":
                    $operation = new Add();
                    break;
                case "subtract":
                    $operation = new Subtract();
                    break;
                case "multiply":
                    $operation = new Multiply();
                    break;
                case "divide":
                    $operation = new Divide();
                    break;
            }

            return $operation->runCalculation($this->getFirstNumber(), $this->getSecondNumber());
        }
    }

}