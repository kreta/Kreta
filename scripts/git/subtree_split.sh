#!/bin/sh

# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

echo "Generating the subtree splits..."
if [ $# -eq 0 ]; then
    echo "No tag argument provided"
    exit 1
fi

git tag -d $1

git subtree split -P src/Kreta/Bundle/CommentBundle/ -b comment-bundle
git tag -a $1 -m $1 comment-bundle
git push git@github.com:kreta-io/CommentBundle.git comment-bundle:master
git push git@github.com:kreta-io/CommentBundle.git comment-bundle:master --follow-tags
git branch -D comment-bundle
git tag -d $1

git subtree split -P src/Kreta/Bundle/CoreBundle/ -b core-bundle
git tag -a $1 -m $1 core-bundle
git push git@github.com:kreta-io/CoreBundle.git core-bundle:master
git push git@github.com:kreta-io/CoreBundle.git core-bundle:master --follow-tags
git branch -D core-bundle
git tag -d $1

git subtree split -P src/Kreta/Bundle/FixturesBundle/ -b fixtures-bundle
git tag -a $1 -m $1 fixtures-bundle
git push git@github.com:kreta-io/FixturesBundle.git fixtures-bundle:master
git push git@github.com:kreta-io/FixturesBundle.git fixtures-bundle:master --follow-tags
git branch -D fixtures-bundle
git tag -d $1

git subtree split -P src/Kreta/Bundle/IssueBundle/ -b issue-bundle
git tag -a $1 -m $1 issue-bundle
git push git@github.com:kreta-io/IssueBundle.git issue-bundle:master
git push git@github.com:kreta-io/IssueBundle.git issue-bundle:master --follow-tags
git branch -D issue-bundle
git tag -d $1

git subtree split -P src/Kreta/Bundle/MediaBundle/ -b media-bundle
git tag -a $1 -m $1 media-bundle
git push git@github.com:kreta-io/MediaBundle.git media-bundle:master
git push git@github.com:kreta-io/MediaBundle.git media-bundle:master --follow-tags
git branch -D media-bundle
git tag -d $1

git subtree split -P src/Kreta/Bundle/NotificationBundle/ -b notification-bundle
git tag -a $1 -m $1 notification-bundle
git push git@github.com:kreta-io/NotificationBundle.git notification-bundle:master
git push git@github.com:kreta-io/NotificationBundle.git notification-bundle:master --follow-tags
git branch -D notification-bundle
git tag -d $1

git subtree split -P src/Kreta/Bundle/ProjectBundle/ -b project-bundle
git tag -a $1 -m $1 project-bundle
git push git@github.com:kreta-io/ProjectBundle.git project-bundle:master
git push git@github.com:kreta-io/ProjectBundle.git project-bundle:master --follow-tags
git branch -D project-bundle
git tag -d $1

git subtree split -P src/Kreta/Bundle/TimeTrackingBundle/ -b timeTracking-bundle
git tag -a $1 -m $1 timeTracking-bundle
git push git@github.com:kreta-io/TimeTrackingBundle.git timeTracking-bundle:master
git push git@github.com:kreta-io/TimeTrackingBundle.git timeTracking-bundle:master --follow-tags
git branch -D timeTracking-bundle
git tag -d $1

git subtree split -P src/Kreta/Bundle/UserBundle/ -b user-bundle
git tag -a $1 -m $1 user-bundle
git push git@github.com:kreta-io/UserBundle.git user-bundle:master
git push git@github.com:kreta-io/UserBundle.git user-bundle:master --follow-tags
git branch -D user-bundle
git tag -d $1

git subtree split -P src/Kreta/Bundle/VCSBundle/ -b vcs-bundle
git tag -a $1 -m $1 vcs-bundle
git push git@github.com:kreta-io/VCSBundle.git vcs-bundle:master
git push git@github.com:kreta-io/VCSBundle.git vcs-bundle:master --follow-tags
git branch -D vcs-bundle
git tag -d $1

git subtree split -P src/Kreta/Bundle/WebBundle/ -b web-bundle
git tag -a $1 -m $1 web-bundle
git push git@github.com:kreta-io/WebBundle.git web-bundle:master
git push git@github.com:kreta-io/WebBundle.git web-bundle:master --follow-tags
git branch -D web-bundle
git tag -d $1

git subtree split -P src/Kreta/Bundle/WorkflowBundle/ -b workflow-bundle
git tag -a $1 -m $1 workflow-bundle
git push git@github.com:kreta-io/WorkflowBundle.git workflow-bundle:master
git push git@github.com:kreta-io/WorkflowBundle.git workflow-bundle:master --follow-tags
git branch -D workflow-bundle
git tag -d $1

#######################################################################################################################
#######################################################################################################################

git subtree split -P src/Kreta/Component/Comment/ -b comment
git tag -a $1 -m $1 comment
git push git@github.com:kreta-io/Comment.git comment:master
git push git@github.com:kreta-io/Comment.git comment:master --follow-tags
git branch -D comment
git tag -d $1

git subtree split -P src/Kreta/Component/Core/ -b core
git tag -a $1 -m $1 core
git push git@github.com:kreta-io/Core.git core:master
git push git@github.com:kreta-io/Core.git core:master --follow-tags
git branch -D core
git tag -d $1

git subtree split -P src/Kreta/Component/Issue/ -b issue
git tag -a $1 -m $1 issue
git push git@github.com:kreta-io/Issue.git issue:master
git push git@github.com:kreta-io/Issue.git issue:master --follow-tags
git branch -D issue
git tag -d $1

git subtree split -P src/Kreta/Component/Media/ -b media
git tag -a $1 -m $1 media
git push git@github.com:kreta-io/Media.git media:master
git push git@github.com:kreta-io/Media.git media:master --follow-tags
git branch -D media
git tag -d $1

git subtree split -P src/Kreta/Component/Notification/ -b notification
git tag -a $1 -m $1 notification
git push git@github.com:kreta-io/Notification.git notification:master
git push git@github.com:kreta-io/Notification.git notification:master --follow-tags
git branch -D notification
git tag -d $1

git subtree split -P src/Kreta/Component/Project/ -b project
git tag -a $1 -m $1 project
git push git@github.com:kreta-io/Project.git project:master
git push git@github.com:kreta-io/Project.git project:master --follow-tags
git branch -D project
git tag -d $1

git subtree split -P src/Kreta/Component/TimeTracking/ -b timeTracking
git tag -a $1 -m $1 timeTracking
git push git@github.com:kreta-io/TimeTracking.git timeTracking:master
git push git@github.com:kreta-io/TimeTracking.git timeTracking:master --follow-tags
git branch -D timeTracking
git tag -d $1

git subtree split -P src/Kreta/Component/User/ -b user
git tag -a $1 -m $1 user
git push git@github.com:kreta-io/User.git user:master
git push git@github.com:kreta-io/User.git user:master --follow-tags
git branch -D user
git tag -d $1

git subtree split -P src/Kreta/Component/VCS/ -b vcs
git tag -a $1 -m $1 vcs
git push git@github.com:kreta-io/VCS.git vcs:master
git push git@github.com:kreta-io/VCS.git vcs:master --follow-tags
git branch -D vcs
git tag -d $1

git subtree split -P src/Kreta/Component/Workflow/ -b workflow
git tag -a $1 -m $1 workflow
git push git@github.com:kreta-io/Workflow.git workflow:master
git push git@github.com:kreta-io/Workflow.git workflow:master --follow-tags
git branch -D workflow
git tag -d $1

git fetch --tags
echo "DONE!"
