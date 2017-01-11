<?php
namespace Tx\Bnbfilesharing\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Tx\Bnbfilesharing\Domain\Model\Folder;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * @package filesharing
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 * @method Folder findByUid($uid)
 * @method Folder findOneByFolder(int $folderUid)
 */
class FolderRepository extends Repository
{
    /**
     * Get sorted folders
     *
     * @param int $uid
     * @param string $OrderByfild
     * @param string $Direction
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface|Folder[]
     */
    public function findSortedByFolder($uid, $OrderByfild, $Direction)
    {
        $query = $this->createQuery();

        if ($Direction === 'desc') {
            $query->setOrderings([$OrderByfild => Query::ORDER_DESCENDING]);
        } else {
            $query->setOrderings([$OrderByfild => Query::ORDER_ASCENDING]);
        }


        $constraint = $query->equals('folder', $uid);
        return $query->matching($constraint)->execute();
    }
}
