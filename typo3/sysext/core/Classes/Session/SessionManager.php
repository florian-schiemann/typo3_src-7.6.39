<?php

namespace TYPO3\CMS\Core\Session;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Authentication\AbstractUserAuthentication;

class SessionManager
{
    /**
     * Removes all sessions for a specific user ID
     *
     * @param string $backend see constants
     * @param int $userId
     * @param AbstractUserAuthentication $userAuthentication
     */
    public function invalidateAllSessionsByUserId($backend, $userId, AbstractUserAuthentication $userAuthentication = null)
    {
        $sessionToRenew = '';
        // Prevent destroying the session of the current user session, but renew session id
        if ($userAuthentication !== null && (int)$userAuthentication->user['uid'] === $userId) {
            $sessionToRenew = $userAuthentication->id;
        }

        $sessionTable = $backend === 'BE' ? 'be_sessions' : 'fe_sessions';

        foreach ($this->getAll($sessionTable) as $session) {
            if ($userAuthentication !== null && $session['ses_id'] === $sessionToRenew) {
                $userAuthentication->enforceNewSessionId();
                continue;
            }
            if ((int)$session['ses_userid'] === $userId) {
                $this->remove($sessionTable, $session['ses_id']);
            }
        }
    }

    protected function getAll($table)
    {
        return $this->getDatabaseConnection()->exec_SELECTquery(
            '*',
            $table,
            ''
        );
    }

    protected function remove($table, $sessionId)
    {
        $sessionId = $this->getDatabaseConnection()->fullQuoteStr($sessionId, $table);
        $this->getDatabaseConnection()->exec_DELETEquery($table, 'ses_id = ' . $sessionId);
    }

    /**
     * Returns the database connection
     *
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
