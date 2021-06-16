<?php


namespace App\Controller;


use App\Service\Greeting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\TwigBundle\DependencyInjection\Compiler\TwigEnvironmentPass;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class BlogController
 * @package App\Controller
 */
class BlogController extends AbstractController
{


    private $session;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(SessionInterface $session, RouterInterface $router)
    {
        $this->session = $session;
        $this->router = $router;
    }

    /**
     * @return Response
     * @Route("/", name="blog_index")
     */
    /*parameters {name} changes the Response object, name parameter (argument) add to this action and
    //it will be automatically injected for us
    indexAction(Request $request)  ,   greet($request->get('name'))
    */
    public function indexAction(): Response
    {
        $html = $this->render('blog/index.html.twig', [
            'posts' => $this->session->get('posts')
        ]);

        return new Response($html);
    }

    /**
     * @Route("/add", name="blog_add")
     */
    public function addPostAction(): RedirectResponse
    {
        $posts = $this->session->get('posts');
        $posts[uniqid()] = [
            'title' => 'A random title '.rand(1, 500),
            'text' => 'A random text npr '.rand(1, 500),
            'date' => new \DateTime(),
        ];
        $this->session->set('posts', $posts);

        /*
         *after add post, we want it to take us to the home page (blog_index)
         */
        return new RedirectResponse($this->router->generate('blog_index'));
    }

    /**
     * @param $id
     * @return Response
     * @Route ("/show/{id}", name="blog_show")
     */
    public function showPostAction($id): Response
    {
        $posts = $this->session->get('posts');

        if(!$posts || !isset($posts[$id]))
        {
            throw new NotFoundHttpException('Post not found');
        }

        $html = $this->render('blog/post.html.twig',[
            'id' => $id,
            'post' => $posts[$id],
        ]);

        return new Response($html);
    }
}