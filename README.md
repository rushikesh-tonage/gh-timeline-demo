# GH Timeline Demo
This is a sample public GitHub repository used to demonstrate how to track GitHub activity and send notifications via email using a PHP-based cron system.

## 🔔 Use Case
Every time public activity is posted (push, star, fork, etc.), a background PHP script fetches this data from the GitHub Events API and emails the update to subscribers.

## ⚙️ Stack
- PHP
- PHPMailer
- GitHub API
- MailHog (for email testing)
- CRON job

## 🚀 How It Works
- User signs up and verifies email
- Subscribed emails are saved in `registered_emails.txt`
- PHP cron job runs every 5 minutes and fetches latest GitHub activity
- If new activity is found, subscribers are notified via email


