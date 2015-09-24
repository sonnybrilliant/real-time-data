<?php

namespace MlankaTech\AppBundle\Handler\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * MlankaTech\AppBundle\Handler\Security\AuthenticationSuccessHandler.
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @subpackage Handler\Security
 * @version 0.0.1
 */
class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{
    /**
     * @var Entity Manager
     */
    protected $em;
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    protected $canRedirect = false;

    public function __construct(HttpUtils $httpUtils, array $options, $container)
    {
        parent::__construct($httpUtils, $options);
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->router = $container->get('router');
    }

    /**
     * @param Request        $request
     * @param TokenInterface $token
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();
        $user->setLastLogin(new \DateTime());
        $this->em->persist($user);
        $this->em->flush();

        if ($user->getGroup()->getName() != 'Super administrator') {
            return new RedirectResponse($this->router->generate('mlanka_tech_app.user_profile', array('slug' => $user->getSlug())).'.html');
        }

        return new RedirectResponse($this->router->generate('mlankatech_app.dashboard_main').'.html');
    }
}
