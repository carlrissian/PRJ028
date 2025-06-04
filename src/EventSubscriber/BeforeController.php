<?php
declare(strict_types=1);


namespace App\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class BeforeController implements EventSubscriberInterface
{

    public function onKernelController(ControllerEvent $event)
    {

        $route = $event->getRequest()->attributes->get('_route');

        if ($route == 'movement.create' || $route == 'movement.list') {
            $movementTypeList = [
                1 => 'driver',
                2 => 'carrier',
                3 => 'operation'
            ];

            $movementTypeName = $event->getRequest()->attributes->get('_route_params')['movementType'];
            $movementTypeId = array_flip($movementTypeList)[$movementTypeName];

            return $event->getRequest()->query->set('movementTypeId', $movementTypeId);
        }
        if ($route == 'stopsale.create' || $route == 'stopsale.list') {
            $stopSaleList = [
                1 => 'standard',
                2 => 'oneway',
            ];

            $stopSaleName = $event->getRequest()->attributes->get('_route_params')['stopSaleCategory'];

            $stopSaleId = array_flip($stopSaleList)[$stopSaleName];

            return $event->getRequest()->query->set('stopSaleCategoryId', $stopSaleId);
        }
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}