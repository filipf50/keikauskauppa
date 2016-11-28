Newsletter Enhancements v3.6.8

* Fixed problem with newsletter attachments.
* Internal fixes and improvements for stability.



Newsletter Enhancements v3.6.7

* Added lockout to queue to prevent sending newsletter multiply times on some systems.
* Fixed bug when extra head content was not added when throttle feature is active.
* Other fixes and improvements for stability.



Newsletter Enhancements v3.6.6

* Fixed bug when sending spam check email.
* Fixed bug with throttle feature when on some systems emails was not sent.
* Fixed bug when extra head content was not added when throttle feature is active.
* Fixed bug with subscribe modal popup when it block websites content.
* Other fixes and improvements for stability.



Newsletter Enhancements v3.6.5

* Fixed bug with throttle feature.
* Added possibility to define text version of message in newsletter templates.
* Other fixes and improvements for stability.



Newsletter Enhancements v3.6.4

* Improved sending process.
* Fixed bug which appeared on some configurations when newsletter was sent few times to recipient.
* Added PHPMailer options to custom mail configuration.
* Added possibility to set text version of message.
* Added field for possibility to add custom head entries (styles, fonts, meta) for templates.
* Added option to hide marketing lists in frontend.
* Other fixes and improvements for stability.



Newsletter Enhancements v3.6.3

* Reworked and improved subscription section.
* Other fixes and improvements for stability.



Newsletter Enhancements v3.6.2

* Added possibility to style subscribe modal popup and add image to it.
* Marketing lists fixes.
* Other fixes and improvements for stability.



Newsletter Enhancements v3.6.1

* Added blacklist feature.
* Added indication of selected language in email lists.
* Bug fixes and improvements.



Newsletter Enhancements v3.6.0

* Newsletter recipients can select in which language they want receive newsletters. Newsletters can be sent by languages (optionally). Current customers who have customized templates: {language} tag should be added to template to see flags for language selection in newsletter.
* Added option for Modal popup to display it only once for visitor.
* Added possibility to select currency which will be used in newsletter.
* Added new recipient types: "Reward points: All customers" and "Reward points: Subscribed customers".
* Added {reward} personalization tag. Possible to notify customers with reward points. Only available for recipients "Reward points: All/Subscribed customers".
* Added possibility to send only to subscribed customers of customer group when sending newsletter to customer group.
* Added possibility to show % of discount. It can be configured in templates section.
* Options with one value in list is not displayed anymore.
* Updated cron command, with new command cron job will be executed silently. Result files will not be created on your server.
* Bug fixes and improvements.



Newsletter Enhancements v3.5.0

* Added ability to show marketing subscribe box for registered and guests visitors.
* Added ability to add multiply defined products sections.
* Activated Licence check.
* Fixed UTF-8 bug on some server configurations.
* Other bug fixes and improvements.



Newsletter Enhancements v3.4.9

* Added ability to add bulk products from selected categories.
* Fixed bug with custom template images.
* Other bug fixes and improvements.



Newsletter Enhancements v3.4.8

* Fixed scheduled newsletter bug, where defined products was not added to newsletter when "recurrent" option was "Off".



Newsletter Enhancements v3.4.7

* Added ability to configure custom mail settings for module.



Newsletter Enhancements v3.4.6

* Added export CSV feature for marketing list.
* Added Christmas modal popup theme.
* Added module update check.
* Fixed customer group product prices.
* Fixed subscribe and unsubscribe newsletter links.
* Bug fixes and improvements.



Newsletter Enhancements v3.4.5

* Added IsNotSpam.com check.
* Added support menu option.
* Added compatibility to more servers configurations.
* Bug fixes and improvements.



Newsletter Enhancements v3.4.4

* Bug fixes and improvements.



Newsletter Enhancements v3.4.3

* Additional encoding of link parameters.
* Store url fix for SSL enabled stores.
* Description length set to 0 will disable description.
* Subscribe modal box - added "Thanks for subscribing" message.
* Other bug fixes and improvements.



Newsletter Enhancements v3.4.2

* Fixed UTF-8 problem which may appear on some server configurations



Newsletter Enhancements v3.4.1

* Fixed module installation on multi language stores.



Newsletter Enhancements v3.4

* Added failed to send newsletters count
* Added 'retries' option for failed newsletters
* Improved post-installation configuration for multi-language stores
* Fixed newsletter recipients, all newsletter recipients now divided by store, except manual selected customers
* All recipients now support personalization

For updating from previous version: replace all files and run upgrade.php