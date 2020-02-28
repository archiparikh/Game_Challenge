<?php
namespace AppBundle\Service;

use AppBundle\BusinessConstant\RPSConstant;
use InvalidArgumentException;

class RPSService implements RPSServiceInterface
{
    /**
     * @var array
     */
    private $rpsBusinessConstants;

    /**
     * @var string
     */
    private $userInput;

    /**
     * RPSService constructor.
     * @param array $rpsBusinessConstants
     */
    public function __construct(array $rpsBusinessConstants)
    {
        $this->rpsBusinessConstants    = $rpsBusinessConstants;
    }

    /**
     * @param string $userInput
     * @return RPSService
     */
    public function with(string $userInput) {
        $this->userInput = $userInput;

        if(!$this->validate()) {
            throw new InvalidArgumentException('User input is not valid. 
            Expecting '.implode(', ', $this->rpsBusinessConstants['choose_from']).'. Provided '
                .$userInput);
        }


        return $this;
    }

    /**
     * @return bool
     */
    private function validate() {
        if(!in_array(strtolower($this->userInput), $this->rpsBusinessConstants['choose_from'])) {
            return false;
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function computerInput() {
        return $this->rpsBusinessConstants['choose_from'][rand(0, 2)];
    }

    /**
     * @param string $computerInput
     * @return int
     */
    public function matchResults(string $computerInput) {
        return $this->rpsBusinessConstants[$this->userInput][$computerInput];
    }

    /**
     * @param int $matchResult
     * @return string
     */
    public function matchResultText(int $matchResult) {

        if(!in_array($matchResult, [-1, 0, 1])) {
            return new InvalidArgumentException('invalid match result provided.');
        }

        if($matchResult == -1) {
            return RPSConstant::LOSE;
        }

        if($matchResult == 1) {
            return RPSConstant::WIN;
        }

        return RPSConstant::TIE;
    }
}