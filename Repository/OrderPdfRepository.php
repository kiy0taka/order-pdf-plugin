<?php
/*
 * This file is part of the OrderPdf plugin
 *
 * Copyright (C) 2016 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\OrderPdf\Repository;

use Doctrine\ORM\EntityRepository;
use Eccube\Common\Constant;
use Eccube\Entity\Member;
use Plugin\OrderPdf\Entity\OrderPdf;

/**
 * OrderPdfRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrderPdfRepository extends EntityRepository
{
    public function save(array $arrData)
    {
        /**
         * @var Member $Member
         */
        $Member = $arrData['admin'];
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $OrderPdf = $this->find($Member);
            if (!$OrderPdf) {
                $OrderPdf = new OrderPdf();
            }

            $OrderPdf->setId($Member->getId())
                ->setIssueDate($arrData['issue_date'])
                ->setTitle($arrData['title'])
                ->setMessage1($arrData['message1'])
                ->setMessage2($arrData['message2'])
                ->setMessage3($arrData['message3'])
                ->setNote1($arrData['note1'])
                ->setNote2($arrData['mote2'])
                ->setNote3($arrData['note3'])
                ->setDelFlg(Constant::DISABLED);
            $em->persist($OrderPdf);
            $em->flush($OrderPdf);
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollBack();

            return false;
        }

        return true;
    }
}
