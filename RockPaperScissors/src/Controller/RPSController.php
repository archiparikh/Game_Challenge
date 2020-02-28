<?php
/**
 * Created by PhpStorm.
 * User: EOLuser
 * Date: 2/27/2020
 * Time: 12:04 PM
 */
namespace App\Controller;

use AppBundle\Service\RPSService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RPSController extends AbstractController
{
    private $rpsService;

    /**
     * RPSController constructor.
     * @param RPSService $rpsService
     */
    public function __construct(RPSService $rpsService) {
        $this->rpsService = $rpsService;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function post(Request $request)
    {
        $userInput = $request->get('rps_userinput');
        /** @var RPSService $rpsService */
        $rpsService = $this->rpsService->with($userInput);

        $computerInput = $rpsService->computerInput();
        $matchResult = $rpsService->matchResults($computerInput);

        $matchResultText = $rpsService->matchResultText($matchResult);

        $matchResultTemplate = $this->render('rps/match_results.html.twig', [
            'computerInput' => $computerInput,
            'matchResultText' => $matchResultText,
        ])->getContent();

        return $this->render('default/index.html.twig', [
            'match_results_template' => $matchResultTemplate,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}