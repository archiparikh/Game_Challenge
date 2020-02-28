<?php
namespace AppBundle\Service;

interface RPSServiceInterface
{
    /**
     * @param string $userInput
     * @return RPSService
     */
    public function with(string $userInput);

    /**
     * @return mixed
     */
    public function computerInput();

    /**
     * @param string $computerInput
     * @return int
     */
    public function matchResults(string $computerInput);

    /**
     * @param int $matchResult
     * @return string
     */
    public function matchResultText(int $matchResult);
}