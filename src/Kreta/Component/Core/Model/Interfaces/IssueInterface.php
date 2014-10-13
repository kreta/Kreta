<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\CoreBundle\Model\Interfaces;

/**
 * Interface IssueInterface.
 *
 * @package Kreta\CoreBundle\Model\Interfaces
 */
interface IssueInterface
{
    const PRIORITY_LOW = 0;
    const PRIORITY_MEDIUM = 1;
    const PRIORITY_HIGH = 2;
    const PRIORITY_BLOCKING = 3;

    const STATUS_TODO = 0;
    const STATUS_DOING = 1;
    const STATUS_DONE = 2;

    const RESOLUTION_FIXED = 0;
    const RESOLUTION_WONT_FIX = 1;
    const RESOLUTION_DUPLICATE = 2;
    const RESOLUTION_INCOMPLETE = 3;
    const RESOLUTION_CANNOT_REPRODUCE = 4;

    const TYPE_BUG = 0;
    const TYPE_NEW_FEATURE = 1;
    const TYPE_IMPROVEMENT = 2;
    const TYPE_EPIC = 3;
    const TYPE_STORY = 4;

    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Gets assignee.
     *
     * @return \Kreta\CoreBundle\Model\Interfaces\UserInterface
     */
    public function getAssignee();

    /**
     * Sets the assignee.
     *
     * @param \Kreta\CoreBundle\Model\Interfaces\UserInterface
     *
     * @return $this self Object
     */
    public function setAssignee(UserInterface $assigner);

    /**
     * Gets comments.
     *
     * @return \Kreta\CoreBundle\Model\Interfaces\CommentInterface[]
     */
    public function getComments();

    /**
     * Adds the comment.
     *
     * @param \Kreta\CoreBundle\Model\Interfaces\CommentInterface
     *
     * @return $this self Object
     */
    public function addComment(CommentInterface $comment);

    /**
     * Removes the comment.
     *
     * @param \Kreta\CoreBundle\Model\Interfaces\CommentInterface
     *
     * @return $this self Object
     */
    public function removeComment(CommentInterface $comment);

    /**
     * Gets description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Sets description.
     *
     * @param string $description The description
     *
     * @return $this self Object
     */
    public function setDescription($description);

    /**
     * Gets labels.
     *
     * @return \Kreta\CoreBundle\Model\Interfaces\LabelInterface[]
     */
    public function getLabels();

    /**
     * Adds the labels.
     *
     * @param \Kreta\CoreBundle\Model\Interfaces\LabelInterface
     *
     * @return $this self Object
     */
    public function addLabel(LabelInterface $label);

    /**
     * Removes the label.
     *
     * @param \Kreta\CoreBundle\Model\Interfaces\LabelInterface
     *
     * @return $this self Object
     */
    public function removeLabel(LabelInterface $label);

    /**
     * Gets priority.
     *
     * @return string
     */
    public function getPriority();

    /**
     * Sets labels.
     *
     * @param string $priority The priority that can be "low", "medium", "high" or "blocking"
     *
     * @return $this self Object
     */
    public function setPriority($priority);

    /**
     * Gets reporter.
     *
     * @return \Kreta\CoreBundle\Model\Interfaces\UserInterface
     */
    public function getReporter();

    /**
     * Sets the reporter.
     *
     * @param \Kreta\CoreBundle\Model\Interfaces\UserInterface
     *
     * @return $this self Object
     */
    public function setReporter(UserInterface $reporter);

    /**
     * Gets resolution.
     *
     * @return string
     */
    public function getResolution();

    /**
     * Sets resolution.
     *
     * @param string $resolution The resolution that can be "fixed", "won't fix",
     *                           "duplicate", "incomplete" or "cannot reproduce"
     *
     * @return $this self Object
     */
    public function setResolution($resolution);

    /**
     * Gets status.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Sets status.
     *
     * @param string $status The status that can be "todo", "doing" or "done"
     *
     * @return $this self Object
     */
    public function setStatus($status);

    /**
     * Gets type.
     *
     * @return string
     */
    public function getType();

    /**
     * Sets type.
     *
     * @param string $type The type that can be "bug", "new feature", "improvement", "epic" or "story"
     *
     * @return $this self Object
     */
    public function setType($type);

    /**
     * Gets title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Sets title.
     *
     * @param string $title The title
     *
     * @return $this self Object
     */
    public function setTitle($title);

    /**
     * Gets watchers.
     *
     * @return \Kreta\CoreBundle\Model\Interfaces\UserInterface[]
     */
    public function getWatchers();

    /**
     * Adds the watcher.
     *
     * @param \Kreta\CoreBundle\Model\Interfaces\UserInterface
     *
     * @return $this self Object
     */
    public function addWatcher(UserInterface $watcher);

    /**
     * Removes the watcher.
     *
     * @param \Kreta\CoreBundle\Model\Interfaces\UserInterface
     *
     * @return $this self Object
     */
    public function removeWatcher(UserInterface $watcher);
}
