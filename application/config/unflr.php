<?php

return [
	
	'mailFrom' => [
		'address' => 'contact@unflare.com', 
		'name'    => 'Unflare',
	],

	'referralsCountForSuccess'  => 2,
	'minutesBeforeWelcomeEmail' => 0,

	'emails' => [
		'welcome' => [
			'subject' => __('Your referral link'),
		],
		'referralNotif' => [
			'subject'        => __('%%d / %%d - Almost there!'),
		],
		'referralSuccess' => [
			'subject' => __('%%d / %%d - Referrals success!'),
		],
	],

	'marketing' => [
		'description' => __('description'),
		'keywords'    => __('keywords'),
	],
	
	'javascript' => [
		'debug'     => DEBUG,
		'assetsURL' => ASSETS_URL,

		'analytics' => [
			'google' => GOOGLE_ANALYTICS,
		],

	],

];
