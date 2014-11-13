<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Model;

/**
 * Interface PullRequestInterface
 *
 * @package Kreta\Component\VCS\Model
 */
interface PullRequestInterface
{
    public function getId();

    public function getSHA();

    public function getMessage();

    public function getAuthor();

    public function getIssuesRelated();
}
