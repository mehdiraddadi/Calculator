<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Calculator;
use AppBundle\Form\CalculatorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="calculator")
     */
    public function indexAction(Request $request)
    {
        $result = 0;
        $calculator = new Calculator();
        $form = $this->createForm(CalculatorType::class, $calculator);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $calculator = $form->getData();
            $result = $calculator->performCalculation();

            return $this->render('calculator/calculator.html.twig', array(
               'form' => $form->createView(),
               'result' => $result
            ));

        }
        return $this->render('calculator/calculator.html.twig', array('form' => $form->createView(), 'result' => $result) );
    }
}
