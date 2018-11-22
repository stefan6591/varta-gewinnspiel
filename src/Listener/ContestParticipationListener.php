<?php
namespace App\Listener;
use App\Event\ContestParticipationSuccessEvent;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Api\ListsApi;
use SendinBlue\Client\ApiException;
use SendinBlue\Client\Model\CreateContact;
use Symfony\Component\EventDispatcher\Event;

class ContestParticipationListener {

    /** @var ContactsApi  */
    private $contactsEndpoint;

    /** @var ListsApi  */
    private $listsEndpoint;

    private $sendinBlueListId = 11;

    public function __construct(ContactsApi $contactsEndpoint, ListsApi $listsEndpoint)
    {
        $this->contactsEndpoint = $contactsEndpoint;
        $this->listsEndpoint = $listsEndpoint;
    }

    public function onSuccessAction(ContestParticipationSuccessEvent $event)
    {
        $participant = $event->getParticipant();
        $contactModel = new CreateContact();

        $attributes = [
            'VORNAME' => $participant->getFirstname(),
            'NAME' => $participant->getLastname(),
            'DOUBLE_OPT-IN' => true,
//            'ADDRESS' => $participant->getAddress(),
//            'ZIP_CODE' => $participant->getZipcode(),
//            'CITY' => $participant->getCity(),
        ];

        $contactModel->setEmail($participant->getEmail());
        $contactModel->setAttributes($attributes);
        $contactModel->setListIds([$this->sendinBlueListId]);
        $contactModel->setUpdateEnabled(true);

        try {
            $newContact = $this->contactsEndpoint->createContact($contactModel);
        } catch (ApiException $e){
            echo $e->getMessage();die;
        }
    }
}