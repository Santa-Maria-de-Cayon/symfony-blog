<?php

namespace App\Controller;
use App\Entity\Comentarios;
use App\Entity\Posts;
use App\Form\ComentariosType;
use App\Form\PostsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostsController extends AbstractController
{
    /**
     * @Route("/crear_post", name="crear_post")
     */
    public function index(Request $request, SluggerInterface $slugger)
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid()){

            $brochureFile = $form->get('foto')->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'_'.uniqid().'.'. $brochureFile->guessExtension() ;
                try {
                    $brochureFile->move($this->getParameter('brochures_directory'), $newFilename);
                } catch (FileException $e) {
                    throw new \Exception("One error ocurried: " . $e);
                }
                $post->setFoto($newFilename);
            }

            $user = $this->getUser();
            $post->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('posts/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/post/{id}", name="see_only_post", methods={"GET","POST"})
     */
    public function VerPost($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Posts::class)->find($id);

        // my creative work
        $coments = new Comentarios();
        $formm = $this->createForm(ComentariosType::class, $coments);
        $formm->handleRequest($request);

        if ( $formm->isSubmitted() && $formm->isValid() ){
            $user = $this->getUser();
            $coments->setUser($user);
            $coments->setPost($post);
            $coments->setFechaPublicacion(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($coments);
            $em->flush();
            return $this->redirectToRoute('dashboard');
        }


        return $this->render('posts/post.html.twig', [
            'post' => $post,
            'for' => $formm->createView(),
            ]);
    }



    /**
     * @Route("/my_posts", name="my_posts")
     */
     public function mis_posts(){
         $em    = $this->getDoctrine()->getManager();
         $user  = $this->getUser();

         $posts = $em->getRepository(Posts::class)->findBy(['user' => $user]);
         return $this->render('posts/my_post.html.twig', [
                 'post' => $posts,
                 'user' => $user, ]);
     }


    /**
     * @Route("/likes", options={"expose"=true}, name="likes")
     */
     public function ajaxlikes(Request $request){
         if( $request->isXmlHttpRequest() ){
          $em = $this->getDoctrine()->getManager();
          $user = $this->getUser();
          $id = $request->get('id');
          $post = $em->getRepository(Posts::class)->find($id);
          $likes = $post->getLikes();
          $likes .= $user->getId().'.';
          $post->setLikes($likes);
          $em->flush();
           return new JsonResponse(['likes' => $likes ]);
         } else {
             throw new \Exception ('Hola, hola');
         }
     }


}



































