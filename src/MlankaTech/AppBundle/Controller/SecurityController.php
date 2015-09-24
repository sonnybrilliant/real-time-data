<?php

namespace MlankaTech\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'MlankaTechAppBundle:Security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * Forgot password.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function forgotPasswordAction(Request $request)
    {
        $this->get('logger')->info('SecurityController forgotPasswordAction()');
        $error = '';

        $formHandler = $this->get('forgot_password.form_handler');
        $form = $this->createForm('UserForgotPasswordType');

        if ($formHandler->handle($request,$form)) {
            return $this->redirect($this->generateUrl('_security_login').'.html');
        }

        return $this->render(
            'MlankaTechAppBundle:Security:forgot.password.html.twig',array(
                'error' => $error,
                'form' => $form->createView(),
            ));
    }

    /**
     * Reset password.
     *
     * @param Request $request
     * @param $authString
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function resetPasswordAction(Request $request, $authString)
    {
        $this->get('logger')->info('SecurityController resetPasswordAction()');

        $user = $this->get('user.manager')->getByForgotPassword($authString);

        if (!$user) {
            $this->get('logger')->error('SecurityController resetPasswordAction() Error invalid reset link:'.$authString);
            $this->get('flash.message.manager')->getErrorMessage('Invalid reset link. Please retry to reset the password again.');
            return $this->redirect($this->generateUrl('_forgot_password'));
        }

        $form = $this->createForm('UserPasswordResetType', $user);
        $formHandler = $this->get('reset_password.form_handler');

        if ($formHandler->handle($request, $form)) {
            //redirect to the login page.
            return $this->redirect($this->generateUrl('_security_login').'.html');
        }

        return $this->render('MlankaTechAppBundle:Security:reset.password.html.twig', array(
            'authString' => $authString,
            'form' => $form->createView(),
        ));
    }
}