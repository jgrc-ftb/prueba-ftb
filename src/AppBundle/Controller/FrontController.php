<?php
namespace AppBundle\Controller;

use AppBundle\Form\ClubSearchType;
use Application\Club\GetClubsByLocaleQuery;
use Application\Club\GetClubsBySearchQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $userLocale = $this
            ->get('infrastructure.user.locale')
            ->handle();

        $form = $this->createForm(ClubSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $clubs = $this
                ->get('application.clubs.get_by_search')
                ->ask(
                    GetClubsBySearchQuery::create(
                        $userLocale,
                        $data['name'] ?? '',
                        $data['manager'] ?? ''
                    )
                );
        } else {
            $clubs = $this
                ->get('application.clubs.get_by_locale')
                ->ask(
                    GetClubsByLocaleQuery::create($userLocale)
                );
        }

        return $this->render(
            'front/index.html.twig',
            [
                'form' => $form->createView(),
                'clubs' => $clubs
            ]
        );
    }
}
