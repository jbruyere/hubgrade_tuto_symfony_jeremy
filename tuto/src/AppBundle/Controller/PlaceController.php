<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Get;
use AppBundle\Entity\Log;

class PlaceController extends Controller
{
	/**
     * @Get("/place")
     */
    public function getPlacesAction(Request $request)
    {
        $login = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Log')
                ->findAll();
        /* @var $login Log[] */

        $formatted = [];
        foreach ($login as $log) {
            $formatted[] = [
               'login' => $log->getLogin(),
               'password' => $log->getPassword(),
            ];
        }

        return new JsonResponse($formatted);
    }

	/**
     * @Get("/login/{id}")
     */
    public function getPlaceAction($id, Request $request)
    {
        $log = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Log')
                ->find($id);
        /* @var $login Log */

        if (empty($place)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        $formatted = [
			'login' => $log->getLogin(),
			'password' => $log->getPassword(),
        ];

        return new JsonResponse($formatted);
    }
}