<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = [
    // Capability to manage all platform learning paths.
    'local/csvmailstatus:viewpages' => [
        'captype'      => 'read',
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
        )
    ],
    
    
];