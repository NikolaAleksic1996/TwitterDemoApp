<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Participant;
use App\Repository\ConversationRepository;
use App\Repository\ParticipantRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/conversations", name="conversations.")
 */
class ConversationController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var ConversationRepository
     */
    private $conversationRepository;

    /**
     * ConversationController constructor.
     */
    public function __construct(UserRepository $userRepository,
                                EntityManagerInterface $manager,
                                ConversationRepository $conversationRepository)
    {
        $this->userRepository = $userRepository;
        $this->manager = $manager;
        $this->conversationRepository = $conversationRepository;
    }


    /**
     * @Route("/", name="getCreateConversations", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function createConversationAction(Request $request): JsonResponse
    {
        $otherUser = $request->get('otherUser', 0);
        $otherUser = $this->userRepository->find($otherUser);

        if(is_null($otherUser)){
            throw new Exception("The user was not found!");
        }

        //cannot create conversation with yourself
        if($otherUser->getId() === $this->getUser()->getId()){
            throw new Exception("You cannot create conversation with yourself!");
        }

        //Check if conversation already exists
        $conversation = $this->conversationRepository->findConversationByParticipants(
            $otherUser->getId(),
            $this->getUser()->getId()
        );

        if(count($conversation)){
            throw new Exception("The conversation already exists");
        }

        $conversation = new Conversation();

        $participant = new Participant();
        $participant->setUser($this->getUser());
        $participant->setConversation($conversation);

        $otherParticipant = new Participant();
        $otherParticipant->setUser($otherUser);
        $otherParticipant->setConversation($conversation);

        $this->manager->getConnection()->beginTransaction();

        try {
            $this->manager->persist($conversation);
            $this->manager->persist($participant);
            $this->manager->persist($otherParticipant);

            $this->manager->flush();
            $this->manager->commit();

        }catch (\Exception $e){
            $this->manager->rollback();
            throw $e;
        }


        return $this->json([
            'id' => $conversation->getId()
        ], Response::HTTP_CREATED, [], []);
    }

    /**
     * @Route ("/", name="getConversations", methods={"GET"})
     */
    public function getConversationAction()
    {
        $conversations = $this->conversationRepository->findConversationsByUser($this->getUser()->getId());
        dd($conversations);

    }

    /**
     * @Route ("/list")
     */
    public function listAction(Request $request)
    {
        $search = $request->query->get('q');

        if($search){
            $conversations = $this->conversationRepository->search($search);
            dd($conversations);
        }else{
            $conversations = $this->conversationRepository->findAllOrdered();
        }

        dd($conversations);
    }
}
