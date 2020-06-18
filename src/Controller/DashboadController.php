<?php
namespace App\Controller;
use App\Entity\Comentarios;
use App\Entity\Posts;
use App\Entity\User;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class DashboadController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(PaginatorInterface  $paginator, Request $request)
    {

       $em = $this->getDoctrine()->getManager();
       $posts = $em->getRepository(Posts::class)->findAll();
     //   $posts = $em->getRepository(Posts::class)->findOneBy(['titulo' => '1']);
     //   $posts = $em->getRepository(Posts::class)->BuscarTodosPosts();
        $custom_query = $em->getRepository(Posts::class)->BuscarTodosPosts();
        $pagination = $paginator->paginate($custom_query, $request->query->getInt('page', 1),5);

        // not recomendet from symfony
        $user = $this->getUser();
        $user_nombre = '';
        if($user){
            $user_nombre = $user->getNombre();
        }
      //  dump($user);
      // if (!$user) {
      //     echo 'Denegado'; exit();
      // }
       // $coments = $em->getRepository(Posts::class)->buscarcomentarios($user->getId());

        $usuarios = $em->getRepository(User::class)->buscarusuarios();


        $repository = $em->getRepository(Comentarios::class);
        $resultscom = $repository->findBy(array(),array('id'=>'DESC'),7,0);
        $latestcoments = $em->getRepository(Comentarios::class)->getLatestComments();

        return $this->render('dashboad/index.html.twig', [
            'posts' => $posts,
            'pagination' => $pagination,
            'user' => $user,
            'user_nombre' => $user_nombre,
            'usuarios' => $usuarios,
            'comments' => $resultscom,
            'latestcom' => $latestcoments,


        ]);
    }
}
