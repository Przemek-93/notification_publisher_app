## Result
### 1. Send notifications via different channels:
- [x] Provide an abstraction between at least two different messaging service providers.
- [x] Use different messaging services/technologies for communication (e.g., SMS, email, push notification, Facebook Messenger, etc.).

### 2. Failover support:
- [x] If one of the services goes down, your service should quickly failover to a different provider without affecting your customers.
- [x] Define several providers for the same type of notification channel (e.g., two providers for SMS).
- [ ] Delay and resend notifications if all providers fail.

### 3. Configuration-driven:
- [x] Enable/disable different communication channels via configuration.
- [x] Send the same notification via several different channels.

### 4. (Bonus) Throttling:
- [x] Some messages are expected to trigger a user response. In such a case the service should allow a limited amount of notifications sent to users within an hour. e.g. send up to 300 an hour.

### 5. (Bonus) Usage tracking:
- [ ] Track which messages were sent, when, and to whom, using a user identifier parameter.

## Notes
The task was completed using two concepts:
- The first concept is available on the `concept-1` branch. It involves manual integrations with message providers and the use of the Strategy design pattern.
- The second concept is available on the `master` and `concept-2` branches and is based on `symfony/notifier` package.

I approached it this way because while building the solution from scratch `concept-1`. \
I realized after some time that I could use a dedicated library, so I wanted to present this option to you as well.

## Integrations
The integrations were based on `Twilio, SendGrid,` and `MailerSend`. \
To verify that the integrations are working correctly, you need to add the appropriate `DSN` keys for the providers in the `.env` file. \
This file also contains the definitions for enabling the individual channels. Everything can be found in the block labeled `###> Notification channels ###`. \
A command for testing purposes has also been added: `bin/console notification:send`.

## Tests and static analysis
`Psalm` and `Code Sniffer` have been added to the project, normally i used `PHPMD, PHPSTAN, Deptrac` as well.
`Unit tests` are added to master branch and solution based on `symfony/notifier`.

## Testing functionality
I added the command `bin/console notification:send` with hard coding notification data for testing purposes, after filling in all variables in `.env` you can test the functionality.
Keep in mind changing recipient hard coded data before use command.