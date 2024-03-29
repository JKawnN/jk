<?php

namespace App\Controller;

use App\Entity\CapitalPantheraTrade;
use App\Entity\CapitalPantheraTradeUpdates;
use App\Entity\PantheraTradeIncome;
use App\Form\CapitalPantheraTradeUpdatesType;
use App\Form\PantheraTradeIncomeType;
use App\Repository\CapitalPantheraTradeRepository;
use App\Repository\CapitalPantheraTradeUpdatesRepository;
use App\Repository\PantheraTradeIncomeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class BotController extends AbstractController
{
    /**
     * @Route("/bots/details", name="bots_details")
     */
    public function bots_details(): Response
    {
        return $this->render('bots/details.html.twig', [
        ]);
    }

    /**
     * @Route("/bots", name="bots_list")
     */
    public function bots_main(): Response
    {
        return $this->render('bots/list.html.twig', [
        ]);
    }

    /**
     * @Route("/bots/gold", name="gold")
     */
    public function gold(): Response
    {
        return $this->render('bots/gold.html.twig', [
        ]);
    }

    /**
     * @Route("/bots/gold/capital/update", name="gold_capital_update")
     */
    public function gold_capital_update(Request $request, UserInterface $user, CapitalPantheraTradeRepository $capitalPantheraTradeRepository): Response
    {
        $form = $this->createForm(CapitalPantheraTradeUpdatesType::class);
        $capitalUpdate = new CapitalPantheraTradeUpdates;
        $newCapital = $capitalPantheraTradeRepository->findBy([
            'User' => $user,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Ici on est dans le cas où le formulaire est envoyé et valide (valide : tous les champs sont «correctes»)
            if (!$newCapital && $form->getData()['checkbox'] == 1) {
                $newCapital = new CapitalPantheraTrade;
                $newCapital->setUser($user);
                $newCapital->setCapital($form->getData()['montant']);

                $capitalUpdate->setType("Dépot");
                $capitalUpdate->setBeforeUpdate(0);

                $em = $this->getDoctrine()->getManager();
                $em->persist($newCapital);
                $em->flush();
            } else {
                $newCapital = $newCapital[0];
                $capitalUpdate->setBeforeUpdate($newCapital->getCapital());
                if ($form->getData()['checkbox'] == 1) {
                    $capitalUpdate->setType("Dépot");
                    $capitalUpdate->setMontant($form->getData()['montant']);
                    $newCapital->setCapital($newCapital->getCapital() + $form->getData()['montant']);
                } elseif ($form->getData()['checkbox'] == 0) {
                    $capitalUpdate->setType("Retrait");
                    $capitalUpdate->setMontant(-$form->getData()['montant']);
                    $newCapital->setCapital($newCapital->getCapital() - $form->getData()['montant']);
                }
                $this->getDoctrine()->getManager()->flush();
            }
            $capitalUpdate->setCapitalPantheraTrade($newCapital);
            $capitalUpdate->setAfterUpdate($newCapital->getCapital());
            $capitalUpdate->setDate($form->getData()['date']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($capitalUpdate);
            $em->flush();

            return $this->redirectToRoute('gold');
        }

        return $this->render('bots/gold_capital_update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bots/gold/income", name="gold_capital_income")
     */
    public function gold_capital_income(Request $request, UserInterface $user, PantheraTradeIncomeRepository $pantheraTradeIncomeRepository, CapitalPantheraTradeRepository $capitalPantheraTradeRepository): Response
    {
        $form = $this->createForm(PantheraTradeIncomeType::class);
        $income = new PantheraTradeIncome;
        $newCapital = $capitalPantheraTradeRepository->findBy([
            'User' => $user,
        ]);

        $lastIncome = $pantheraTradeIncomeRepository->findLastDayIncome($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Ici on est dans le cas où le formulaire est envoyé et valide (valide : tous les champs sont «correctes»)
            $newCapital = $newCapital[0];
            
            $income->setBeforeUpdate($newCapital->getCapital());

            if ($form->getData()['checkbox'] == 0) {
                $newCapital->setCapital($newCapital->getCapital() + $form->getData()['montant']);
                $income->setMontant($form->getData()['montant']);
                $income->setPercentage($form->getData()['montant'] / $income->getBeforeUpdate());
                $income->setType('Gain');
            } elseif ($form->getData()['checkbox'] == 1) {
                $newCapital->setCapital($newCapital->getCapital() - $form->getData()['montant']);
                $income->setMontant(-$form->getData()['montant']);  
                $income->setPercentage(-($form->getData()['montant'] / $income->getBeforeUpdate()));
                $income->setType('Perte');
            }
            
            $income->setCapitalPantheraTrade($newCapital);
            $income->setAfterUpdate($newCapital->getCapital());
            $income->setDate($form->getData()['date']);

            $this->getDoctrine()->getManager()->flush();
            $em = $this->getDoctrine()->getManager();
            $em->persist($income);
            $em->flush();

            return $this->redirectToRoute('gold_capital_income');
        }

        return $this->render('bots/gold_capital_income.html.twig', [
            'form' => $form->createView(),
            'lastIncome' =>$lastIncome[0],
        ]);
    }

    /**
     * @Route("/bots/gold/{username}/stats", name="gold_stats")
     */
    public function gold_stats($username , ?UserInterface $user, UserRepository $userRepository, CapitalPantheraTradeUpdatesRepository $capitalPantheraTradeUpdatesRepository, CapitalPantheraTradeRepository $capitalPantheraTradeRepository, PantheraTradeIncomeRepository $pantheraTradeIncomeRepository): Response
    {
        $userToShow = $userRepository->findBy([
            'username' => $username,
        ])[0];
        $capital = $capitalPantheraTradeRepository->findBy([
            'User' => $userToShow,
        ])[0];
        $capitalUpdates = $capitalPantheraTradeUpdatesRepository->findBy([
            'CapitalPantheraTrade' => $capital,
        ]);

        $newCapitalUpdate = [];

        $k = 0;
        foreach ($capitalUpdates as $capitalUpdate) {
            $arrayToPush = [
                'montant' => $capitalUpdate->getMontant(),
                'type' => $capitalUpdate->getType(),
            ];
            if (isset($newCapitalUpdate[date_format($capitalUpdate->getDate(),'Y-m-d')])) {
                $k++;
                $newCapitalUpdate[date_format($capitalUpdate->getDate(),'Y-m-d')][$k] = $arrayToPush;
            } else {
                $k = 0;
                $newCapitalUpdate[date_format($capitalUpdate->getDate(),'Y-m-d')][$k] = $arrayToPush;
            }
        }

        $incomeList = $pantheraTradeIncomeRepository->findAllByDateAndUser($userToShow);
        $listToShow = [];

        $today =  date('Y-m-d');
        // $j servira d'itération pour savoir à quel jour nous sommes dans la boucle
        $j = 0;

        $firstDay = date_format($incomeList[0]->getDate(),'Y-m-d');

        $gainTotal = 0;

        $diviseurCent = floor($incomeList[0]->getBeforeUpdate() / 100);
        $diviseurMille = floor($incomeList[0]->getBeforeUpdate() / 1000);

        for ($i = $firstDay; $i <= $today ; $i = date("Y-m-d", strtotime($i.'+ 1 days'))) {
            $updateOfTheDay = 0;
            
            if (isset($newCapitalUpdate[$i])) {
                $listToShow[$i][0]['capitalUpdates'] = $newCapitalUpdate[$i];
                $updateOfTheDay = 0;
                foreach ($newCapitalUpdate[$i] as $value) {
                    $updateOfTheDay += $value['montant'];
                }
            }

            if (isset($incomeList[$j])) {
                if (date_format($incomeList[$j]->getDate(),'Y-m-d') == $i) {
                    $k = 0;
                    while (isset($incomeList[$j]) && date_format($incomeList[$j]->getDate(),'Y-m-d') == $i) {
                        $listToShow[$i][$k]['montant'] = $incomeList[$j]->getMontant();
                        $gainTotal += $incomeList[$j]->getMontant();
                        $listToShow[$i][$k]['type'] = $incomeList[$j]->getType();
                        $listToShow[$i][$k]['beforeUpdate'] = $incomeList[$j]->getBeforeUpdate();
                        $listToShow[$i][$k]['afterUpdate'] = $incomeList[$j]->getAfterUpdate();
                        $listToShow[$i][$k]['percentage'] = round($incomeList[$j]->getPercentage(), 4) * 100;
                        if ($i >= date("Y-m-d", strtotime($firstDay.'+ 7 days'))) {
                            $listToShow[$i][$k]['sevenDaysPercentageWithoutInterest'] = 0;
                            $listToShow[$i][0]['sevenDaysPercentageWithInterest'] = 0;
                            $listToShow[$i][$k]['sevenDaysAmount'] = 0;
                        }

                        if ($i >= date("Y-m-d", strtotime($firstDay.'+ 30 days'))) {
                            $listToShow[$i][$k]['thirtyDaysPercentageWithoutInterest'] = 0;
                            $listToShow[$i][0]['thirtyDaysPercentageWithInterest'] = 0;
                            $listToShow[$i][$k]['thirtyDaysAmount'] = 0;
                        }

                        $j++;
                        $k++;
                    }
                } else {
                    $listToShow[$i][0]['montant'] = 0;
                    $listToShow[$i][0]['type'] = 'NONE';
                    $k = $j-1;
                    while (isset($incomeList[$k])) {
                        if ($incomeList[$k]->getAfterUpdate() !== null) {
                            $lastDate = $k;
                            break;
                        }
                        $k--;
                    }
                    $listToShow[$i][0]['beforeUpdate'] = $incomeList[$lastDate]->getAfterUpdate() + $updateOfTheDay;
                    $listToShow[$i][0]['afterUpdate'] = $incomeList[$lastDate]->getAfterUpdate() + $updateOfTheDay;
                    $listToShow[$i][0]['percentage'] = 0;
                    if ($i >= date("Y-m-d", strtotime($firstDay.'+ 7 days'))) {
                        $listToShow[$i][0]['sevenDaysPercentageWithoutInterest'] = 0;
                        $listToShow[$i][0]['sevenDaysPercentageWithInterest'] = 0;
                        $listToShow[$i][0]['sevenDaysAmount'] = 0;
                    }

                    if ($i >= date("Y-m-d", strtotime($firstDay.'+ 30 days'))) {
                        $listToShow[$i][0]['thirtyDaysPercentageWithoutInterest'] = 0;
                        $listToShow[$i][0]['thirtyDaysPercentageWithInterest'] = 0;
                        $listToShow[$i][0]['thirtyDaysAmount'] = 0;
                    }
                    
                }
            } else {
                $listToShow[$i][0]['montant'] = 0;
                $listToShow[$i][0]['type'] = 'NONE';
                $k = $j-1;
                while (isset($incomeList[$k])) {
                    if ($incomeList[$k]->getAfterUpdate() !== null) {
                        $lastDate = $k;
                        break;
                    }
                    $k--;
                }
                $listToShow[$i][0]['beforeUpdate'] = $incomeList[$lastDate]->getAfterUpdate() + $updateOfTheDay;
                $listToShow[$i][0]['afterUpdate'] = $incomeList[$lastDate]->getAfterUpdate() + $updateOfTheDay;
                $listToShow[$i][0]['percentage'] = 0;
                if ($i >= date("Y-m-d", strtotime($firstDay.'+ 7 days'))) {
                    $listToShow[$i][0]['sevenDaysPercentageWithoutInterest'] = 0;
                    $listToShow[$i][0]['sevenDaysPercentageWithInterest'] = 0;
                    $listToShow[$i][0]['sevenDaysAmount'] = 0;
                }

                if ($i >= date("Y-m-d", strtotime($firstDay.'+ 30 days'))) {
                    $listToShow[$i][0]['thirtyDaysPercentageWithoutInterest'] = 0;
                    $listToShow[$i][0]['thirtyDaysPercentageWithInterest'] = 0;
                    $listToShow[$i][0]['thirtyDaysAmount'] = 0;
                }
                
            }

            // calcul du pourcentage de revenus des 7 derniers jours avec interet
            $iMinusSeven = date("Y-m-d", strtotime($i.'- 6 days'));
            $a = $i;
            $totalCapitalUpdate = 0;
            while ($a >= $iMinusSeven && $a >= $firstDay) {
                foreach ($listToShow[$a] as $key => $income) {
                    if (isset($newCapitalUpdate[$a])) {
                        foreach ($newCapitalUpdate[$a] as $value) {
                            $totalCapitalUpdate += $value['montant'];
                        }
                    }
                    if (isset($listToShow[$i][0]['sevenDaysAmount'])) {
                        $listToShow[$i][0]['sevenDaysAmount'] = $listToShow[$i][0]['sevenDaysAmount'] + $income['montant'];
                    }
                    if (isset($listToShow[$i][0]['sevenDaysPercentageWithoutInterest'])) {
                        $listToShow[$i][0]['sevenDaysPercentageWithoutInterest'] = $listToShow[$i][0]['sevenDaysPercentageWithoutInterest'] + round($income['percentage'], 4);
                    }
                }
                $a = date("Y-m-d", strtotime($a.'- 1 days'));
            } 

            if ($i >= date("Y-m-d", strtotime($firstDay.'+ 7 days'))) {
                if (isset($newCapitalUpdate[$i])) {
                    foreach ($newCapitalUpdate[$i] as $value) {
                        $totalCapitalUpdate += $value['montant'];
                    }
                }
                $firstComponent = $listToShow[$i][array_key_last($listToShow[$i])]['afterUpdate'];
                $secondComponent = $listToShow[date("Y-m-d", strtotime($i.'- 7 days'))][0]['afterUpdate'];
                if (isset($newCapitalUpdate[$i])) {
                    foreach ($newCapitalUpdate[$i] as $value) {
                        $totalCapitalUpdate -= $value['montant'];
                    }
                }
                $listToShow[$i][0]['sevenDaysPercentageWithInterest'] = round(($firstComponent - $secondComponent - $totalCapitalUpdate) / $secondComponent, 4) * 100;
            }

            // calcul du pourcentage de revenus des 30 derniers jours avec interet
            $iMinusthirty = date("Y-m-d", strtotime($i.'- 29 days'));
            $b = $i;
            $totalCapitalUpdate = 0;
            while ($b >= $iMinusthirty && $b >= $firstDay) {
                foreach ($listToShow[$b] as $key => $income) {
                    if (isset($newCapitalUpdate[$b])) {
                        foreach ($newCapitalUpdate[$b] as $value) {
                            $totalCapitalUpdate += $value['montant'];
                        }
                    }
                    if (isset($listToShow[$i][0]['thirtyDaysAmount'])) {
                        $listToShow[$i][0]['thirtyDaysAmount'] = $listToShow[$i][0]['thirtyDaysAmount'] + $income['montant'];
                    }
                    if (isset($listToShow[$i][0]['thirtyDaysPercentageWithoutInterest'])) {
                        $listToShow[$i][0]['thirtyDaysPercentageWithoutInterest'] = $listToShow[$i][0]['thirtyDaysPercentageWithoutInterest'] + round($income['percentage'], 4);
                    }
                }
                $b = date("Y-m-d", strtotime($b.'- 1 days'));
            }
            
            if ($i >= date("Y-m-d", strtotime($firstDay.'+ 30 days'))) {
                if (isset($newCapitalUpdate[$i])) {
                    foreach ($newCapitalUpdate[$i] as $value) {
                        $totalCapitalUpdate += $value['montant'];
                    }
                }
                $firstComponent = $listToShow[$i][array_key_last($listToShow[$i])]['afterUpdate'];
                $secondComponent = $listToShow[date("Y-m-d", strtotime($i.'- 30 days'))][0]['afterUpdate'];
                if (isset($newCapitalUpdate[$i])) {
                    foreach ($newCapitalUpdate[$i] as $value) {
                        $totalCapitalUpdate -= $value['montant'];
                    }
                }
                $listToShow[$i][0]['thirtyDaysPercentageWithInterest'] = round(($firstComponent - $secondComponent - $totalCapitalUpdate) / $secondComponent, 4) * 100;
            }

            if ((date("D", strtotime($i)) == "Sun")) {
                $listToShow[$i][0]['isSunday'] = true;
            } else {
                $listToShow[$i][0]['isSunday'] = false;
            }
            
            if ((date("d", strtotime($i)) == "01")) {
                $listToShow[$i][0]['isFirstDayOfTheMonth'] = true;
            } else {
                $listToShow[$i][0]['isFirstDayOfTheMonth'] = false;
            }

            if ($i >= date("Y-m-d", strtotime($firstDay.'+ 1 days'))) {
                $newDiviseur = floor($listToShow[$i][array_key_last($listToShow[$i])]['afterUpdate'] / 100);
                if (isset($newCapitalUpdate[$i]) && $newCapitalUpdate[$i][0]['type'] == "Retrait") {
                    $diviseurCent = floor($listToShow[$i][array_key_last($listToShow[$i])]['afterUpdate'] / 100);
                }
                if ( $diviseurCent < $newDiviseur ) {
                    $listToShow[$i][0]['isHundredMore'] = true;
                    $diviseurCent = $newDiviseur;
                } else {
                    $listToShow[$i][0]['isHundredMore'] = false;
                }
            } else {
                $listToShow[$i][0]['isHundredMore'] = false;  
            }

            if ($i >= date("Y-m-d", strtotime($firstDay.'+ 1 days'))) {
                $newDiviseur = floor($listToShow[$i][array_key_last($listToShow[$i])]['afterUpdate'] / 1000);
                if (isset($newCapitalUpdate[$i]) && $newCapitalUpdate[$i][0]['type'] == "Retrait") {
                    $diviseurMille = floor($listToShow[$i][array_key_last($listToShow[$i])]['afterUpdate'] / 1000);
                }
                if ( $diviseurMille < $newDiviseur ) {
                    $listToShow[$i][0]['isThousandMore'] = true;
                    $diviseurMille = $newDiviseur;
                } else {
                    $listToShow[$i][0]['isThousandMore'] = false;
                }
            } else {
                $listToShow[$i][0]['isThousandMore'] = false;  
            }
        }

        return $this->render('bots/gold_stats.html.twig', [
            'incomeList' => array_reverse($listToShow),
            'capital' => $capital,
            'gainTotal' => $gainTotal,
            'capitalUpdates' => $newCapitalUpdate,
        ]);
    }

    /**
     * @Route("/bots/gold/{username}/graphs", name="gold_graphs")
     */
    public function gold_graphs($username , ?UserInterface $user, UserRepository $userRepository, CapitalPantheraTradeUpdatesRepository $capitalPantheraTradeUpdatesRepository, CapitalPantheraTradeRepository $capitalPantheraTradeRepository, PantheraTradeIncomeRepository $pantheraTradeIncomeRepository): Response
    {
        $userToShow = $userRepository->findBy([
            'username' => $username,
        ])[0];
        $capital = $capitalPantheraTradeRepository->findBy([
            'User' => $userToShow,
        ])[0];
        $capitalUpdates = $capitalPantheraTradeUpdatesRepository->findBy([
            'CapitalPantheraTrade' => $capital,
        ]);

        $newCapitalUpdate = [];

        $k = 0;
        foreach ($capitalUpdates as $capitalUpdate) {
            $arrayToPush = [
                'montant' => $capitalUpdate->getMontant(),
                'type' => $capitalUpdate->getType(),
            ];
            if (isset($newCapitalUpdate[date_format($capitalUpdate->getDate(),'Y-m-d')])) {
                $k++;
                $newCapitalUpdate[date_format($capitalUpdate->getDate(),'Y-m-d')][$k] = $arrayToPush;
            } else {
                $k = 0;
                $newCapitalUpdate[date_format($capitalUpdate->getDate(),'Y-m-d')][$k] = $arrayToPush;
            }
        }

        $incomeList = $pantheraTradeIncomeRepository->findAllByDateAndUser($userToShow);
        $listToShow = [];

        $today =  date('Y-m-d');
        // $j servira d'itération pour savoir à quel jour nous sommes dans la boucle
        $j = 0;

        $firstDay = date_format($incomeList[0]->getDate(),'Y-m-d');

        $gainTotal = 0;

        $diviseurCent = floor($incomeList[0]->getBeforeUpdate() / 100);
        $diviseurMille = floor($incomeList[0]->getBeforeUpdate() / 1000);

        for ($i = $firstDay; $i <= $today ; $i = date("Y-m-d", strtotime($i.'+ 1 days'))) {
            $updateOfTheDay = 0;
            
            if (isset($newCapitalUpdate[$i])) {
                $listToShow[$i][0]['capitalUpdates'] = $newCapitalUpdate[$i];
                $updateOfTheDay = 0;
                foreach ($newCapitalUpdate[$i] as $value) {
                    $updateOfTheDay += $value['montant'];
                }
            }

            if (isset($incomeList[$j])) {
                if (date_format($incomeList[$j]->getDate(),'Y-m-d') == $i) {
                    $k = 0;
                    while (isset($incomeList[$j]) && date_format($incomeList[$j]->getDate(),'Y-m-d') == $i) {
                        $listToShow[$i][$k]['montant'] = $incomeList[$j]->getMontant();
                        $gainTotal += $incomeList[$j]->getMontant();
                        $listToShow[$i][$k]['type'] = $incomeList[$j]->getType();
                        $listToShow[$i][$k]['beforeUpdate'] = $incomeList[$j]->getBeforeUpdate();
                        $listToShow[$i][$k]['afterUpdate'] = $incomeList[$j]->getAfterUpdate();
                        $listToShow[$i][$k]['percentage'] = round($incomeList[$j]->getPercentage(), 4) * 100;
                        if ($i >= date("Y-m-d", strtotime($firstDay.'+ 7 days'))) {
                            $listToShow[$i][$k]['sevenDaysPercentageWithoutInterest'] = 0;
                            $listToShow[$i][0]['sevenDaysPercentageWithInterest'] = 0;
                            $listToShow[$i][$k]['sevenDaysAmount'] = 0;
                        }

                        if ($i >= date("Y-m-d", strtotime($firstDay.'+ 30 days'))) {
                            $listToShow[$i][$k]['thirtyDaysPercentageWithoutInterest'] = 0;
                            $listToShow[$i][0]['thirtyDaysPercentageWithInterest'] = 0;
                            $listToShow[$i][$k]['thirtyDaysAmount'] = 0;
                        }

                        $j++;
                        $k++;
                    }
                } else {
                    $listToShow[$i][0]['montant'] = 0;
                    $listToShow[$i][0]['type'] = 'NONE';
                    $k = $j-1;
                    while (isset($incomeList[$k])) {
                        if ($incomeList[$k]->getAfterUpdate() !== null) {
                            $lastDate = $k;
                            break;
                        }
                        $k--;
                    }
                    $listToShow[$i][0]['beforeUpdate'] = $incomeList[$lastDate]->getAfterUpdate() + $updateOfTheDay;
                    $listToShow[$i][0]['afterUpdate'] = $incomeList[$lastDate]->getAfterUpdate() + $updateOfTheDay;
                    $listToShow[$i][0]['percentage'] = 0;
                    if ($i >= date("Y-m-d", strtotime($firstDay.'+ 7 days'))) {
                        $listToShow[$i][0]['sevenDaysPercentageWithoutInterest'] = 0;
                        $listToShow[$i][0]['sevenDaysPercentageWithInterest'] = 0;
                        $listToShow[$i][0]['sevenDaysAmount'] = 0;
                    }

                    if ($i >= date("Y-m-d", strtotime($firstDay.'+ 30 days'))) {
                        $listToShow[$i][0]['thirtyDaysPercentageWithoutInterest'] = 0;
                        $listToShow[$i][0]['thirtyDaysPercentageWithInterest'] = 0;
                        $listToShow[$i][0]['thirtyDaysAmount'] = 0;
                    }
                    
                }
            } else {
                $listToShow[$i][0]['montant'] = 0;
                $listToShow[$i][0]['type'] = 'NONE';
                $k = $j-1;
                while (isset($incomeList[$k])) {
                    if ($incomeList[$k]->getAfterUpdate() !== null) {
                        $lastDate = $k;
                        break;
                    }
                    $k--;
                }
                $listToShow[$i][0]['beforeUpdate'] = $incomeList[$lastDate]->getAfterUpdate() + $updateOfTheDay;
                $listToShow[$i][0]['afterUpdate'] = $incomeList[$lastDate]->getAfterUpdate() + $updateOfTheDay;
                $listToShow[$i][0]['percentage'] = 0;
                if ($i >= date("Y-m-d", strtotime($firstDay.'+ 7 days'))) {
                    $listToShow[$i][0]['sevenDaysPercentageWithoutInterest'] = 0;
                    $listToShow[$i][0]['sevenDaysPercentageWithInterest'] = 0;
                    $listToShow[$i][0]['sevenDaysAmount'] = 0;
                }

                if ($i >= date("Y-m-d", strtotime($firstDay.'+ 30 days'))) {
                    $listToShow[$i][0]['thirtyDaysPercentageWithoutInterest'] = 0;
                    $listToShow[$i][0]['thirtyDaysPercentageWithInterest'] = 0;
                    $listToShow[$i][0]['thirtyDaysAmount'] = 0;
                }
                
            }

            // calcul du pourcentage de revenus des 7 derniers jours avec interet
            $iMinusSeven = date("Y-m-d", strtotime($i.'- 6 days'));
            $a = $i;
            $totalCapitalUpdate = 0;
            while ($a >= $iMinusSeven && $a >= $firstDay) {
                foreach ($listToShow[$a] as $key => $income) {
                    if (isset($newCapitalUpdate[$a])) {
                        foreach ($newCapitalUpdate[$a] as $value) {
                            $totalCapitalUpdate += $value['montant'];
                        }
                    }
                    if (isset($listToShow[$i][0]['sevenDaysAmount'])) {
                        $listToShow[$i][0]['sevenDaysAmount'] = $listToShow[$i][0]['sevenDaysAmount'] + $income['montant'];
                    }
                    if (isset($listToShow[$i][0]['sevenDaysPercentageWithoutInterest'])) {
                        $listToShow[$i][0]['sevenDaysPercentageWithoutInterest'] = $listToShow[$i][0]['sevenDaysPercentageWithoutInterest'] + round($income['percentage'], 4);
                    }
                }
                $a = date("Y-m-d", strtotime($a.'- 1 days'));
            } 

            if ($i >= date("Y-m-d", strtotime($firstDay.'+ 7 days'))) {
                if (isset($newCapitalUpdate[$i])) {
                    foreach ($newCapitalUpdate[$i] as $value) {
                        $totalCapitalUpdate += $value['montant'];
                    }
                }
                $firstComponent = $listToShow[$i][array_key_last($listToShow[$i])]['afterUpdate'];
                $secondComponent = $listToShow[date("Y-m-d", strtotime($i.'- 7 days'))][0]['afterUpdate'];
                if (isset($newCapitalUpdate[$i])) {
                    foreach ($newCapitalUpdate[$i] as $value) {
                        $totalCapitalUpdate -= $value['montant'];
                    }
                }
                $listToShow[$i][0]['sevenDaysPercentageWithInterest'] = round(($firstComponent - $secondComponent - $totalCapitalUpdate) / $secondComponent, 4) * 100;
            }

            // calcul du pourcentage de revenus des 30 derniers jours avec interet
            $iMinusthirty = date("Y-m-d", strtotime($i.'- 29 days'));
            $b = $i;
            $totalCapitalUpdate = 0;
            while ($b >= $iMinusthirty && $b >= $firstDay) {
                foreach ($listToShow[$b] as $key => $income) {
                    if (isset($newCapitalUpdate[$b])) {
                        foreach ($newCapitalUpdate[$b] as $value) {
                            $totalCapitalUpdate += $value['montant'];
                        }
                    }
                    if (isset($listToShow[$i][0]['thirtyDaysAmount'])) {
                        $listToShow[$i][0]['thirtyDaysAmount'] = $listToShow[$i][0]['thirtyDaysAmount'] + $income['montant'];
                    }
                    if (isset($listToShow[$i][0]['thirtyDaysPercentageWithoutInterest'])) {
                        $listToShow[$i][0]['thirtyDaysPercentageWithoutInterest'] = $listToShow[$i][0]['thirtyDaysPercentageWithoutInterest'] + round($income['percentage'], 4);
                    }
                }
                $b = date("Y-m-d", strtotime($b.'- 1 days'));
            }
            
            if ($i >= date("Y-m-d", strtotime($firstDay.'+ 30 days'))) {
                if (isset($newCapitalUpdate[$i])) {
                    foreach ($newCapitalUpdate[$i] as $value) {
                        $totalCapitalUpdate += $value['montant'];
                    }
                }
                $firstComponent = $listToShow[$i][array_key_last($listToShow[$i])]['afterUpdate'];
                $secondComponent = $listToShow[date("Y-m-d", strtotime($i.'- 30 days'))][0]['afterUpdate'];
                if (isset($newCapitalUpdate[$i])) {
                    foreach ($newCapitalUpdate[$i] as $value) {
                        $totalCapitalUpdate -= $value['montant'];
                    }
                }
                $listToShow[$i][0]['thirtyDaysPercentageWithInterest'] = round(($firstComponent - $secondComponent - $totalCapitalUpdate) / $secondComponent, 4) * 100;
            }

            if ((date("D", strtotime($i)) == "Sun")) {
                $listToShow[$i][0]['isSunday'] = true;
            } else {
                $listToShow[$i][0]['isSunday'] = false;
            }
            
            if ((date("d", strtotime($i)) == "01")) {
                $listToShow[$i][0]['isFirstDayOfTheMonth'] = true;
            } else {
                $listToShow[$i][0]['isFirstDayOfTheMonth'] = false;
            }

            if ($i >= date("Y-m-d", strtotime($firstDay.'+ 1 days'))) {
                $newDiviseur = floor($listToShow[$i][array_key_last($listToShow[$i])]['afterUpdate'] / 100);
                if (isset($newCapitalUpdate[$i]) && $newCapitalUpdate[$i][0]['type'] == "Retrait") {
                    $diviseurCent = floor($listToShow[$i][array_key_last($listToShow[$i])]['afterUpdate'] / 100);
                }
                if ( $diviseurCent < $newDiviseur ) {
                    $listToShow[$i][0]['isHundredMore'] = true;
                    $diviseurCent = $newDiviseur;
                } else {
                    $listToShow[$i][0]['isHundredMore'] = false;
                }
            } else {
                $listToShow[$i][0]['isHundredMore'] = false;  
            }

            if ($i >= date("Y-m-d", strtotime($firstDay.'+ 1 days'))) {
                $newDiviseur = floor($listToShow[$i][array_key_last($listToShow[$i])]['afterUpdate'] / 1000);
                if (isset($newCapitalUpdate[$i]) && $newCapitalUpdate[$i][0]['type'] == "Retrait") {
                    $diviseurMille = floor($listToShow[$i][array_key_last($listToShow[$i])]['afterUpdate'] / 1000);
                }
                if ( $diviseurMille < $newDiviseur ) {
                    $listToShow[$i][0]['isThousandMore'] = true;
                    $diviseurMille = $newDiviseur;
                } else {
                    $listToShow[$i][0]['isThousandMore'] = false;
                }
            } else {
                $listToShow[$i][0]['isThousandMore'] = false;  
            }
        }
        return $this->render('bots/gold_graphs.html.twig', [
            'incomeList' => $listToShow,
            'capital' => $capital,
            'capitalUpdates' => $newCapitalUpdate,
            'gainTotal' => $gainTotal,
        ]);
    }
}