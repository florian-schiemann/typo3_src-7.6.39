.. include:: ../../Includes.txt

==================================================================
Important: #87298 - [SECURITY] Destroy sessions on password change
==================================================================

See :issue:`87298`

Description
===========

If a user - backend or frontend - change the password, all existing sessions
must be destroyed for security reasons.

In the core, we added functionality which takes care of this task with a DataHandler hook.
Changing passwords in the backend will destroy all existing sessions of the edited user.

The frontend login extension takes care of this task if the user resets a password (password recovery process).

For all third party extensions which also handle password changes we added a method to
the SessionManager class to easily integrate this important task, please check the code below:

.. code-block:: php

   # For any example below, we need the SessionManager
   use \TYPO3\CMS\Core\Session\SessionManager;

   # 1) Example: Destroy all backend user sessions for a backend user
   $sessionManager = GeneralUtility::makeInstance(SessionManager::class);
   $sessionManager->invalidateAllSessionsByUserId('BE', (int)$id);

   # 2) Example: Destroy all frontend user sessions for a frontend user
   $sessionManager = GeneralUtility::makeInstance(SessionManager::class);
   $sessionManager->invalidateAllSessionsByUserId('FE', (int)$id);

   # 3) Example: Destroy all backend user sessions for a backend user but keep and renew current backend user session
   $sessionManager = GeneralUtility::makeInstance(SessionManager::class);
   $sessionManager->invalidateAllSessionsByUserId('BE', (int)$id, $GLOBALS['BE_USER']);

   # 4) Example: Destroy all frontend user sessions for a frontenf user but keep and renew current frontend user session
   $sessionManager = GeneralUtility::makeInstance(SessionManager::class);
   $sessionManager->invalidateAllSessionsByUserId('FE', (int)$id, $GLOBALS['TSFE']->fe_user);

.. index:: Backend, Frontend, PHP-API, ext:core
