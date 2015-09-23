<?php

namespace MlankaTech\AppBundle\Event\User;

/**
 * MlankaTech\AppBundle\Event\User\UserEvents.
 *
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 *
 * @version 0.0.1
 */
class UserEvents
{
    const NEW_ACCOUNT_CREATED = 'mlanka_tech_app.user_new_account_created';
    const ON_ACCOUNT_FORGOT_PASSWORD = 'mlanka_tech_app.user_forgot_password';
    const ON_ACCOUNT_SUSPEND = 'mlanka_tech_app.user_account_suspend';
    const ON_ACCOUNT_ACTIVATE = 'mlanka_tech_app.user_account_activate';
}
