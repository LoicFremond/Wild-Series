<?php

namespace App\Controller;

use App\Entity\Program;
use App\Form\ProgramSearchType;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use App\Service\Flash;
use App\Service\GetCategory;
use App\Service\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @property array category
 * @Route("/admin/series")
 */
class ProgramController extends AbstractController
{

    /**
     * @var string
     */
    private $flash;

    public function __construct(GetCategory $category, Flash $flash)
    {
        $this->category = $category->getCategory();
        $this->flash = $flash;
    }
 

   /**
     * Show all rows from Program’s entity
     *
     * @Route("/", name="program_index")
     * @param ProgramRepository  $programRepository
     * @param PaginatorInterface $paginator
     * @param Request            $request
     * @return Response A response instance
     */
    public function index(
        ProgramRepository $programRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
        $isSearch = false;
        $programs = $paginator->paginate(
            $programRepository->findAllPrograms(),
            $request->query->getInt('page', 1),
            12
        );


        if (!$programs) {
            throw $this->createNotFoundException(
                'Aucune série trouvée.'
            );
        }

        $form = $this->createForm(ProgramSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $data = $form->getData();
            $programs = $paginator->paginate(
                $programRepository->search(mb_strtolower($data['searchField'])),
                $request->query->getInt('page', 1),
                12
            );
                $isSearch = true;
        }

        return $this->render(
            'admin/program/index.html.twig',
            [
                'programs' => $programs,
                'form' => $form->createView(),
                'categories' => $this->category,
                'search' => $isSearch,
            ]
        );
    }

    /**
     * @Route("/new", name="program_new", methods={"GET","POST"})
     * @param Request         $request
     * @param Slugify         $slugify
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function new(Request $request, Slugify $slugify, MailerInterface $mailer): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $program->setSlug($slugify->generate($program->getTitle()));
            $entityManager->persist($program);
            $entityManager->flush();

            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('loic.fremond@hotmail.fr')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html($this->renderView('emails/newProgram.html.twig', [
                    'program' => $program,
                ]), 'utf-8');

            $mailer->send($email);

            $this->flash->createFlash('Create');

            return $this->redirectToRoute('program_index');
        }

        return $this->render('admin/program/new.html.twig', [
            'program' => $program,
            'form' => $form->createView(),
            'categories' => $this->category,
        ]);
    }

    /**
     * @Route("/{slug}", name="program_show", methods={"GET"})
     * @param Program $program
     * @return Response
     */
    public function show(Program $program): Response
    {
        return $this->render('admin/program/show.html.twig', [
            'program' => $program,
            'categories' => $this->category,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="program_edit", methods={"GET","POST"} )
     * @param Request $request
     * @param Program $program
     * @param Slugify $slugify
     * @return Response
     */
    public function edit(Request $request, Program $program, Slugify $slugify): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('Update', 'Modification enregistrée');

            $entityManager = $this->getDoctrine()->getManager();
            $program->setSlug($slugify->generate($program->getTitle()));
            $entityManager->persist($program);
            $entityManager->flush();

            return $this->redirectToRoute('program_index');
        }

        return $this->render('admin/program/edit.html.twig', [
            'program' => $program,
            'form' =>  $form->createView(),
            'categories' => $this->category,
        ]);
    }

    /**
     * @Route("/{id}", name="program_delete", methods={"DELETE"})
     * @param Request $request
     * @param Program $program
     * @return Response
     */
    public function delete(Request $request, Program $program): Response
    {
        if ($this->isCsrfTokenValid('delete'.$program->getId(), $request->request->get('_token'))) {
            $this->addFlash('Delete', 'Le programme a été supprimé');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($program);
            $entityManager->flush();
        }

        return $this->redirectToRoute('program_index');
    }

}
