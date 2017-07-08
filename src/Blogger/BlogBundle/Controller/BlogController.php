<?php
// src/Blogger/BlogBundle/Controller/BlogController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Blog controller.
 */

class BlogController extends Controller
{
    /**
     * Show a blog entry
     */
    public function showAction($id, $slug, $comments, Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }
        if (isset($_POST['likes'])) {
             $count = 0;
             $like = $em->getRepository('BloggerBlogBundle:Blog')->find($id);
             $like->setLikes(++$count);
             $em->flush();
         }

        $comments = $em->getRepository('BloggerBlogBundle:Comment')
                       ->getCommentsForBlog($blog->getId());

        return $this->render('BloggerBlogBundle:Blog:show.html.twig', array(
        'blog'      => $blog,
        'comments'  => $comments
        ));
    }
}