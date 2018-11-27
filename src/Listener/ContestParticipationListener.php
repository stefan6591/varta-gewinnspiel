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

    /** @var int  */
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
            'DOUBLE_OPT-IN' => 2
        ];

        $contactModel->setEmail($participant->getEmail());
        $contactModel->setAttributes($attributes);
        $contactModel->setListIds([$this->sendinBlueListId]);
        $contactModel->setUpdateEnabled(true);

        $newContact = $this->contactsEndpoint->createContact($contactModel);
    }
}