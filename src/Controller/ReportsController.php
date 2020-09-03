<?php


namespace App\Controller;


use App\Entity\Customer;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\LoyaltyCard;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReportsController extends AbstractController
{

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
        {
            $this->customerRepository = $customerRepository;
        }

        /**
         * @Route("/reports", name="reports")
         */
        public function createReports() {

            $entityManager = $this->getDoctrine()->getManager();

            $customersCount = $this->customerRepository->count([]);

            $cardsCount = $this->customerRepository->countCards();

            $sql = "
            SELECT c.firstname, c.lastname, SUM(o.final_price) AS final_price
                    FROM customer c
                    LEFT JOIN `order` AS o
                    ON c.loyalty_card = o.loyalty_card
                    WHERE c.loyalty_card = o.loyalty_card AND o.date_created>=date_sub(now(), interval 1 month)
                    GROUP BY c.id
                    ORDER BY final_price DESC
                    LIMIT 20
            ";

            $stmt = $entityManager->getConnection()->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll();

            $itemsArray = [];

            return $this->render(
                'reports/reports.html.twig',
                array('customers' => $customersCount, "cards" => $cardsCount, 'orders' => $results)
            );
        }
}