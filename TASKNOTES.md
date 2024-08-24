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