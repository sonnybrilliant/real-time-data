<?php

namespace MlankaTech\AppBundle\EventListener\User;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Tag;
use MlankaTech\AppBundle\Event\User\UserEvent;
use MlankaTech\AppBundle\Event\User\UserEvents;
use Monolog\Logger;

/**
 * Class NewAccountCreatedListener.
 *
 * @DI\Service("listener.user_new_account_created")
 * @Tag("kernel.event_subscriber")
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 *
 * @version 0.0.1
 */
class NewAccountCreatedListener implements EventSubscriberInterface
{
    /**
     * Monolog logger.
     *
     * @var Service
     */
    private $logger;

    /**
     * Templating.
     *
     * @var Service
     */
    private $templating;

    /**
     * From email name.
     *
     * @var String
     * @@DI\Inject("%mail.from.name%")
     */
    public $fromName;

    /**
     * From email address.
     *
     * @var String
     * @DI\Inject("%mail.from.email%")
     */
    public $fromEmailAddress;

    /**
     * Site name.
     *
     * @var String
     * @DI\Inject("%site_name%")
     */
    public $siteName;

    /**
     * Mailer.
     *
     * @var Service
     */
    private $mailer;

    /**
     * Get Subscription Events.
     *
     * @return Array
     */
    public static function getSubscribedEvents()
    {
        return array(
            UserEvents::NEW_ACCOUNT_CREATED => 'onNewAccountCreated',
        );
    }

    /**
     * Class construct.
     *
     * @param Logger     $logger
     * @param Mailer     $mailer
     * @param Templating $templating
     *
     * @DI\InjectParams({
     *     "logger"         = @DI\Inject("logger"),
     *     "mailer"         = @DI\Inject("mailer"),
     *     "templating"     = @DI\Inject("templating")
     * })
     */
    public function __construct(
        Logger $logger,
        \Swift_Mailer $mailer,
        $templating
    ) {
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * Send email on new account create event.
     *
     * @param UserEvent $user
     */
    public function onNewAccountCreated(UserEvent $user)
    {
        $this->logger->info('NewAccountCreatedListener onNewAccountCreate()');

        try {
            $this->send($this->buildTemplate($user->getUser()));
        } catch (\Exception $e) {
            $this->logger->error('NewAccountCreatedListener onNewAccountCreate() Exception:'.$e->getMessage());
            throw new Exception($e);
        }
    }

    /**
     * Build email template.
     *
     * @param Mlanka $user
     *
     * @return array
     */
    private function buildTemplate($user)
    {
        $this->logger->info('NewAccountCreatedListener buildTemplate()');

        $email = array();
        $email['subject'] = 'Your account has been created on '.$this->siteName;
        $email['fullName'] = $user->getFullName();
        $email['password'] = $user->getTransient();
        $email['username'] = $user->getEmail();
        $email['emailAddress'] = $user->getEmail();

        $email['bodyHTML'] = $this->templating->render(
            'MlankaTechAppBundle:Email/Html/User:new_account_created.html.twig',
            $email
        );

        $email['bodyTEXT'] = $this->templating->render(
            'MlankaTechAppBundle:Email/Text/User:new_account_created.txt.twig',
            $email
        );

        return $email;
    }

    /**
     * Send email.
     *
     * @param array $email
     */
    private function send($email)
    {
        $this->logger->info('NewAccountCreatedListener send()');

        $message = \Swift_Message::newInstance()
            ->setSubject($email['subject'])
            ->setFrom(array($this->fromEmailAddress => $this->fromName))
            ->setTo($email['emailAddress'])
            ->setBody($email['bodyHTML'], 'text/html')
            ->addPart($email['bodyTEXT'], 'text/plain');
        $this->mailer->send($message);
    }
}
