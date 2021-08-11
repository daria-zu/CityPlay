<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\Playground;
use App\Entity\User;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class ReviewsController extends AbstractController
{
    #[Route('/add_review', name: 'add_review', methods: ['POST'])]
    public function addreview(Request $request, FileUploader $fileUploader): Response
    {
        $reviewData = $request->request;

        $entityManager = $this->getDoctrine()->getManager();
        $playground = $entityManager->getRepository(Playground::class)->find($reviewData->get('playground_id'));

        $review = new Review();

        if ($request->files->get('photo') != null) {
            $photo = $fileUploader->upload($request->files->get('photo'));
            $playground->setImage($photo);
            $review->setPhoto($photo);
        }

        $review->setText($reviewData->get('text'));
        $review->setRating($reviewData->get('rating'));
        $user = $this->getUser();
        $review->setUser($user);
        $review->setPlayground($playground);
        $entityManager->persist($review);

        // исчисление rating
        $reviewlist = $playground->getReviews();
        $sum = 0;
        $rating = 0;
        if(count($reviewlist) != 0){
            foreach($reviewlist as $review){
               $rating_by_review = $review->getRating();
               $sum = $sum + $rating_by_review;
            }
            $rating = $sum / count($reviewlist);
            $playground->setRating($rating);
        } else{
            $rating = $review->getRating();
            $playground->setRating($rating);
        }
        // return $rating = $sum / count($reviewlist);
        // $playground->setRating($rating);
        //
        
        $entityManager->flush();
        $entityManager->refresh($playground);
        return $this->json([
            'message' => 'success'
        ]);
    }


    #[Route('/review/list', name: 'get_review_list')]
    public function getReviewList(Request $request): Response
    {
        $data = $request->query;
        $index = $data->get('index');
        
        $entityManager = $this->getDoctrine()->getManager();
        $playground = $entityManager->getRepository(Playground::class)->find($data->get('index'));
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $reviews = $playground->getReviews();
        
        function f($reviews){
            foreach($reviews as &$review){
                $review=[
                    'id' => $review->getId(),
                    'text' => $review->getText(),
                    'user'=> $review->getUser()->getLogin(),
                    'added'=>$review->getAdded()->format('d.m.Y H:i:s'),
                    'playground'=>$review->getPlayground()->getId(),
                    'rating'=>$review->getRating()
               ];
            };
            return $reviews;
        };

        $jsonObject = $serializer->serialize($reviews, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['photo']
        ]);

        return $this->json([
                'reviews' => $jsonObject,
            ]);
    }

    
}