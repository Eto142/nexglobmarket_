SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `admins`;
TRUNCATE TABLE `debitprofits`;
TRUNCATE TABLE `deposits`;
TRUNCATE TABLE `earnings`;
TRUNCATE TABLE `failed_jobs`;
TRUNCATE TABLE `kycs`;
TRUNCATE TABLE `notifications`;
TRUNCATE TABLE `photos`;
TRUNCATE TABLE `plans`;
TRUNCATE TABLE `profits`;
TRUNCATE TABLE `refferals`;
TRUNCATE TABLE `traders`;
TRUNCATE TABLE `transactions`;
TRUNCATE TABLE `users`;
TRUNCATE TABLE `withdrawals`;
TRUNCATE TABLE `password_reset_tokens`;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
INSERT INTO `debitprofits` (`id`, `user_id`, `transaction_id`, `amount`, `created_at`, `updated_at`) VALUES
INSERT INTO `deposits` (`id`, `user_id`, `transaction_id`, `amount`, `bot`, `payment_method`, `trading_name`, `image`, `status`, `created_at`, `updated_at`) VALUES
INSERT INTO `earnings` (`id`, `user_id`, `transaction_id`, `amount`, `type`, `narration`, `created_at`, `updated_at`) VALUES
INSERT INTO `kycs` (`id`, `user_id`, `idcard`, `passport`, `status`, `created_at`, `updated_at`) VALUES
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
INSERT INTO `plans` (`id`, `user_id`, `transaction_id`, `amount`, `plan_name`, `plan_duration`, `created_at`, `updated_at`) VALUES
INSERT INTO `profits` (`id`, `user_id`, `transaction_id`, `plan_name`, `amount`, `plan_type`, `created_at`, `updated_at`) VALUES
INSERT INTO `refferals` (`id`, `user_id`, `transaction_id`, `amount`, `created_at`, `updated_at`) VALUES
INSERT INTO `traders` (`id`, `name`, `image`, `win_rate`, `profit_share`, `copier`, `gains`, `risk`, `loss`, `commission`, `total_transactions`, `created_at`, `updated_at`) VALUES
INSERT INTO `transactions` (`id`, `user_id`, `transaction_id`, `transaction_type`, `transaction`, `credit`, `debit`, `status`, `created_at`, `updated_at`) VALUES
INSERT INTO `transactions` (`id`, `user_id`, `transaction_id`, `transaction_type`, `transaction`, `credit`, `debit`, `status`, `created_at`, `updated_at`) VALUES
INSERT INTO `transactions` (`id`, `user_id`, `transaction_id`, `transaction_type`, `transaction`, `credit`, `debit`, `status`, `created_at`, `updated_at`) VALUES
INSERT INTO `users` (`id`, `name`, `lname`, `currency`, `email`, `phone`, `country`, `state`, `pcode`, `photo`, `dob`, `pin`, `address`, `usertype`, `eth_address`, `btc_address`, `usdt_address`, `btcImage`, `ethImage`, `usdtImage`, `signal_strength`, `update_escrow`, `update_notification`, `id_card`, `user_status`, `passport`, `kyc_status`, `is_activated`, `bot_image`, `withdrawal_code`, `withdrawal_amount`, `withdrawal_tax_amount`, `withdrawal_percentage`, `bot_status`, `token`, `withdrawal_tax_code`, `profit_limit_status`, `email_verified_at`, `password`, `show_password`, `remember_token`, `created_at`, `updated_at`) VALUES
INSERT INTO `users` (`id`, `name`, `lname`, `currency`, `email`, `phone`, `country`, `state`, `pcode`, `photo`, `dob`, `pin`, `address`, `usertype`, `eth_address`, `btc_address`, `usdt_address`, `btcImage`, `ethImage`, `usdtImage`, `signal_strength`, `update_escrow`, `update_notification`, `id_card`, `user_status`, `passport`, `kyc_status`, `is_activated`, `bot_image`, `withdrawal_code`, `withdrawal_amount`, `withdrawal_tax_amount`, `withdrawal_percentage`, `bot_status`, `token`, `withdrawal_tax_code`, `profit_limit_status`, `email_verified_at`, `password`, `show_password`, `remember_token`, `created_at`, `updated_at`) VALUES
INSERT INTO `users` (`id`, `name`, `lname`, `currency`, `email`, `phone`, `country`, `state`, `pcode`, `photo`, `dob`, `pin`, `address`, `usertype`, `eth_address`, `btc_address`, `usdt_address`, `btcImage`, `ethImage`, `usdtImage`, `signal_strength`, `update_escrow`, `update_notification`, `id_card`, `user_status`, `passport`, `kyc_status`, `is_activated`, `bot_image`, `withdrawal_code`, `withdrawal_amount`, `withdrawal_tax_amount`, `withdrawal_percentage`, `bot_status`, `token`, `withdrawal_tax_code`, `profit_limit_status`, `email_verified_at`, `password`, `show_password`, `remember_token`, `created_at`, `updated_at`) VALUES
INSERT INTO `users` (`id`, `name`, `lname`, `currency`, `email`, `phone`, `country`, `state`, `pcode`, `photo`, `dob`, `pin`, `address`, `usertype`, `eth_address`, `btc_address`, `usdt_address`, `btcImage`, `ethImage`, `usdtImage`, `signal_strength`, `update_escrow`, `update_notification`, `id_card`, `user_status`, `passport`, `kyc_status`, `is_activated`, `bot_image`, `withdrawal_code`, `withdrawal_amount`, `withdrawal_tax_amount`, `withdrawal_percentage`, `bot_status`, `token`, `withdrawal_tax_code`, `profit_limit_status`, `email_verified_at`, `password`, `show_password`, `remember_token`, `created_at`, `updated_at`) VALUES
INSERT INTO `withdrawals` (`id`, `user_id`, `transaction_id`, `amount`, `mode`, `email`, `crypto_type`, `status`, `created_at`, `updated_at`, `account_name`, `account_number`, `bank_country`, `trading_name`, `swift`, `bank_routing_number`, `bank_name`, `account_type`, `wallet_address`, `ssn`) VALUES
INSERT INTO `withdrawals` (`id`, `user_id`, `transaction_id`, `amount`, `mode`, `email`, `crypto_type`, `status`, `created_at`, `updated_at`, `account_name`, `account_number`, `bank_country`, `trading_name`, `swift`, `bank_routing_number`, `bank_name`, `account_type`, `wallet_address`, `ssn`) VALUES
COMMIT;
