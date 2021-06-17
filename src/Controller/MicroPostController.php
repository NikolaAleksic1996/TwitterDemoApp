<?php


namespace App\Controller;

use App\Entity\MicroPost;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class MicroPostController
 * @package App\Controller
 * @Route ("/micro-post")
 */
class MicroPostController extends AbstractController
{

    /**
     * @var MicroPostRepository
     */
    private $microPostRepository;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    public function __construct(MicroPostRepository $microPostRepository, FormFactoryInterface $formFactory,
                                EntityManagerInterface $entityManager, RouterInterface $router, FlashBagInterface $flashBag)
    {
        $this->microPostRepository = $microPostRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->flashBag = $flashBag;
    }


    /**
     * @Route ("/", name="micro_post_index")
     */
    public function indexAction(): Response
    {
        $html = $this->render('micro-post/index.html.twig', [
            'posts' => $this->microPostRepository->findBy([], ['createdAt' => 'DESC']),
        ]);

        return new Response($html);
    }

    /**
     * @param MicroPost $microPost
     * @param Request $request
     * @Route ("/edit/{id}", name="micro_post_edit")
     */
    public function editAction(MicroPost $microPost, Request $request)
    {
        $form = $this->formFactory->create(MicroPostType::class, $microPost);
        $form->handleRequest($request);

        //$microPost->setCreatedAt(new \DateTime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return new RedirectResponse($this->router->generate('micro_post_index'));
        }

        return new Response($this->render('micro-post/add.html.twig',
            ['form_add_post' => $form->createView()]
        ));
    }

    /**
     * @param MicroPost $microPost
     * @Route("/delete/{id}", name="micro_post_delete")
     */
    public function deleteAction(MicroPost $microPost): RedirectResponse
    {
        $this->entityManager->remove($microPost);
        $this->entityManager->flush();

        $this->flashBag->add('notice', 'Micro post was deleted');

        return new RedirectResponse($this->router->generate('micro_post_index'));
    }


    /**
     * @Route ("/add", name="micro_post_add")
     */
    public function addPostAction(Request $request)
    {
        $microPost = new MicroPost();
        $microPost->setCreatedAt(new \DateTime());

        $form = $this->formFactory->create(MicroPostType::class, $microPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($microPost);
            $this->entityManager->flush();

            return new RedirectResponse($this->router->generate('micro_post_index'));
        }

        return new Response($this->render('micro-post/add.html.twig',
            ['form_add_post' => $form->createView()]
        ));
    }

    /**
     * @Route("/{id}", name="micro_post_postAction")
     */
    public function postAction($id)
    {
        $post = $this->microPostRepository->find($id);

        return new Response($this->render('micro-post/post.html.twig', [
            'post' => $post
        ]));
    }

}