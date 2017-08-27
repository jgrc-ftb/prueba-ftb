<?php
namespace AppBundle\Controller;

use AppBundle\Form\ClubTranslationType;
use AppBundle\Form\ClubType;
use AppBundle\Form\LanguageType;
use AppBundle\Form\LoginType;
use Application\Club\CreateClubCommand;
use Application\Club\CreateClubTranslationCommand;
use Application\Club\RemoveClubCommand;
use Application\Club\RemoveClubTranslationCommand;
use Application\Language\CreateLanguageCommand;
use Application\Language\RemoveLanguageCommand;
use Domain\Model\ClubNotFoundException;
use Domain\Model\ClubTranslationExistsException;
use Domain\Model\ClubTranslationNotFoundException;
use Domain\Model\LanguageExistsException;
use Domain\Model\LanguageNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BackController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        if ($this->get('security.authentication_utils')->getLastAuthenticationError()) {
            $this->addFlash('error', 'Invalid credentials. Try admin : admin ;)');
        }

        return $this->render(
            'back/login.html.twig',
            [
                'form' => $this->createForm(LoginType::class)->createView()
            ]
        );
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {
        $languages = $this
            ->get('application.languages.get')
            ->ask();

        $clubs = $this
            ->get('application.clubs.get')
            ->ask();

        return $this->render(
            'back/index.html.twig',
            [
                'languages' => $languages,
                'clubs' => $clubs
            ]
        );
    }

    /**
     * @Route("/admin/create-language", name="create_language")
     */
    public function createLanguageAction(Request $request)
    {
        $form = $this->createForm(LanguageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $data = $form->getData();
                $this
                    ->get('application.language.create')
                    ->handle(
                        CreateLanguageCommand::create(
                            $data['locale'],
                            $data['name']
                        )
                    );
                $this->addFlash('success', 'Language created.');
                return $this->redirectToRoute('admin');

            } catch (\Exception $e) {
                $this->createFlash($e);
            }
        }

        return $this->render(
            'back/language.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/admin/remove-language", name="remove_language")
     */
    public function removeLanguageAction(Request $request)
    {
        try {
            $this
                ->get('application.language.remove')
                ->handle(
                    RemoveLanguageCommand::create(
                        $request->query->get('language', '')
                    )
                );
            $this->addFlash('success', 'Language removed.');
        } catch (\Exception $e) {
            $this->createFlash($e);
        } finally {
            return $this->redirectToRoute('admin');
        }
    }

    /**
     * @Route("/admin/create-club", name="create_club")
     */
    public function createClubAction(Request $request)
    {
        $form = $this->createForm(ClubType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $data = $form->getData();
                $this
                    ->get('application.club.create')
                    ->handle(
                        CreateClubCommand::create(
                            $data['name'],
                            $data['manager']
                        )
                    );
                $this->addFlash('success', 'Club created.');
                return $this->redirectToRoute('admin');

            } catch (\Exception $e) {
                $this->createFlash($e);
            }
        }

        return $this->render(
            'back/language.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/admin/remove-club", name="remove_club")
     */
    public function removeClubAction(Request $request)
    {
        try {
            $this
                ->get('application.club.remove')
                ->handle(
                    RemoveClubCommand::create(
                        $request->query->get('club', '')
                    )
                );
            $this->addFlash('success', 'Club removed.');
        } catch (\Exception $e) {
            $this->createFlash($e);
        } finally {
            return $this->redirectToRoute('admin');
        }
    }

    /**
     * @Route("/admin/create-club-translation", name="create_club_translation")
     */
    public function createClubTranslationAction(Request $request)
    {
        $languages = $this
            ->get('application.languages.get')
            ->ask();

        $form = $this->createForm(
            ClubTranslationType::class,
            [
                'default_club' => $request->query->get('club'),
                'default_languages' => $languages
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $data = $form->getData();
                $this
                    ->get('application.club_translation.create')
                    ->handle(
                        CreateClubTranslationCommand::create(
                            $data['club'],
                            $data['language'],
                            $data['description']
                        )
                    );
                $this->addFlash('success', 'Club translation created.');
                return $this->redirectToRoute('admin');

            } catch (\Exception $e) {
                $this->createFlash($e);
            }
        }

        return $this->render(
            'back/club-translation.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/admin/remove-club-translation", name="remove_club_translation")
     */
    public function removeClubTranslationAction(Request $request)
    {
        try {
            $this
                ->get('application.club_translation.remove')
                ->handle(
                    RemoveClubTranslationCommand::create(
                        $request->query->get('club', ''),
                        $request->query->get('language', '')
                    )
                );
            $this->addFlash('success', 'Club translation removed.');
        } catch (\Exception $e) {
            $this->createFlash($e);
        } finally {
            return $this->redirectToRoute('admin');
        }
    }

    private function createFlash(\Exception $e)
    {
        try {
            throw $e;
        } catch (ClubNotFoundException $e) {
            $this->addFlash('error', 'Club not found.');
        } catch (LanguageNotFoundException $e) {
            $this->addFlash('error', 'Language not found.');
        } catch (ClubTranslationNotFoundException $e) {
            $this->addFlash('error', 'Club translation not found.');
        } catch (LanguageExistsException $e) {
            $this->addFlash('error', 'Language locale exists.');
        } catch (ClubTranslationExistsException $e) {
            $this->addFlash('error', 'Language translation exists.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Unknow error. Try later.');
        }
    }
}
