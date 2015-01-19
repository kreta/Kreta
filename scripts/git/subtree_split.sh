#!/bin/sh

# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

echo "Generating the subtree splits..."

git subtree split -P src/Kreta/Bundle/ApiBundle/ -b api-bundle
git push git@github.com:kreta-io/ApiBundle.git api-bundle:master
git branch -D api-bundle

git subtree split -P src/Kreta/Bundle/CommentBundle/ -b comment-bundle
git push git@github.com:kreta-io/CommentBundle.git comment-bundle:master
git branch -D comment-bundle

git subtree split -P src/Kreta/Bundle/CoreBundle/ -b core-bundle
git push git@github.com:kreta-io/CoreBundle.git core-bundle:master
git branch -D core-bundle

git subtree split -P src/Kreta/Bundle/FixturesBundle/ -b fixtures-bundle
git push git@github.com:kreta-io/FixturesBundle.git fixtures-bundle:master
git branch -D fixtures-bundle

git subtree split -P src/Kreta/Bundle/IssueBundle/ -b issue-bundle
git push git@github.com:kreta-io/IssueBundle.git issue-bundle:master
git branch -D issue-bundle

git subtree split -P src/Kreta/Bundle/MediaBundle/ -b media-bundle
git push git@github.com:kreta-io/MediaBundle.git media-bundle:master
git branch -D media-bundle

git subtree split -P src/Kreta/Bundle/NotificationBundle/ -b notification-bundle
git push git@github.com:kreta-io/NotificationBundle.git notification-bundle:master
git branch -D notification-bundle

git subtree split -P src/Kreta/Bundle/ProjectBundle/ -b project-bundle
git push git@github.com:kreta-io/ProjectBundle.git project-bundle:master
git branch -D project-bundle

git subtree split -P src/Kreta/Bundle/UserBundle/ -b user-bundle
git push git@github.com:kreta-io/UserBundle.git user-bundle:master
git branch -D user-bundle

git subtree split -P src/Kreta/Bundle/VCSBundle/ -b vcs-bundle
git push git@github.com:kreta-io/VCSBundle.git vcs-bundle:master
git branch -D vcs-bundle

git subtree split -P src/Kreta/Bundle/WebBundle/ -b web-bundle
git push git@github.com:kreta-io/WebBundle.git web-bundle:master
git branch -D web-bundle

git subtree split -P src/Kreta/Bundle/WorkflowBundle/ -b workflow-bundle
git push git@github.com:kreta-io/WorkflowBundle.git workflow-bundle:master
git branch -D workflow-bundle

git subtree split -P src/Kreta/Component/Comment/ -b comment
git push git@github.com:kreta-io/Comment.git comment:master
git branch -D comment

git subtree split -P src/Kreta/Component/Core/ -b core
git push git@github.com:kreta-io/Core.git core:master
git branch -D core

git subtree split -P src/Kreta/Component/Issue/ -b issue
git push git@github.com:kreta-io/Issue.git issue:master
git branch -D issue

git subtree split -P src/Kreta/Component/Media/ -b media
git push git@github.com:kreta-io/Media.git media:master
git branch -D media

git subtree split -P src/Kreta/Component/Notification/ -b notification
git push git@github.com:kreta-io/Notification.git notification:master
git branch -D notification

git subtree split -P src/Kreta/Component/Project/ -b project
git push git@github.com:kreta-io/Project.git project:master
git branch -D project

git subtree split -P src/Kreta/Component/User/ -b user
git push git@github.com:kreta-io/User.git user:master
git branch -D user

git subtree split -P src/Kreta/Component/VCS/ -b vcs
git push git@github.com:kreta-io/VCS.git vcs:master
git branch -D vcs

git subtree split -P src/Kreta/Component/Workflow/ -b workflow
git push git@github.com:kreta-io/Workflow.git workflow:master
git branch -D workflow

echo "DONE!"
