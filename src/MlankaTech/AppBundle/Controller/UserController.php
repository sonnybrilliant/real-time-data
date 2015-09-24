<?php

namespace MlankaTech\AppBundle\Controller;

use MlankaTech\AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MlankaTech\AppBundle\Form\Model\UserChangePassword;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;

class UserController extends Controller
{

    /**
     * List all users
     * @param Request $request
     * @param int $page
     * @Secure(roles="ROLE_USER_LIST")
     * @return array
     */
    public function listAction(Request $request, $page = 1)
    {
        $this->get('logger')->info('UserController listAction()');
        $handler = $this->get('mlanka_tech_app.user_list_handler');
        $pagination = $handler->handle($request,$page);
        $showOptions = array(10, 20, 30, 40, 50);

        return $this->render('MlankaTechAppBundle:User:list.html.twig',array(
            'action' => 'user_list',
            'pagination' => $pagination['pagination'],
            'direction' => $pagination['direction'],
            'page_header' => 'List users',
            'breadcrumb' => 'List',
            'showOptions' => $showOptions,
            'showSelected' => $pagination['show'],
        ));
    }

    /**
     * User profile
     *
     * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param User $user
     * @ParamConverter("train", class="MlankaTechAppBundle:User", options={"slug" = "slug"})
     * @Template("MlankaTechAppBundle:User:profile.html.twig")
     * @Secure(roles="ROLE_USER_PROFILE")
     */
    public function profileAction(Request $request, User $user)
    {
        $this->get('logger')->info('UserController profileAction()');
        $form = $this->createForm("UserShowType",$user);

        $loggedInUser = $this->getUser();

        $pageHeader = "User profile";
        if($loggedInUser->getId() == $user->getId()){
            $pageHeader = "My profile";
        }

        return array(
            'action' => 'user_profile',
            'user'=> $user,
            'form' => $form->createView(),
            'page_header' => $pageHeader,
            'breadcrumb' => 'Profile'
        );
    }

    /**
     * Create user
     *
     * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
     * @param Request $request
     * @Secure(roles="ROLE_USER_CREATE")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $this->get('logger')->info('UserController createAction()');

        $user = new User();
        $form = $this->createForm("UserCreateType",$user);
        $user->setPassword(substr(base_convert(bin2hex(hash('sha256', uniqid(mt_rand(), true), true)), 16, 20), 0, 10));
        $formHandler = $this->get('mlanka_tech_app.user_create_handler');
        if($formHandler->handle($form,$request)){
            return $this->redirect($this->generateUrl('mlanka_tech_app.user_list') . '.html');
        }

        return $this->render('MlankaTechAppBundle:User:create.html.twig',array(
            'action' => 'user_create',
            'user'=> $user,
            'form' => $form->createView(),
            'page_header' => 'Add new user',
            'breadcrumb' => 'Add'
        ));
    }

    /**
     * Edit user
     *
     * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
     * @param Request $request
     * @param User $user
     * @Secure(roles="ROLE_USER_EDIT")
     * @ParamConverter("artist", class="MlankaTechAppBundle:User", options={"slug" = "slug"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request,User $user)
    {
        $this->get('logger')->info('UserController editAction()');

        $form = $this->createForm("UserEditType",$user);

        $formHandler = $this->get('mlanka_tech_app.user_edit_handler');
        if($formHandler->handle($form,$request)){
            return $this->redirect($this->generateUrl('mlanka_tech_app.user_list') . '.html');
        }

        $loggedInUser = $this->getUser();

        $pageHeader = "Edit user profile";
        if($loggedInUser->getId() == $user->getId()){
            $pageHeader = "Edit my profile";
        }

        return $this->render('MlankaTechAppBundle:User:edit.html.twig',array(
            'action' => 'user_edit',
            'user'=> $user,
            'form' => $form->createView(),
            'page_header' => $pageHeader,
            'breadcrumb' => 'Edit'
        ));
    }

    /**
     * @param Request $request
     * @param User    $user
     * @ParamConverter("artist", class="MlankaTechAppBundle:User", options={"slug" = "slug"})
     * @Secure(roles="ROLE_USER_EDIT")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function changePasswordAction(Request $request, User $user)
    {
        $this->get('logger')->info('UserController changePasswordAction()');

        if ($this->getUser()->getId() != $user->getId()) {
            $flashManager = $this->get('flash.message.manager');
            $flashManager->getWarningMessage('An illegal action was performed and the system has logged it.');
            return $this->redirect($this->generateUrl('mlanka_tech_app.user_profile', array('slug' => $this->getUser()->getSlug())).'.html');
        }

        $form = $this->createForm("UserChangePasswordType", new UserChangePassword());
        $formHandler = $this->get('mlanka_tech_app.user_change_password_handler');
        if ($formHandler->handle($form, $request, $user)) {
            return $this->redirect($this->generateUrl('mlanka_tech_app.user_profile', array('slug' => $user->getSlug())));
        }

        return $this->render('MlankaTechAppBundle:User:change.password.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
            'action' => 'user_change_password',
            'page_header' => 'Change password',
            'breadcrumb' => 'Change password',
        ));
    }

    /**
     * Suspend user.
     *
     * @param Request $request
     * @param User    $user
     * @Secure(roles="ROLE_ADMIN")
     * @ParamConverter("operator", class="MlankaTechAppBundle:User", options={"slug" = "slug"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function suspendAction(Request $request, User $user)
    {
        $this->get('logger')->info('UserController suspendAction()');

        $this->get('user.manager')->suspend($user);
        $this->get('flash.message.manager')->getSuccessMessage('User account suspended successfully.');

        return $this->redirect($this->generateUrl('mlanka_tech_app.user_list').'.html');
    }

    /**
     * Activate user.
     *
     * @param Request $request
     * @param User    $user
     * @Secure(roles="ROLE_ADMIN")
     * @ParamConverter("operator", class="MlankaTechAppBundle:User", options={"slug" = "slug"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function activateAction(Request $request, User $user)
    {
        $this->get('logger')->info('UserController activateAction()');

        $this->get('user.manager')->activate($user);
        $this->get('flash.message.manager')->getSuccessMessage('User account activated successfully.');

        return $this->redirect($this->generateUrl('mlanka_tech_app.user_list').'.html');
    }

}